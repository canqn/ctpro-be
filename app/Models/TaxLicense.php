<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Model TaxLicense
class TaxLicense extends Model
{
    protected $table = 'tax_licenses';

    protected $fillable = [
        'machine_license_id',
        'tax_code',
        'business_name',
        'status',
        'registration_date',
        'activation_date',
        'expiry_date',
        'max_devices',
        'current_devices',
        'additional_info'
    ];

    protected $dates = [
        'registration_date',
        'activation_date',
        'expiry_date',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'additional_info' => 'array',
        'expiry_date' => 'datetime',
    ];

    // Quan hệ với Machine License
    public function machineLicense()
    {
        return $this->belongsTo(MachineLicense::class);
    }

    // Quan hệ với Activation Logs
    public function activationLogs()
    {
        return $this->hasMany(LicenseActivationLog::class);
    }

    // Kiểm tra trạng thái license
    public function isValid()
    {
        return $this->status === 'active' &&
            ($this->expiry_date === null || $this->expiry_date > now()) &&
            $this->current_devices < $this->max_devices;
    }

    // Kích hoạt license
    public function activate($deviceIdentifier)
    {
        if (!$this->isValid()) {
            throw new \Exception('License không thể kích hoạt');
        }

        $this->current_devices++;
        $this->save();

        // Tạo log kích hoạt
        $this->activationLogs()->create([
            'machine_license_id' => $this->machine_license_id,
            'device_identifier' => $deviceIdentifier,
            'action' => 'activated',
            'ip_address' => request()->ip(),
            'device_details' => json_encode(request()->header())
        ]);

        return true;
    }

    // Hủy kích hoạt
    public function deactivate($deviceIdentifier)
    {
        if ($this->current_devices > 0) {
            $this->current_devices--;
            $this->save();

            // Tạo log hủy kích hoạt
            $this->activationLogs()->create([
                'machine_license_id' => $this->machine_license_id,
                'device_identifier' => $deviceIdentifier,
                'action' => 'deactivated',
                'ip_address' => request()->ip(),
                'device_details' => json_encode(request()->header())
            ]);
        }

        return true;
    }
}
