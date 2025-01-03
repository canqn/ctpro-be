<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

// Model MachineLicense
class MachineLicense extends Model
{
    protected $table = 'machine_licenses';

    protected $fillable = [
        'user_id',
        'machine_key',
        'machine_name',
        'machine_fingerprint',
        'machine_details',
        'status',
        'active_taxcode',
        'last_activated_at',
        'expires_at'
    ];

    protected $dates = [
        'last_activated_at',
        'expires_at',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'machine_details' => 'array',
        'last_activated_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    // Quan hệ với User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Quan hệ với Tax Licenses
    public function taxLicenses()
    {
        return $this->hasMany(TaxLicense::class);
    }

    // Quan hệ với Activation Logs
    public function activationLogs()
    {
        return $this->hasMany(LicenseActivationLog::class);
    }

    // Kiểm tra xem license có hết hạn không
    public function isExpired()
    {
        if ($this->expiry_at === null) {
            return false;
        }
        return $this->expiry_at->isPast();
    }

    // Kiểm tra xem license có active không
    public function isActive()
    {
        return $this->status === 'active' && !$this->isExpired();
    }


    public function isActiveTaxCode()
    {
        return $this->active_taxcode === 'active' &&
            ($this->expires_at === null || $this->expires_at > now());
    }
    // Tạo mã key máy
    public static function generateMachineKey()
    {
        return 'ML-' . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT) . '-' .
            strtoupper(substr(md5(uniqid()), 0, 6));
    }

    // Kiểm tra dấu vân tay máy
    public function verifyFingerprint($machineDetails)
    {
        $currentFingerprint = $this->generateFingerprint($machineDetails);
        return $this->machine_fingerprint === $currentFingerprint;
    }

    // Tạo dấu vân tay máy
    public function generateFingerprint($machineDetails)
    {
        // Kết hợp các thông tin unique của máy
        $uniqueIdentifiers = [
            $machineDetails['cpu_id'] ?? '',
            $machineDetails['motherboard_serial'] ?? '',
            $machineDetails['hard_drive_serial'] ?? ''
        ];

        // Lọc bỏ các giá trị rỗng và join lại
        $fingerprint = implode('|', array_filter($uniqueIdentifiers));

        // Mã hóa fingerprint
        return hash('sha256', $fingerprint);
    }

    // Scope query để lấy các license còn active
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
            ->where(function ($query) {
                $query->whereNull('expiry_at')
                    ->orWhere('expiry_at', '>', now());
            });
    }

    // Scope query để lấy các license đã hết hạn
    public function scopeExpired($query)
    {
        return $query->where('expiry_at', '<=', now());
    }

    // Deactivate taxcode cho machine
    public function deactivateTaxCode()
    {
        $this->update([
            'active_taxcode' => 'inactive',
        ]);
    }

    // Extend expiry date
    public function extendExpiry($days = 365)
    {
        $this->update([
            'expiry_at' => $this->expiry_at ?
                $this->expiry_at->addDays($days) :
                now()->addDays($days)
        ]);
    }
}
