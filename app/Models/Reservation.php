<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
    use HasFactory;

    protected $table = 'reservations';

    protected $fillable = [
        'data',
        'fascia',
        'posti',
        'user_id',
        'table_id',
        'is_accepted'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($reservation) {
            $reservation->is_accepted = true; // Imposta automaticamente is_accepted a true al momento della creazione
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    public function setAccepted($value)
    {
        $this->update(['is_accepted' => $value]);
    }
}

