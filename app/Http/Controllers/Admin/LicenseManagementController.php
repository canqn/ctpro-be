<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MachineLicense;
use App\Models\TaxLicense;
use App\Models\User;
use Illuminate\Http\Request;

class LicenseManagementController extends Controller
{
    // Trang danh sách license máy
    public function indexMachineLicenses()
    {
        $machineLicenses = MachineLicense::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.licenses.machines.index', [
            'machineLicenses' => $machineLicenses
        ]);
    }

    // Trang chi tiết license máy
    public function showMachineLicense($id)
    {
        $machineLicense = MachineLicense::with(['user', 'taxLicenses', 'activationLogs'])
            ->findOrFail($id);
        return view('admin.licenses.machines.show', [
            'machineLicense' => $machineLicense
        ]);
    }

    // Trang thêm mới license máy
    public function createMachineLicense()
    {
        $users = User::all();
        return view('admin.licenses.machines.create', [
            'users' => $users
        ]);
    }

    // Xử lý thêm mới license máy
    public function storeMachineLicense(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'machine_name' => 'nullable|string|max:255',
            'machine_details' => 'required|array'
        ]);

        $machineLicense = MachineLicense::create([
            'user_id' => $validated['user_id'],
            'machine_key' => MachineLicense::generateMachineKey(),
            'machine_name' => $validated['machine_name'] ?? null,
            'machine_details' => $validated['machine_details'],
            'status' => 'active'
        ]);

        return redirect()
            ->route('admin.licenses.machines.show', $machineLicense->id)
            ->with('success', 'Machine license created successfully');
    }

    // Trang danh sách license thuế
    public function indexTaxLicenses(Request $request)
    {
        $query = TaxLicense::with(['machineLicense.user']);

        // Áp dụng bộ lọc theo tên người dùng (username)
        if ($request->has('username') && $request->username) {
            $query->whereHas('machineLicense.user', function ($subQuery) use ($request) {
                $subQuery->where('username', 'like', '%' . $request->username . '%');
            });
        }

        // Áp dụng bộ lọc theo tên máy (machine_name)
        if ($request->has('machine_name') && $request->machine_name) {
            $query->whereHas('machineLicense', function ($subQuery) use ($request) {
                $subQuery->where('machine_name', 'like', '%' . $request->machine_name . '%');
            });
        }
        // lọc theo tax code
        if ($request->has('tax_code') && $request->tax_code) {
            $query->whereHas('machineLicense', function ($subQuery) use ($request) {
                $subQuery->where('tax_code', 'like', '%' . $request->tax_code . '%');
            });
        }

        $taxLicenses = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.licenses.tax.index', [
            'taxLicenses' => $taxLicenses
        ]);
    }


    // Trang chi tiết license thuế
    public function showTaxLicense($id)
    {
        $taxLicense = TaxLicense::with(['machineLicense', 'activationLogs'])
            ->findOrFail($id);

        return view('admin.licenses.tax.show', [
            'taxLicense' => $taxLicense
        ]);
    }

    // Trang thêm mới license thuế
    public function createTaxLicense($machineId = null)
    {
        $machineLicenses = MachineLicense::all();
        $selectedMachine = $machineId ? MachineLicense::findOrFail($machineId) : null;

        return view('admin.licenses.tax.create', [
            'machineLicenses' => $machineLicenses,
            'selectedMachine' => $selectedMachine
        ]);
    }

    // Xử lý thêm mới license thuế
    public function storeTaxLicense(Request $request)
    {
        $validated = $request->validate([
            'machine_license_id' => 'required|exists:machine_licenses,id',
            'tax_code' => 'required|unique:tax_licenses,tax_code',
            'business_name' => 'nullable|string|max:255',
            'max_devices' => 'integer|min:1|max:10',
            'expiry_date' => 'nullable|date|after:today',
            'status' => 'required|in:active,pending,expired,suspended,revoked'
        ]);

        $taxLicense = TaxLicense::create([
            'machine_license_id' => $validated['machine_license_id'],
            'tax_code' => $validated['tax_code'],
            'business_name' => $validated['business_name'] ?? null,
            'status' => $validated['status'] ?? 'active',
            'registration_date' => date('Y-m-d H:i:s'),
            'activation_date' => date('Y-m-d H:i:s'),
            'max_devices' => $validated['max_devices'] ?? 1,
            'expiry_date' => $validated['expiry_date'] ?? now()->addYear()
        ]);

        return redirect()
            ->route('admin.licenses.tax.show', $taxLicense->id)
            ->with('success', 'Tax license created successfully');
    }

    public function editTaxLicense($id)
    {
        $taxLicense = TaxLicense::findOrFail($id);
        $machineLicenses = MachineLicense::all();

        return view('admin.licenses.tax.edit', [
            'taxLicense' => $taxLicense,
            'machineLicenses' => $machineLicenses
        ]);
    }

    public function updateTaxLicense(Request $request, $id)
    {
        $validated = $request->validate([
            'machine_license_id' => 'required|exists:machine_licenses,id',
            'tax_code' => 'required|unique:tax_licenses,tax_code,' . $id,
            'business_name' => 'nullable|string|max:255',
            'max_devices' => 'integer|min:1|max:10',
            'expiry_date' => 'nullable|date|after:today',
            'status' => 'required|in:active,pending,expired,suspended,revoked'
        ]);

        $taxLicense = TaxLicense::findOrFail($id);
        $taxLicense->update([
            'machine_license_id' => $validated['machine_license_id'],
            'tax_code' => $validated['tax_code'],
            'business_name' => $validated['business_name'] ?? null,
            'status' => $validated['status'],
            'max_devices' => $validated['max_devices'],
            'expiry_date' => $validated['expiry_date'] ?? null
        ]);

        return redirect()
            ->route('admin.licenses.tax.show', $taxLicense->id)
            ->with('success', 'Tax license updated successfully');
    }

    public function destroyTaxLicense(string $id)
    {
        $taxLicense = TaxLicense::findOrFail($id);

        if ($taxLicense->delete()) {
            return redirect()
                ->back()
                ->with('success', 'Tax license deleted successfully');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Failed to delete tax license');
        }
    }
    // Quản lý trạng thái license
    public function updateLicenseStatus(Request $request, $type, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:active,suspended,expired,inactive,blocked'
        ]);

        if ($type === 'machine') {
            $license = MachineLicense::findOrFail($id);
        } else {
            $license = TaxLicense::findOrFail($id);
        }

        $license->update([
            'status' => $validated['status']
        ]);

        return redirect()
            ->back()
            ->with('success', 'License status updated successfully');
    }

    public function updateLicenseActiveTaxCode(Request $request, $type, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:active,blocked'
        ]);

        if ($type === 'activetaxcode') {
            $license = MachineLicense::findOrFail($id);
        } else {
            return redirect()
                ->back()
                ->with('error', 'Invalid type specified.');
        }

        // Ensure you're updating the correct field
        $license->update([
            'active_taxcode' => $validated['status']
        ]);

        return redirect()
            ->back()
            ->with('success', 'License status updated successfully');
    }
}
