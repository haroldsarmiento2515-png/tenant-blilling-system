<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'company_name',
    ];

    /**
     * Get the bills for the tenant.
     */
    public function bills()
    {
        return $this->hasMany(Bill::class);
    }

    /**
     * Get the users for the tenant.
     */
    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('role');
    }
}