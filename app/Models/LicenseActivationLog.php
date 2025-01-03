<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Model LicenseActivationLog
class LicenseActivationLog extends Model
{
    protected $table = 'license_activation_logs';

    protected $fillable = [
        'tax_license_id',
        'machine_license_id',
        'device_identifier',
        'ip_address',
        'device_details',
        'action'
    ];

    protected $casts = [
        'device_details' => 'array'
    ];

    // Quan hệ với Tax License
    public function taxLicense()
    {
        return $this->belongsTo(TaxLicense::class);
    }

    // Quan hệ với Machine License
    public function machineLicense()
    {
        return $this->belongsTo(MachineLicense::class);
    }

    // Scope để lọc các log theo hành động
    public function scopeByAction($query, $action)
    {
        return $query->where('action', $action);
    }
}
