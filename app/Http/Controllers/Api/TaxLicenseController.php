<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MachineLicense;
use App\Models\TaxLicense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TaxLicenseController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:api', ['except' => ['index']]);
    // }
    /**
     * Display a listing of the resource.
     */
    public function index() {}

    // Thêm mã số thuế vào license máy
    public function addTaxLicense(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'machine_key' => 'required|exists:machine_licenses,machine_key',
            'tax_code' => 'required|unique:tax_licenses,tax_code',
            'business_name' => 'nullable|string|max:255',
            'max_devices' => 'integer|min:1|max:10',
            'expiry_date' => 'nullable|date|after:today'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            // Tìm machine license
            $machineLicense = MachineLicense::where('machine_key', $request->machine_key)->first();

            // Tạo tax license
            $taxLicense = $machineLicense->taxLicenses()->create([
                'tax_code' => $request->tax_code,
                'business_name' => $request->business_name,
                'status' => 'active',
                'registration_date' => now(),
                'activation_date' => now(),
                'expiry_date' => $request->expiry_date ?? now()->addYear(),
                'max_devices' => $request->max_devices ?? 1,
                'current_devices' => 0
            ]);

            return response()->json([
                'message' => 'Tax license added successfully',
                'tax_license' => $taxLicense
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error adding tax license',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Kích hoạt license cho mã số thuế
    public function activateTaxLicense(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'machine_key' => 'required|exists:machine_licenses,machine_key',
            'tax_code' => 'required|exists:tax_licenses,tax_code',
            'device_identifier' => 'required|string|unique:license_activation_logs,device_identifier'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            // Tìm machine license
            $machineLicense = MachineLicense::where('machine_key', $request->machine_key)->first();

            // Tìm tax license
            $taxLicense = $machineLicense->taxLicenses()
                ->where('tax_code', $request->tax_code)
                ->first();

            // Kích hoạt license
            $taxLicense->activate($request->device_identifier);

            return response()->json([
                'message' => 'Tax license activated successfully',
                'tax_license' => $taxLicense
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error activating tax license',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Hủy kích hoạt license
    public function deactivateTaxLicense(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'machine_key' => 'required|exists:machine_licenses,machine_key',
            'tax_code' => 'required|exists:tax_licenses,tax_code',
            'device_identifier' => 'required|string|exists:license_activation_logs,device_identifier'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            // Tìm machine license
            $machineLicense = MachineLicense::where('machine_key', $request->machine_key)->first();

            // Tìm tax license
            $taxLicense = $machineLicense->taxLicenses()
                ->where('tax_code', $request->tax_code)
                ->first();

            // Hủy kích hoạt license
            $taxLicense->deactivate($request->device_identifier);

            return response()->json([
                'message' => 'Tax license deactivated successfully',
                'tax_license' => $taxLicense
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error deactivating tax license',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Tra cứu thông tin license
    public function getLicenseInfo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'machine_key' => 'required|exists:machine_licenses,machine_key',
            'tax_code' => 'nullable|exists:tax_licenses,tax_code'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'is_activated' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            // Tìm machine license
            $machineLicenseTaxCode = MachineLicense::where('machine_key', $request->machine_key)->first();
            // Kiểm tra trạng thái active_taxcode
            if ($machineLicenseTaxCode && $machineLicenseTaxCode->active_taxcode === 'active') {
                return response()->json([
                    'is_active' => true,
                    'message' => 'The active_taxcode is active.',
                ], 200);
            }

            // Kiểm tra active_taxcode
            if ($machineLicenseTaxCode->isActiveTaxCode()) {
                return response()->json([
                    'is_activated' => true,
                    'message' => 'The tax code is active.',
                    'status' => $machineLicenseTaxCode->active_taxcode
                ], 200);
            }
            // Tìm machine license
            $machineLicense = MachineLicense::where('machine_key', $request->machine_key)
                ->with(['taxLicenses' => function ($query) use ($request) {
                    if ($request->has('tax_code')) {
                        $query->where('tax_code', $request->tax_code);
                    }
                }])
                ->first();

            return response()->json([
                'is_activated' => true,
                'machine_license' => $machineLicense,
                'tax_licenses' => $machineLicense->taxLicenses
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'is_activated' => false,
                'message' => 'Error retrieving license information',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function checkTaxCodeStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'machine_key' => 'required|exists:machine_licenses,machine_key',
            // 'tax_code' => 'required|exists:tax_licenses,tax_code'
            'tax_code' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'is_active' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            // Tìm machine license và kiểm tra trạng thái
            $machineLicense = MachineLicense::where('machine_key', $request->machine_key)->first();

            if (!$machineLicense) {
                return response()->json([
                    'is_active' => false,
                    'message' => 'Machine license not found'
                ], 404);
            }

            $machineLicenseExpiry = MachineLicense::where('machine_key', $request->machine_key)
                ->where(function ($query) {
                    $query->whereNull('expires_at')
                        ->orWhere('expires_at', '>', now());
                })
                ->first();

            if (!$machineLicenseExpiry) {
                return response()->json([
                    'is_active' => false,
                    'message' => 'Máy đăng ký hết hạn sử dụng'
                ], 404);
            }

            // Kiểm tra trạng thái của machine license
            if ($machineLicense->active_taxcode === 'active') {
                return response()->json([
                    'is_active' => true,
                    'message' => 'Giấy phép máy đã kích hoạt mã số thuế'
                ], 200);
            }

            // Tìm tax license
            $taxLicense = TaxLicense::where('tax_code', $request->tax_code)
                ->where(function ($query) {
                    $query->whereNull('expiry_date')
                        ->orWhere('expiry_date', '>', now());
                })
                ->first();

            if (!$taxLicense) {
                return response()->json([
                    'is_active' => false,
                    'message' => 'Không tìm thấy mã số thuế hoặc đã hết hạn'
                ], 404);
            }

            // Kiểm tra trạng thái và điều kiện của tax license
            $validationResult = $this->validateTaxLicense($taxLicense);

            return response()->json([
                'is_active' => $validationResult['is_valid'],
                'message' => $validationResult['message'],
                'tax_license' => [
                    'tax_code' => $taxLicense->tax_code,
                    'status' => $taxLicense->status,
                    'current_devices' => $taxLicense->current_devices,
                    'max_devices' => $taxLicense->max_devices,
                    'expiry_date' => $taxLicense->expiry_date,
                ]
            ], $validationResult['is_valid'] ? 200 : 403);
        } catch (\Exception $e) {
            return response()->json([
                'is_active' => false,
                'message' => 'Lỗi kiểm tra trạng thái mã số thuế',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Validation tax license
     */
    private function validateTaxLicense($taxLicense)
    {
        if ($taxLicense->status !== 'active') {
            return [
                'is_valid' => false,
                'message' => 'Mã số thuế không hoạt động'
            ];
        }

        if ($taxLicense->current_devices >= $taxLicense->max_devices) {
            return [
                'is_valid' => false,
                'message' => 'Đã đạt giới hạn số thiết bị tối đa'
            ];
        }

        if ($taxLicense->expiry_date && $taxLicense->expiry_date <= now()) {
            return [
                'is_valid' => false,
                'message' => 'Mã số thuế đã hết hạn'
            ];
        }

        return [
            'is_valid' => true,
            'message' => 'Mã số thuế đang hoạt động và hợp lệ'
        ];
    }
}
