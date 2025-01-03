<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Download;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreDownloadRequest;
use App\Http\Requests\UpdateDownloadRequest;
use App\Http\Resources\V1\DownloadResource;
use App\Models\DownloadLimit;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use ErrorException;
use Illuminate\Http\Request;

class DownloadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'me', 'show']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Lấy thông tin người dùng hiện tại
        $user = auth('api')->user();

        // Nếu không tìm thấy người dùng, trả về thông báo lỗi
        if (!$user) {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized',
            ], 401);
        }

        // Lấy dữ liệu download theo user_id
        $downloads = Download::where('user_id', $user->id)->get();

        // Kiểm tra dữ liệu và trả về phản hồi
        if ($downloads->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'No records found',
            ], 404);
        }

        // Trả về danh sách dữ liệu với Resource
        return response()->json([
            'status' => 200,
            'data' => DownloadResource::collection($downloads),
        ], 200);
    }

    public function me()
    {
        // Lấy thông tin người dùng hiện tại
        $user = auth('api')->user();

        // Nếu không tìm thấy người dùng, trả về lỗi Unauthorized
        if (!$user) {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized',
            ], 401);
        }
        $userId = $user->id;
        $data = Download::where('user_id', $userId)->get();

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

        if ($data->count() > 0) {
            return response([
                'status' => 200,
                'user' => $user,
                'downloadBought' =>  $downloadBought,
                'downloadLimit' => $downloadLimit,
                //'token' => $token
            ], 200);
        } else {
            return response([
                'status' => 404,
                'message' => 'No Record found',
            ], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'total_download' => 'required|integer|max:191',
            'driver_info' => 'sometimes|string|max:191',
            'driver_id' => 'sometimes|integer|max:191',  // Uncomment if required
            'account_id' => 'sometimes|integer|max:191',  // Uncomment if required
            'download_date' => 'sometimes|date|max:191', // Uncomment if required
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        }

        $user = auth('api')->user(); // Assuming Laravel Sanctum or Passport
        $userId = $user->id;
        $data = Download::create([
            'total_download' => $request->total_download,
            'user_id' => $user ? $user->id : $request->user_id, // Set user_id only if user is authenticated
            'account_id' => $request->account_id, // Uncomment if required
            'driver_id' => $request->driver_id,
            'driver_info' => $request->driver_info,
            'download_date' => $request->download_date,
        ]);

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

        return response()->json([
            'status' => 201, // Created (more specific than 200)
            'message' => 'Download created successfully',
            'data' => $data,
            'downloadBought' =>  $downloadBought,
            'downloadLimit' => $downloadLimit,
        ], 201);
        // $user = auth('api')->user();
        // $userId = $user->id;

        // $requestData = $request->all();
        // $requestData['user_id'] = $user ? $userId : $request->user_id;
        // $data = Download::create($requestData);

        // $result = (new DownloadResource($data))
        //     ->response()
        //     ->getData(true);

        // return $this->wrapResponse(Response::HTTP_CREATED, "downlad thanh cong", $result);
    }
}
