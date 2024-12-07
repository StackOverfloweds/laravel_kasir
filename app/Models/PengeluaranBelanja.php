<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengeluaranBelanja extends Model
{
    use HasFactory;

    // Table associated with the model
    protected $table = 'pengeluaran_belanja';

    // The attributes that are mass assignable
    protected $fillable = ['name', 'quantity', 'price', 'date'];
}
