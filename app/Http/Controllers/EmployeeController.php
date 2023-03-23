<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        return Employee::get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
        ]);

        $employee = new Employee();
        $employee->user_id = auth()->user()->id;
        $employee->first_name = $input['first_name'];
        $employee->last_name = $input['last_name'];
        $employee->save();
        return response()->json($employee);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, string $userId)
    {
        $getValue = Employee::where('user_id',$userId)->get();

        return response([
            'data' => $getValue
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $id)
    {
        $input = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
        ]);
        try{

            $employee = Employee::findOrFail($id);
            $employee->update($request->all());

            return response("Successfully edited", 200);

        }catch(Exception $e){
            return response($e->getString(), 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        return response()->json($employee->delete());
    }
}
