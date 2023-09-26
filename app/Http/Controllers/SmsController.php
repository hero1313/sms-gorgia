<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\Sms;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class SmsController extends Controller
{
    public function index(Request $request)
    {
        $sms = Sms::all();
        $employees = Employee::all();
        $departments = Department::all();
        $branches = Branch::all();
        return view('main.components.sms', compact(['sms', 'employees', 'departments', 'branches']));
    }

    public function store(Request $request)
    {
        $sms = new Sms;
        $sms->name = $request->name;
        $sms->text = $request->text;
        $sms->save();
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $sms = Sms::find($id);
        $sms->name = $request->name;
        $sms->text = $request->text;
        $sms->update();
        return redirect()->back();
    }

    public function delete(Request $request, $id)
    {
        $sms = Sms::find($id);
        $sms->delete();
        return redirect()->back();
    }


    public function getSms(Request $request)
    {
        $sms_id = $request->id;
        return $data = Sms::where('id', '=', $sms_id)->get();
    }

    public function getDepartment(Request $request)
    {
        $department_id = $request->id;
        if ($department_id == 0) {
            $data = Department::all();
        } else {
            $data = Department::where('id', '=', $department_id)->get();
        }

        return $data;
    }
    public function getEmployee(Request $request)
    {
        $employee_id = $request->id;
        return $data = Employee::where('id', '=', $employee_id)->get();
    }

    public function getFilterUsers(Request $request)
    {
        $department_id = $request->department_id;
        $branch_id = $request->branch_id;
        if ($department_id == 0 && $branch_id == 0) {
            $data = Employee::all();
        } else if ($department_id != 0 && $branch_id == 0) {
            $data = Employee::where('department', '=', $department_id)->get();
        } else if ($department_id == 0 && $branch_id != 0) {
            $data = Employee::where('branch_id', '=', $branch_id)->get();
        } else {
            $data = Employee::where('department', '=', $department_id)->where('branch_id', '=', $branch_id)->get();
        }
        return $data;
    }

    public function getBranch(Request $request)
    {
        $branch_id = $request->id;
        if ($branch_id == 0) {
            return $data = Branch::all();
        } else {
            return $data = Branch::where('id', '=', $branch_id)->get();
        }
        return $data;
    }


    public function smsBirthday(Request $request)
    {
        $today = Carbon::now()->format('m-d');
        $text = Sms::find(1)->text;
        $users = Employee::whereDay('birthday', Carbon::now())->whereMonth('birthday', Carbon::now())->get();
        foreach ($users as $user) {
            $client = new \GuzzleHttp\Client();
            $res = $client->get('http://81.95.160.47/mt/oneway?username=gorgia&password=&client_id=480&service_id='.$request->sender.'&to=+995' . $user->number . '&text='. $user->name . ' '. $text . "&coding=2");
            echo $res->getStatusCode(); // 200
            echo $res->getBody();
        }
        return redirect()->back()->withErrors(['msg' => 'შეტყობინება წარმატებით გაიგზავნა']);
    }

    public function smsUser(Request $request, $id)
    {
        $employee = Employee::find($id);
        $text = $request->sms_text;
        $client = new \GuzzleHttp\Client();
        $res = $client->get('http://81.95.160.47/mt/oneway?username=gorgia&password=&client_id=480&service_id='.$request->sender.'&to=+995' . $employee->number . '&text='. $employee->name . ' '. $text . "&coding=2");
        echo $res->getStatusCode(); // 200
        echo $res->getBody();
        return redirect()->back()->withErrors(['msg' => 'შეტყობინება წარმატებით გაიგზავნა']);
    }

    public function smsGroup(Request $request)
    {
        $client = new \GuzzleHttp\Client();

        $text = $request->sms_text;
        if($request->department && $request->branch){
            $users = Employee::where('department', $request->department)->where('branch_id', $request->branch)->get();
        }
        else if($request->department && !$request->branch){
            $users = Employee::where('department', $request->department)->get();
        }
        else if(!$request->department && $request->branch){
            $users = Employee::where('branch_id', $request->branch)->get();
        }
        else if(!$request->department && !$request->branch){
            $users = Employee::where('role', '!=', 2)->get();
        }
        
        foreach ($users as $user) {
            $res = $client->get('http://81.95.160.47/mt/oneway?username=gorgia&password=&client_id=480&service_id='.$request->sender.'&to=+995' . $user->number . '&text='. $user->name . ' '. $text . "&coding=2");
        }
        return redirect()->back()->withErrors(['msg' => 'შეტყობინება წარმატებით გაიგზავნა']);
    }


    public function test(Request $request)
    {
        // $message = $single['text'];
        // $user = $single['first_name'];
        // $number = urlencode($single['phone_number']);
        // $message = str_replace('(სახელი)', $user, $message);
        // $new_message = urlencode($message);
        // print_r($new_message);
        // Message details
        $number = array("+995599539300", "+995511200657");

        foreach ($number as $single) {
            $client = new \GuzzleHttp\Client();
            $res = $client->get('http://81.95.160.47/mt/oneway?username=gorgia&password=&client_id=480&service_id=1&to=' . $single . '&text=Test' . "&coding=2");
            echo $res->getStatusCode(); // 200
            echo $res->getBody();
        }
    }
}
