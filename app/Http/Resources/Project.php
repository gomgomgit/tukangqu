<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Project extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'client_id' => $this->client_id,
            'order_date' => $this->order_date,
            'address' => $this->address,
            'kind_project' => $this->kind_project,
            'daily_value' => $this->daily_value,
            'worker_id' => $this->worker_id,
            'daily_salary' => $this->daily_salary,
            'start_date' => $this->start_date,
            'finish_date' => $this->finish_date,
            'project_value' => $this->project_value,
            'profit' => $this->profit,
            'description' => $this->description,
            'process' => $this->process,
            'status' => $this->status,
            'totalpayment' => $this->totalpayment,
            'totalcharge' => $this->totalcharge,
            'chargeweek' => $this->chargeweek,
            'unshared' => $this->unshared,
            
        ];
    }
}
