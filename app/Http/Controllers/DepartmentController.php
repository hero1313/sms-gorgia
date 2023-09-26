<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $departments = Department::all();
        return view('main.components.department', compact(['departments']));
    }

    public function store(Request $request)
    {
        $department = new Department;
        $department->name = $request->name;
        $department->save();
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $department = Department::find($id);
        $department->name = $request->name;
        $department->update();
        return redirect()->back();
    }

    public function delete(Request $request, $id)
    {
        $department = Department::find($id);
        $department->delete();
        return redirect()->back();
    }
}
