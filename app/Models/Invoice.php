<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'apartment_id',
        'total_amount',
        'period',
        'status',
    ];

    protected $casts = [
        'period' => 'datetime',
        'created_at' => 'datetime',
    ];

    public function apartment(): BelongsTo
    {
        return $this->belongsTo(Apartment::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function getPeriodRangeAttribute(): string
    {
        $end = Carbon::now();
        $start = $end->copy()->subDays(30);

        $startMonth = ucfirst($start->locale('ru')->translatedFormat('F'));
        $endMonth = ucfirst($end->locale('ru')->translatedFormat('F'));

        return $startMonth . ' — ' . $endMonth;
    }

    public function getPeriodText(?Carbon $date = null): string
    {
        $months = [
            1 => 'января',
            2 => 'февраля',
            3 => 'марта',
            4 => 'апреля',
            5 => 'мая',
            6 => 'июня',
            7 => 'июля',
            8 => 'августа',
            9 => 'сентября',
            10 => 'октября',
            11 => 'ноября',
            12 => 'декабря',
        ];

        $end = $date ?? $this->created_at;
        $start = $end->copy()->subDays(30);

        return $start->format('d') . ' ' . $months[(int)$start->format('m')] . ' - ' .
            $end->format('d') . ' ' . $months[(int)$end->format('m')];
    }
}
