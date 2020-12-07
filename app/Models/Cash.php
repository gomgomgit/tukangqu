<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cash extends Model
{
    use HasFactory;

    use SoftDeletes;
    
    protected $fillable = [ 
        'name', 'date', 'category', 'money_out', 'description',
    ];

    public function total() {
        $in = Cash::pluck('money_in')->sum();
        $out = Cash::pluck('money_out')->sum();

        return $in - $out;
    }

}
