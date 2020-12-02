<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ContractProject extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id', 'order_date', 'address', 'province_id', 'city_id', 'kind_project', 'survey_date', 'survey_time', 
        'surveyer_id', 'approximate_value', 'project_value', 'worker_id', 'start_date', 'finish_date', 'description'
    ];

    public function getKindAttribute() {
        return 'Borongan';
    }

    public function getCityAttribute() {
        $data = \Indonesia::findCity($this->city_id, 'province');
        $city = Str::ucfirst(Str::lower($data->name));
        $province = Str::ucfirst(Str::lower($data->province->name));
        return $city . ', '. $province;
    }

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
            return 'done';
        };
        if($this->process === 'done') {
            return 'sharing';
        };
        if($this->process === 'finish') {
            return 'clear';
        };
        if($this->process === 'failed') {
            return null;
        };
    }

    public function getTotalPaymentAttribute() { 
        $id = $this->id;

        $totalpayment = PaymentTerm::where('project_id', $id)->where('kind_project', 'contract')->sum('amount');

        return $totalpayment;
    }

    public function getTotalChargeAttribute() {
        $id = $this->id;

        $totalcharge = Charge::where('project_id', $id)->where('kind_project', 'contract')->sum('amount');

        return $totalcharge;
    }

    public function getUnsharedAttribute() {
        $id = $this->id;
        $shared = Profit::where('project_id', $id)->where('kind_project', 'contract')->sum('amount_total');
        $payment = PaymentTerm::where('project_id', $id)->where('kind_project', 'contract')->sum('amount');
        return $payment - $shared;
    }

    public function getTotalProfitAttribute() {
        $id = $this->id;
        $profit = Profit::where('project_id', $id)
                            ->where('kind_project', 'contract')
                            ->sum('amount_cash');
        return $profit;
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
