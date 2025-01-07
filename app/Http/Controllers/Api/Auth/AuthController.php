<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\UserResource;
use App\Models\Account;
use App\Models\Download;
use App\Models\DownloadLimit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        return UserResource::collection(User::all());
    }

    public function show($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        return new UserResource($user);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required|min:6',
        ]);

        // Kiểm tra nếu có lỗi xác thực
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 402);
        }
        $user = User::where('username', $request->username)->first();

        if (!$token = auth('api')->attempt($validator->validated())) {
            return response()->json(['message' => 'The Provided Credentials are incorrect', 'code' => 401], 401);
        }
        $userId = $user->id;

        $downloadBought = Download::selectRaw('sum(total_download) as total_downloads')
            ->where('user_id', $userId)
            ->groupBy('user_id')
            ->pluck('total_downloads')
            ->first();

        $downloadLimit = DownloadLimit::selectRaw('sum(download_limit) as download_limit')
            ->where('user_id', $userId)
            ->groupBy('user_id')
            ->pluck('download_limit')
            ->first();
        //$downloads = ['downloads' => $countDownload];

        // Thiết lập cookie cho token
        $cookie = Cookie::make('jwt', $token, config('auth.token_lifetime'));

        // Trả về response với thông tin người dùng và token, cũng như cookie được thiết lập
        return response()->json([
            'user' => $user,
            'downloadBought' =>  $downloadBought,
            'downloadLimit' => $downloadLimit,
            'token' => $token
        ])->withCookie($cookie);
        // return $this->respondWithToken(200, 'login successful', $user, '');
    }


    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8', // Enforce minimum password length
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422); // Unprocessable Entity
        }

        try {
            $data = $request->only('username', 'email');
            $data['password'] = bcrypt($request->password);

            $user = User::create($data);

            return response()->json([
                'message' => 'Registration Successful',
                'user' => $user,
                'status' => 'success'
            ], 201); // Created

        } catch (\Exception $e) {
            // Catch any other unexpected exceptions
            report($e);

            return response()->json([
                'message' => 'An unknown error occurred during registration.',
                'status' => 'failed'
            ], 500); // Internal Server Error (generic for unexpected issues)
        }
    }

    public function profile()
    {
        try {
            $loggeduser = auth()->user();
            $user_id = $loggeduser->id;
            $info = Account::with('user')
                ->where('user_id', $user_id)
                ->get('user_id');

            $loggeduser = (new UserResource($loggeduser))
                ->additional(['info' => $info])
                ->response()
                ->getData(true);
            return response([
                'code' => 200,
                'status' => 'success',
                'msg' => 'Logged User Data',
                'data' => $loggeduser,
            ], 200);
        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Something went wrong while fetching the profile'
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function logout(Request $request)
    {
        auth()->logout();

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function change_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required|string|min:6',
            'new_password' => 'required|string|confirmed|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $userId = auth()->user()->id;

        $user = User::where('id', $userId)->update(
            ['password' => bcrypt($request->new_password)]
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Password Changed Successfully',
            'user' => $user

        ], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh(Request $request)
    {
        $request->validate(['refreshToken' => 'required']);
        $refreshToken = $request->refreshToken;

        try {
            $decode = JWTAuth::getJWTProvider()->decode($refreshToken);

            // Kiểm tra xem refresh token đã hết hạn hay không
            if ($decode['exp'] < time()) {
                throw new \Tymon\JWTAuth\Exceptions\TokenExpiredException('Refresh token has expired');
            }

            $user = User::find($decode['userId']);

            if (!$user) {
                throw new \Exception('User not found');
            }

            // $donvi = $user->donvi;
            // $info = $user->with('donvi')->where('donvi', $donvi)->select('donvi')->get();


            if (!JWTAuth::parseToken()->check() && auth()->user()) {
                throw new \Tymon\JWTAuth\Exceptions\TokenInvalidException('Access token is invalid');
            }

            // Kiểm tra access token còn hạn không
            if (JWTAuth::parseToken()->check()) {
                // Hủy bỏ access token nếu còn hạn
                JWTAuth::parseToken()->invalidate();
                // auth('api')->invalidate();
            }

            // Tạo token mới
            $token = auth('api')->login($user);

            if ($token) {
                JWTAuth::setToken($refreshToken)->invalidate();
            }
            // Tạo refresh token mới
            $refreshToken = $this->createRefreshToken();

            // Trả về response với token mới và thông tin của user
            $userResponse = (new UserResource($user))
                ->additional(['token' => $token, 'user' => $user])
                ->response()
                ->getData(true);

            return $this->respondWithToken(200, 'Created refreshToken successful', $userResponse, $refreshToken);
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['error' => 'Token has expired'], 403);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['error' => 'Token is invalid'], 401);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    protected function respondWithToken(int $code, string $message, ?array $resource = [], string $refreshToken = '')
    {
        $result =  [
            'code' => $code,
            'msg' => $message,
        ];

        if (count($resource))
            $result = array_merge(
                $result,
                [
                    'data' => $resource['data'],
                    'accessToken' => $resource['token'],
                    // 'refreshToken' => $resource['refreshToken'],
                    // 'refreshToken' => $refreshToken,
                    'token_type' => 'bearer',
                    'expires_in' => auth()->factory()->getTTL() * 60
                ]
            );

        return response()->json($result);
    }

    private function createRefreshToken()
    {
        $customClaims = [
            'sub' => null,
            'userId' => auth()->user()->id,
            'random' => rand() . time(),
            //'role' => auth()->user()->role,
            // 'exp' => strtotime('+ 10080  minute'),
            'exp' => time() + config('jwt.refresh_ttl')
        ];

        $refreshToken = JWTAuth::getJWTProvider()->encode($customClaims);
        return $refreshToken;
    }
}
