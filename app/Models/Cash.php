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
        'project_id', 'project_type', 'name', 'date', 'category', 'money_in', 'money_out', 'description', 'user_id'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getProjectValueAttribute() {
        $id = $this->project_id;
        if ($this->description == 'borongan') {
            $value = ContractProject::where('id', $id)->first();
            return $value->project_value;
        }
        if ($this->description == 'harian') {
            $value = DailyProject::where('id', $id)->first();
            return $value->project_value;
        }
    }

    public function total() {
        $in = Cash::pluck('money_in')->sum();
        $out = Cash::pluck('money_out')->sum();

        return $in - $out;
    }

}
