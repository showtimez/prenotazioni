<?php

namespace Database\Seeders;

use App\Models\Table;
use Illuminate\Database\Seeder;

class TableSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 40; $i++) {
            Table::create([
                'name' => 'Tavolo ' . $i,
                // Aggiungi altre colonne per memorizzare ulteriori dettagli sui tavoli
            ]);
        }
    }
}
