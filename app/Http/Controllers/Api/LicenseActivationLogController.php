<?php

namespace App\Http\Controllers\Api;

use App\Models\LicenseActivationLog;
use Illuminate\Http\Request;
use App\Models\MachineLicense;
use App\Models\TaxLicense;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class LicenseActivationLogController extends Controller
{
    // Lấy nhật ký kích hoạt
    public function getActivationLogs(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'machine_key' => 'required|exists:machine_licenses,machine_key',
            'tax_code' => 'nullable|exists:tax_licenses,tax_code',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date'
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

            // Truy vấn logs
            $query = LicenseActivationLog::where('machine_license_id', $machineLicense->id);

            // Lọc theo tax code nếu có
            if ($request->has('tax_code')) {
                $taxLicense = $machineLicense->taxLicenses()->where('tax_code', $request->tax_code)->first();
                $query->where('tax_license_id', $taxLicense->id);
            }

            // Lọc theo ngày
            if ($request->has('start_date')) {
                $query->where('created_at', '>=', $request->start_date);
            }

            if ($request->has('end_date')) {
                $query->where('created_at', '<=', $request->end_date);
            }

            // Phân trang
            $logs = $query->paginate(20);

            return response()->json([
                'activation_logs' => $logs
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error retrieving activation logs',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
