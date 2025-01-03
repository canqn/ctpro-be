<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'full_name',
        'email',
        'phone',
        'email_verified_at',
        'password',
        'remember_token',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [
            'userId' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'role' => $this->role,
        ];
    }

    /**
     * Get the merchant account associate with the user
     *
     * @return HasOne
     */
    public function account()
    {
        return $this->hasOne(Account::class);
    }

    public function downloadLimit()
    {
        return $this->hasMany(DownloadLimit::class);
    }

    public function download()
    {
        return $this->hasMany(Download::class);
    }

    protected function role(): Attribute
    {
        return new Attribute(
            get: fn($value) =>  ["user", "admin"][$value],
        );
    }

    public function isAdmin()
    {
        return $this->role === 1; // Hoặc bất kỳ logic nào bạn sử dụng để xác định quyền quản trị viên
    }
    // Thiết lập mối quan hệ với bảng UserSubscription
    public function subscriptions()
    {
        return $this->hasMany(UserSubscription::class);
    }
    // Quan hệ với MachineLicense
    public function machineLicenses()
    {
        return $this->hasMany(MachineLicense::class);
    }
}
