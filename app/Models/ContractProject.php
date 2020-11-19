<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractProject extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id', 'order_date', 'address' ,'kind_project'
    ];

    public function getActionAttribute() {
        if($this->process === 'waiting') {
            return 'scheduling';
        };
        if($this->process === 'scheduled') {
            return 'pricing';
        };
        if($this->process === 'surveyed') {
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

    public function surveyer() {
        return $this->belongsTo(Worker::class, 'surveyer_id', 'id');
    }
}
