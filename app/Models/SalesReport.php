<?php

// app/Models/SalesReport.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_date', 'total_sales', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}