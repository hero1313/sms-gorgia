<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Sms;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use App\Exports\EmployeeExport;
use App\Imports\EmployeeImport;
use App\Http\Controllers\Controller;


use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;


class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $birthdaySms = Sms::where('id', 1)->first();
        $sms = Sms::all();
        $employees = Employee::where('id' , '!=', '-1')->paginate(50);
        if ($request->user_name != null) {
            $employees = Employee::whereRaw("concat(name, ' ', lastname) like '%" .$request->user_name. "%' ")
            ->orWhere('id_number', 'LIKE', "%{$request->user_name}%")
            ->paginate(50);
        }

        if ($request->user_departemnt != null && $request->user_branch == null && $request->user_gender == null) {
            $employees = Employee::where('department', $request->user_departemnt)->paginate(50);
        }
        else if ($request->user_departemnt == null && $request->user_branch != null && $request->user_gender == null) {
            $employees = Employee::where('branch_id', $request->user_branch)->paginate(50);
        }
        else if ($request->user_departemnt == null && $request->user_branch == null && $request->user_gender != null) {
            $employees = Employee::where('gender', $request->user_gender)->paginate(50);
        }
        else if ($request->user_departemnt != null && $request->user_branch != null && $request->user_gender == null) {
            $employees = Employee::where('department', $request->user_departemnt)->where('branch_id', $request->user_branch)->paginate(50);
        }
        else if ($request->user_departemnt == null && $request->user_branch != null && $request->user_gender != null) {
            $employees = Employee::where('branch_id', $request->user_branch)->where('gender', $request->user_gender)->paginate(50);
        }
        else if ($request->user_departemnt != null && $request->user_branch == null && $request->user_gender != null) {
            $employees = Employee::where('department', $request->user_departemnt)->where('gender', $request->user_gender)->paginate(50);
        }
        else if ($request->user_departemnt != null && $request->user_branch != null && $request->user_gender != null) {
            $employees = Employee::where('department', $request->user_departemnt)->where('gender', $request->user_gender)->where('branch_id', $request->user_branch)->paginate(50);
        }
        


        $departments = Department::all();
        $branches = Branch::all();
        $today = Carbon::now()->format('m-d');
        // dd($today);
        $employees_birthday = Employee::whereDay('birthday', Carbon::now())->whereMonth('birthday', Carbon::now())->get();
        $employees_birthday_count = Employee::whereDay('birthday', Carbon::now())->whereMonth('birthday', Carbon::now())->count();
        return view('main.components.employee', compact(['employees', 'employees_birthday', 'employees_birthday_count', 'branches', 'departments','birthdaySms','sms']));
    }

    public function store(Request $request)
    {
        $employee = new Employee;
        $employee->name = $request->name;
        $employee->lastname = $request->lastname;
        $employee->id_number = $request->id_number;
        $employee->number = $request->number;
        $employee->gender = $request->gender;
        $employee->department = $request->department;
        $employee->position = $request->position;
        $employee->branch_id = $request->branch;
        $employee->birthday = $request->birthday;
        $employee->start_date = $request->start_date;
        $employee->save();
        return redirect('/employee');
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::find($id);
        $employee->name = $request->name;
        $employee->lastname = $request->lastname;
        $employee->id_number = $request->id_number;
        $employee->number = $request->number;
        $employee->gender = $request->gender;
        $employee->department = $request->department;
        $employee->position = $request->position;
        $employee->branch_id = $request->branch;
        $employee->birthday = $request->birthday;
        $employee->start_date = $request->start_date;
        $employee->update();
        return redirect('/employee');
    }

    public function delete($id)
    {
        $employee = Employee::find($id);
        $employee->delete();
        return redirect('/employee');
    }


    public function excelExport()
    {
        return Excel::download(new EmployeeExport, 'employees.xlsx');
    }
    public function excelImport(Request $request)
    {
        Excel::import(new EmployeeImport,  $request->excel);        
        return redirect('/')->with('success', 'All good!');
    }
}
