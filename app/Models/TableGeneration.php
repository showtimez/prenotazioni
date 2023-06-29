<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TableGeneration extends Model
{
    protected $table = 'table_generation';

    protected $fillable = ['data', 'num_tavoli'];
}
