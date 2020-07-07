<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Employee;
use Illuminate\Support\Str;

class EmployeesController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth:api');
    }


    public function index()
    {
        return Employee::latest()->paginate(10);
    }

    public function numberOfEmployees()
    {
        return Employee::all('id')->count(); //specific the id for speed optimization
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $this->validateData(0); 

        return Employee::create([
            'user_id' => auth('api')->user()->id,
            'user_name' => auth('api')->user()->name,
            'full_name' => $request['full_name'],
            'age' => $request['age'],
            'contact_no' => $request['contact_no'],
            'status' => $request['status'],
            'position' => $request['position'],
            'address' => $request['address'],
            'salary' => $request['salary'],
            'email' => $request['email']
        ]);

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = Employee::findOrFail($id);

        return $employee;
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

        $employee = Employee::findOrFail($id);

        $this->validateData($id);
        
        $employee->update($request->all());

        return ['message' => 'Successfully updated'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);

        $employee->delete();
    }

    private function validateData($id)
    {
            request()->validate([
            'full_name' => 'required',
            'age' => 'required',
            'contact_no' => 'required',
            'address' => 'required',
            'status' => 'required',
            'salary' => 'required',
            'position' => 'required',
            'email' => 'required|string|email|unique:employees,email,'.$id
        ]);
    }

    public function searchEmployee() 
    {
        if($searchEmployee = \Request::get('q')) {
            $employee = Employee::where(function($query) use ($searchEmployee){
                $query->where(Str::lower('full_name'), 'ILIKE', "%$searchEmployee%")
                        ->orWhere(Str::lower('position'), 'ILIKE', "%$searchEmployee%")
                        ->orWhere(Str::lower('email'), 'ILIKE', "%$searchEmployee%");
            })->paginate(10);
        }else {
            return Employee::latest()->paginate(10);
        }

        return $employee;
    }

    public function printEmployees()
    {
        return Employee::all('full_name', 'age', 'status', 'address', 
            'email');
        // return compact('employees');
        // return view('print_employees', compact('employees'));
    }
}
