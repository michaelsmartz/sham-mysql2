<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Employee extends Resource
{
    /**
     * Get any additional data that should be returned with the resource array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function with($request)
    {
        return [
            'success' => true
        ];
    }

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
            'first_name' => $this->first_name,
            'surname' => $this->surname,
            'known_as' => $this->known_as,
            'birth_date' => $this->birth_date,
            'id_number' => $this->id_number,
            'employee_no' => $this->employee_no,
            'employee_code' => $this->employee_code,
            'date_joined' => $this->date_joined,
            'date_terminated' => $this->date_terminated
        ];
    }
}
