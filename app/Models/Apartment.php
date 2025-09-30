<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Apartment extends Model
{
    use HasFactory;

        protected $fillable = [
            'number',
            'area',
            'house_id',
            'residents'
        ];

    protected $casts = [
        'residents' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function house(): BelongsTo
    {
        return $this->belongsTo(House::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function residentsUsers()
    {
        if (empty($this->residents) || !is_array($this->residents)) {
            return collect();
        }

        return User::whereIn('id', $this->residents)->get();
    }


}
