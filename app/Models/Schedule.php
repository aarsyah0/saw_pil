<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_from',
        'date_to',
        'activity',
        'order',
    ];
    protected $appends = ['time'];

    public function getTimeAttribute()
    {
        $from = Carbon::parse($this->date_from)->format('d M Y');
        $to   = Carbon::parse($this->date_to)->format('d M Y');

        // jika sama hari, cukup satu
        if ($from === $to) {
            return $from;
        }

        return "{$from} – {$to}";
    }
}
