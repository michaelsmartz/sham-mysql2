<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\APIBaseController as APIBaseController;
use App\Employee;
use App\SysConfigValue;
use App\Support\Helper;
use App\Http\Resources\Employee as EmployeeResource;
use Validator;

/**
 * 
 * @group Employees
 * 
 * API for Employees
 */
class EmployeesAPIController extends APIBaseController
{
    public function __construct()
    {
      $this->middleware('auth:api')->except(['index', 'show']);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::all();
        return $this->sendResponse($employees->toArray(), 'Posts retrieved successfully.');
    }

    /**
     * Create a new Employee
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
     * @response 200 {
     *   "success": true,
     *   "data": {
     *     "id": 1,
     *     "first_name": "John",
     *     "surname": "Doe",
     *     "more_fields": "more values"
     *   },
     *   "message": "Employee created successfully."
     * }
     */
    public function store(Request $request)
    {
        // SFE code is available internally only
        $sfeCode = SysConfigValue::where('key','=', 'LATEST_SFE_CODE')->first();

        // merge the generated SFE code to make a valid employee code
        //then check validation
        if($sfeCode !== null) {
            $employee_code = Helper::increment($sfeCode->value);
            $request->merge([
                'employee_code' => $employee_code
            ]);
            $sfeCode->value = $employee_code;
        }
        $sfeCode->save();

        $this->validator($request);

        $input = $request->except('Authorization');

        $employee = Employee::create($input);

        return $this->sendResponse($employee->toArray(), 'Employee created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * 
     * @bodyParam id int the employee identifier to retrieve
     * @response {
     *   "success": true,
     *   "data": {
     *     "id": 1,
     *     "first_name": "John",
     *     "surname": "Doe"...
     *   },
     *   "message": "Employee retrieved successfully."
     * }
     * @response 404 {
     *   "success": false,
     *   "message": "Employee not found."
     * }
     */
    public function show($id)
    {
        $employee = Employee::find($id);

        if (is_null($employee)) {
            return $this->sendError('Employee not found.');
        }

        $empResource = new EmployeeResource($employee);

        return $this->sendResponse( $empResource, 'Employee retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $this->validator($request);

        $employee = Employee::find($id);

        if (is_null($employee)) {
            return $this->sendError('Employee not found.');
        }

        $employee->first_name = $input['first_name'];
        $employee->surname = $input['surname'];
        $employee->known_as = $input['known_as'];
        $employee->birth_date = $input['birth_date'];
        $employee->id_number = $input['id_number'];
        $employee->employee_no = $input['employee_no'];
        $employee->date_joined = $input['date_joined'];
        $employee->date_terminated = $input['date_terminated'];
        $employee->save();

        return $this->sendResponse($employee->toArray(), 'Employee updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * 
     * @bodyParam id int the employee identifier to delete
     * @response {
     *   "success": true,
     *   "data": "2097",
     *   "message": "Employee deleted successfully."
     * }
     * @response 404 {
     *   "success": false,
     *   "message": "Employee not found."
     * }
     */
    public function destroy($id)
    {
        $employee = Employee::find($id);

        if (is_null($employee)) {
            return $this->sendError('Employee not found.');
        }

        $employee->delete();

        return $this->sendResponse($id, 'Employee deleted successfully.');

    }

    /**
     * Validate the given request with the defined rules.
     *
     * @param  Request $request
     *
     * @return boolean
     */
    protected function validator(Request $request)
    {
        $validateFields = [
            'first_name' => 'required|string|min:0|max:50',
            'surname' => 'required|string|min:0|max:50',
            'birth_date' => 'required|date_format:Y-m-d',
            'id_number' => 'required|string|min:1|max:50',
            'employee_no' => 'required|string|min:1|max:50',
            'employee_code' => 'required|string|min:1|max:50',
            'date_joined' => 'nullable|string|min:0',
            'date_terminated' => 'nullable|string|min:0'
        ];

        $messages = [
            'tax_number.required' => 'The tax number is required if the tax status is set to taxable',
            'tax_number.required_if' => 'The tax number is required if the tax status is set to taxable'
        ];
        
        try {
            $this->validate($request, $validateFields, $messages);
        } catch (Exception $exception) {
            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors());       
            }
        }

    }

}