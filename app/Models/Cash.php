<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cash extends Model
{
    use HasFactory;
    protected $fillable = [ 
        'name', 'date', 'category', 'money_out', 'description',
    ];

    public function total() {
        $in = Cash::pluck('money_in')->sum();
        $out = Cash::pluck('money_out')->sum();

        return $in - $out;
    }

}
