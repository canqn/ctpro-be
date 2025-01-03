<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MachineLicense;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class MachineLicenseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index']]);
    }
    /**
     * Lấy danh sách machine license của user
     */
    public function getUserMachineLicenses()
    {
        $user = auth('api')->user();

        if (!$user) {
            return response()->json([
                'message' => 'Không có quyền truy cập'
            ], 401);
        }

        try {
            $licenses = MachineLicense::where('user_id', $user->id)
                ->with('taxLicenses')
                ->get();

            return response()->json([
                'message' => 'Lấy danh sách máy thành công',
                'machine_licenses' => $licenses
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error getting user machine licenses: ' . $e->getMessage());
            return response()->json([
                'message' => 'Lỗi khi lấy danh sách máy',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function create(Request $request)
    {
        // Lấy thông tin người dùng hiện tại
        $user = auth('api')->user();

        // Nếu không tìm thấy người dùng, trả về lỗi Unauthorized
        if (!$user) {
            return response()->json([
                'status' => 401,
                'message' => 'Không có quyền truy cập',
            ], 401);
        }
        $userId = $user->id;

        $validator = Validator::make($request->all(), [
            //'user_id' => 'required|exists:users,id',
            'machine_name' => 'required|string|max:255',
            'machine_key' => 'required|string',
            'machine_details' => 'required|array',
            'machine_details.cpu_id' => 'nullable|string',
            'machine_details.motherboard_serial' => 'nullable|string',
            'machine_details.hard_drive_serial' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Xác thực dữ liệu thất bại',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            // Kiểm tra machine_key đã được sử dụng bởi user khác chưa
            // $existingLicense = MachineLicense::where('machine_key', $request->machine_key)
            //     ->where('user_id', '!=', $userId)
            //     ->first();

            // if ($existingLicense) {
            //     return response()->json([
            //         'message' => 'Mã máy này đã được đăng ký bởi người dùng khác',
            //         'status' => 'error'
            //     ], 400);
            // }

            // Kiểm tra xem user hiện tại đã có license với machine_key này chưa
            $userExistingLicense = MachineLicense::where('machine_key', $request->machine_key)
                ->where('user_id', $userId)
                ->first();

            if ($userExistingLicense) {
                return response()->json([
                    'message' => 'Bạn đã đăng ký mã máy này trước đó',
                    'status' => 'error'
                ], 400);
            }

            // Tạo license máy
            $machineLicense = MachineLicense::create([
                'user_id' => $userId,
                'machine_key' => $request->machine_key,
                // 'machine_key' => MachineLicense::generateMachineKey(),
                'machine_name' => $request->machine_name,
                'machine_fingerprint' => (new MachineLicense())->generateFingerprint($request->machine_details),
                'machine_details' => $request->machine_details,
                'status' => 'active',
                'last_activated_at' => now(),
                'expires_at' => now()->addYear()
            ]);

            return response()->json([
                'status' => 'active',
                'message' => 'Đăng ký máy thành công',
                'machine_license' => $machineLicense
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Lỗi khi đăng ký máy',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Xác thực license máy
    public function verify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'machine_key' => 'required|string|exists:machine_licenses,machine_key',
            'machine_details' => 'required|array',
            'machine_details.cpu_id' => 'nullable|string',
            'machine_details.motherboard_serial' => 'nullable|string',
            'machine_details.hard_drive_serial' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            // Tìm license máy
            $machineLicense = MachineLicense::where('machine_key', $request->machine_key)->first();

            // Kiểm tra trạng thái license
            if (!$machineLicense->isActive()) {
                return response()->json([
                    'message' => 'License is not active',
                    'status' => $machineLicense->status
                ], 403);
            }

            // Xác thực dấu vân tay máy
            if (!$machineLicense->verifyFingerprint($request->machine_details)) {
                return response()->json([
                    'message' => 'Machine fingerprint does not match',
                ], 403);
            }

            return response()->json([
                'message' => 'Machine license verified successfully',
                'machine_license' => $machineLicense
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error verifying machine license',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function checkActivationStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'machine_key' => 'required|string|exists:machine_licenses,machine_key'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'is_activated' => false,
                'message' => 'Key không tim thấy trong hệ thống',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            // Tìm license máy theo machine_key
            $machineLicense = MachineLicense::where('machine_key', $request->machine_key)
                ->with('user') // Load thông tin user nếu cần
                ->first();

            if (!$machineLicense) {
                return response()->json([
                    'message' => 'License not found',
                    'is_activated' => false
                ], 404);
            }

            // Kiểm tra trạng thái và thời hạn
            $isActive = $machineLicense->status === 'active'
                && $machineLicense->expires_at
                && $machineLicense->expires_at->isFuture();

            return response()->json([
                'message' => 'License status retrieved successfully',
                'data' => [
                    'is_activated' => $isActive,
                    'status' => $machineLicense->status,
                    'expires_at' => $machineLicense->expires_at,
                    'last_activated_at' => $machineLicense->last_activated_at,
                    'machine_name' => $machineLicense->machine_name,
                    'user_id' => $machineLicense->user_id
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error checking license status',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
