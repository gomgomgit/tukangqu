<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyProject extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id', 'order_date', 'address' ,'kind_project'
    ];

    public function getActionAttribute() {
        if($this->process === 'waiting') {
            return 'pricing';
        };
        if($this->process === 'priced') {
            return 'dealing';
        };
        if($this->process === 'deal') {
            return 'finish';
        };
        if($this->process === 'failed') {
            return null;
        };
    }

    public function client() {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    public function worker() {
        return $this->belongsTo(Worker::class, 'worker_id', 'id');
    }
}
