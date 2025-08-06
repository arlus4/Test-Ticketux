<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaksi extends Model
{
    protected $fillable = [
        'tanggal',
        'coa_id',
        'desc',
        'debit',
        'credit',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'debit' => 'decimal:2',
        'credit' => 'decimal:2',
    ];

    /**
     * Get the COA that owns the transaction.
     */
    public function coa(): BelongsTo
    {
        return $this->belongsTo(Coa::class);
    }
}
