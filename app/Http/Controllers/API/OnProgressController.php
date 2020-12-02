<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Project;
use App\Models\Charge;
use App\Models\ContractProject;
use App\Models\DailyProject;
use App\Models\PaymentTerm;
use App\Models\Profit;
use Illuminate\Http\Request;

class OnProgressController extends Controller
{
    public function billing($project_id, $kind) {
        if ($kind === 'borongan') {
            $charges = Charge::where('project_id', $project_id)->where('kind_project', 'contract')->get(); 
        }
        if ($kind === 'harian') {
            $charges = Charge::where('project_id', $project_id)->where('kind_project', 'daily')->get();
        }

        return $charges;
    }

    public function project($id, $kind) {
        if ($kind === 'borongan') {
            $project = ContractProject::find($id);
        }
        if ($kind === 'harian') {
            $project = DailyProject::find($id);
        }

        return new Project($project);
        // return $project;
    }

    public function termin($project_id, $kind) {
        if ($kind === 'borongan') {
            $termin = PaymentTerm::where('project_id', $project_id)->where('kind_project', 'contract')->get();
        }
        if ($kind === 'harian') {
            $termin = PaymentTerm::where('project_id', $project_id)->where('kind_project', 'daily')->get();
        }

        return $termin;
    }

    public function sharing($project_id, $kind) {
        if ($kind === 'borongan') {
            $profit = Profit::where('project_id', $project_id)->where('kind_project', 'contract')->get();
        }
        if ($kind === 'harian') {
            $profit = Profit::where('project_id', $project_id)->where('kind_project', 'daily')->get();
        }

        return $profit;
    }
}
