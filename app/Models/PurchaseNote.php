<?php

// app/Models/PurchaseNote.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'note_number', 'purchase_date', 'total_amount', 'supplier_name'
    ];
}