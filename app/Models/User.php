<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    // Role constants
    const ROLE_ADMINISTRASI = 'administrasi';
    const ROLE_DESIGNER = 'designer';
    const ROLE_VENDOR = 'vendor';
    const ROLE_MARKOM_REGIONAL = 'markom_regional';
    const ROLE_MARKOM_BRANCH = 'markom_branch';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'must_change_password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'must_change_password' => 'boolean',
        ];
    }

    /**
     * Check if user is Administrasi
     */
    public function isAdministrasi(): bool
    {
        return $this->role === self::ROLE_ADMINISTRASI;
    }

    /**
     * Check if user is Designer
     */
    public function isDesigner(): bool
    {
        return $this->role === self::ROLE_DESIGNER;
    }

    /**
     * Check if user is Vendor
     */
    public function isVendor(): bool
    {
        return $this->role === self::ROLE_VENDOR;
    }

    /**
     * Check if user is Markom Regional
     */
    public function isMarkomRegional(): bool
    {
        return $this->role === self::ROLE_MARKOM_REGIONAL;
    }

    /**
     * Check if user is Markom Branch
     */
    public function isMarkomBranch(): bool
    {
        return $this->role === self::ROLE_MARKOM_BRANCH;
    }

    /**
     * Get role display name
     */
    public function getRoleDisplayName(): string
    {
        return match($this->role) {
            self::ROLE_ADMINISTRASI => 'Administrasi',
            self::ROLE_DESIGNER => 'Designer',
            self::ROLE_VENDOR => 'Tim Vendor',
            self::ROLE_MARKOM_REGIONAL => 'Markom Regional',
            self::ROLE_MARKOM_BRANCH => 'Markom Branch',
            default => 'Unknown',
        };
    }
}
