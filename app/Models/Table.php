<?php

namespace App\Models;

use App\Models\Reservation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'data'
        // Aggiungi altre colonne per memorizzare ulteriori dettagli sui tavoli
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
