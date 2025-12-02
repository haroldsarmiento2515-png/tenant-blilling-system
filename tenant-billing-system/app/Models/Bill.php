<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tenant_id',
        'bill_number',
        'billing_date',
        'due_date',
        'amount',
        'paid_amount',
        'status',
        'description',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'billing_date' => 'date',
        'due_date' => 'date',
    ];

    /**
     * Get the tenant that owns the bill.
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Get the payments for the bill.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Calculate the remaining balance for the bill.
     */
    public function remainingBalance()
    {
        return $this->amount - $this->paid_amount;
    }

    /**
     * Check if the bill is fully paid.
     */
    public function isFullyPaid()
    {
        return $this->remainingBalance() <= 0;
    }
}