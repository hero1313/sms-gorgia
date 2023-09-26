<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class BranchController extends Controller
{
    public function index(Request $request)
    {
        $branches = Branch::all();
        return view('main.components.branch', compact(['branches']));
    }

    public function store(Request $request)
    {
        $branch = new Branch;
        $branch->name = $request->name;
        $branch->save();
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $branch = Branch::find($id);
        $branch->name = $request->name;
        $branch->update();
        return redirect()->back();
    }

    public function delete(Request $request, $id)
    {
        $branch = Branch::find($id);
        $branch->delete();
        return redirect()->back();
    }
}
