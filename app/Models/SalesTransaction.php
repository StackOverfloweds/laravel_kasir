<?php

// app/Models/SalesTransaction.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesTransaction extends Model
{
    use HasFactory;

    protected $table = "sales_transactions";

    protected $fillable = [
        'transaction_date',
        'user_id',
        'menu_id',
        'total_amount',
        'payment_method',
        'quantity'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Correct the relationship to belong to one menu
    public function menu()
    {
        return $this->belongsTo(Menu::class);  // Fix here: changed from belongsToMany to belongsTo
    }
}
