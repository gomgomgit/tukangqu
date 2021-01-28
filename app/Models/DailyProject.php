<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\Activitylog\Traits\LogsActivity;

class DailyProject extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected static $logAttributes =
    [
        'client_id', 'order_date', 'address', 'province_id', 'city_id', 'kind_project', 'daily_value',
        'worker_id', 'daily_salary', 'start_date', 'finish_date', 'project_value', 'description', 'profit', 'refund'
    ];

    protected static $logOnlyDirty = true;

    protected $fillable = [
        'client_id', 'order_date', 'address', 'province_id', 'city_id', 'kind_project', 'daily_value', 
        'worker_id', 'daily_salary', 'start_date', 'finish_date', 'project_value', 'description', 'profit', 'refund'
    ];
    
    public function getCityAttribute() {
        $data = \Indonesia::findCity($this->city_id, 'province');
        $city = Str::ucfirst(Str::lower($data->name));
        $province = Str::ucfirst(Str::lower($data->province->name));
        return $city . ', '. $province;
    }

    public function getKindAttribute() {
        return 'Harian';
    }

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


    public function getTotalPaymentAttribute() {
        $id = $this->id;

        $totalpayment = PaymentTerm::where('project_id', $id)->where('kind_project', 'daily')->sum('amount');

        return $totalpayment;
    }

    public function getTotalChargeAttribute() {
        $id = $this->id;

        $totalcharge = Charge::where('project_id', $id)->where('kind_project', 'daily')->sum('amount');

        return $totalcharge;
    }

    public function getChargeWeekAttribute() {
        $id = $this->id;

        $datenow = Carbon::now()->format('Y-m-d');
        $datefrom = Carbon::now()->subDays(6)->format('Y-m-d');

        $chargeweek = Charge::where('project_id', $id)->where('kind_project', 'daily')
                        ->whereBetween('date',[$datefrom, $datenow])
                        ->sum('amount');

        return $chargeweek;
    }

    public function getDifferenceAttribute() {
        $daily = $this->daily_value;
        $worker = $this->daily_salary;

        return $daily - $worker;
    }

    public function getUnsharedAttribute() {
        $id = $this->id;
        $shared = Profit::where('project_id', $id)->where('kind_project', 'daily')->sum('amount_total');
        $payment = PaymentTerm::where('project_id', $id)->where('kind_project', 'daily')->sum('amount');
        return $payment - $shared;
    }

    public function getTotalProfitAttribute() {
        $id = $this->id;
        $profit = Profit::where('project_id', $id)
                            ->where('kind_project', 'daily')
                            ->sum('amount_cash');
        return $profit;
    }

    public function client() {
        return $this->belongsTo(Client::class, 'client_id', 'id')->withTrashed();
    }

    public function worker() {
        return $this->belongsTo(Worker::class, 'worker_id', 'id')->withTrashed();
    }

    public function city() {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }
}
