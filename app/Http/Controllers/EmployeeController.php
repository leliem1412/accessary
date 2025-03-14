<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class EmployeeController extends Controller {
    
    public function list(Request $request) {
        $employees = Employee::select();

        if ($request->has('employee_code')) {
            $employees->where('employee_code', 'like', '%' . $request->employee_code . '%');
        }
        if ($request->has('name')) {
            $employees->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->has('email')) {
            $employees->where('email', 'like', '%' . $request->email . '%');
        }
        if ($request->has('role')) {
            $employees->where('role', 'like', '%' . $request->role . '%');
        }
        if ($request->has('created_at')) {
            $employees->where('created_at', 'like', '%' . $request->created_at . '%');  
        }
        if ($request->has('updated_at')) {
            $employees->where('updated_at', 'like', '%' . $request->updated_at . '%');
        }

        $employees = $employees->orderBy('updated_at', 'desc')->paginate(10);
        $data = [
            'entry_list' => $employees
        ];

        return view('employee.list', $data);
    }

    public function create(Request $request) {
        return view('employee.create');
    }

    public function store(Request $request) {
        if (!$request->ajax()) {
            return response()->json(['message'=> 'Bad request'], 400);
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required',
            'phone' => 'required',
        ]);

        $employee = new Employee();
        $employee->employee_code = $this->getCode(Employee::class, Employee::$codePrefix);
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->role = $request->role;
        $employee->phone = $request->phone;
        $employee->save();
        $employee = $employee->toArray();
        $employee['id'] = Crypt::encrypt($employee['id']);

        return response()->json([
            'message' => 'Thêm mới nhân viên thành công',
            'data' => $employee
        ], 200);
    }

    public function detail($id) {
        $idDecode = Crypt::decrypt($id);
        $user = Employee::where('id', $idDecode)->first();
        $user = $user->toArray();
        $user['id'] = Crypt::encrypt($user['id']);
        $data = [
            'entry_data' => $user,
        ];

        return view('employee.detail', $data);
    }

    public function edit($id) {
        $idDecode = Crypt::decrypt($id);
        $user = Employee::where('id', $idDecode)->first();
        $user = $user->toArray();
        $user['id'] = Crypt::encrypt($user['id']);
        $data = [
            'entry_data' => $user,
        ];

        return view('employee.edit', $data);
    }

    public function update(Request $request, $id) {
        if (!$request->ajax()) {
            return response()->json(['message'=> 'Bad request'], 400);
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required',
            'phone' => 'required',
        ]);

        $idDecode = Crypt::decrypt($id);
        $employee = Employee::find($idDecode);
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->role = $request->role;
        $employee->phone = $request->phone;
        $employee->save();
        $employee = $employee->toArray();
        $employee['id'] = Crypt::encrypt($employee['id']);

        return response()->json([
            'message' => 'Thêm mới nhân viên thành công',
            'data' => $employee
        ], 200);
    }
}
