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
        $employees = Employee::with(['department'])->get(); // contact number or adreess bhi dalna h 
        return response()->json(['data' => $employees]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            // 'last_name' => 'required',
            // 'email' => 'required|email|unique:employees,email',
            'department_id' => 'required|exists:departments,id',

        ]);

        $employee = new Employee();
        $employee->name = $request->name;
        // $employee->last_name = $request->last_name;
        // $employee->email = $request->email;
        $employee->department_id = $request->department_id;
        $employee->save();

        // $employee->addresses()->createMany($request->addresses);
        // $employee->contactNumbers()->createMany($request->contact_numbers);

        return response()->json(['message' => 'Employee created successfully', 'data' => $employee], 201);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        $employee->load(['department', 'addresses', 'contactNumbers']);
        return response()->json(['data' => $employee]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => 'sometimes|required',
            // 'last_name' => 'sometimes|required',
            // 'email' => 'sometimes|required|email|unique:employees,email,'.$employee->id,
            'department_id' => 'sometimes|required|exists:departments,id',
            // 'addresses.*.id' => 'sometimes|required|exists:addresses,id,employee_id,'.$employee->id,
            // 'addresses.*.address_line_1' => 'sometimes|required',
            // 'addresses.*.city' => 'sometimes|required',
            // 'addresses.*.state' => 'sometimes|required',
            // 'contact_numbers.*.id' => 'sometimes|required|exists:contact_numbers,id,employee_id,'.$employee->id,
            // 'contact_numbers.*.number' => 'sometimes|required',
            // 'contact_numbers.*.type' => 'sometimes|required'
        ]);

        $employee->update($request->only(['name','department_id']));

        // if ($request->has('addresses')) {
        //     foreach ($request->addresses as $address) {
        //         $employee->addresses()->updateOrCreate(
        //             ['id' => $address['id']],
        //             $address
        //         );
        //     }
        // }

        // if ($request->has('contact_numbers')) {
        //     foreach ($request->contact_numbers as $contactNumber) {
        //         $employee->contactNumbers()->updateOrCreate(
        //             ['id' => $contactNumber['id']],
        //             $contactNumber
        //         );
        //     }
        // }

        return response()->json($employee->load(['department']));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return response()->json(['message' => 'Employee deleted successfully']);
    }
}
