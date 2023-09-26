@extends('main.index')
@section('content')
<!-- Page Content -->
<div class="content container-fluid">
    <!-- Button trigger modal -->

    <!-- Button trigger modal -->

    <!-- Modal -->
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('sms.birthday')}}" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">დღეს დაბადებისდღ აქვს</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group drops">
                            <label>აირჩიეთ გამგზავნი</label>
                            <select class="form-select" name='sender' aria-label="Default select example">
                                <option value="1">Gorgia</option>
                                <option value="2">HR-Gorgia</option>
                                <option value="3">Standards</option>
                                <option value="4">IT-Gorgia</option>
                                <option value="5">Marketing</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-body center">
                        @foreach($employees_birthday as $employee_birthday)
                        <div class="user-day">{{$employee_birthday->name}} {{$employee_birthday->lastname}}</div>
                        @endforeach
                        <hr>
                        <button type="submit" class="btn btn-send-birthday">შეტყობინების გაგზავნა</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">თანამშრომლები</h3>
            </div>
            <div class="col-auto float-right ml-auto" data-toggle="modal" data-target="#excels_import">
                <a href="#" class="btn  excel-btn"></i>ექსელის ატვირთვა</a>
            </div>
            <div class="col-auto float-right ml-auto">
                <a href="/excel-export" class="btn  excel-btn"></i>ექსელის ჩამოტვირთვა</a>
            </div>
            <button class="btn add-btn " data-toggle="modal" data-target="#exampleModal">მიულოცე დაბადების დღე <button class="btn btn-count btn-primary">{{$employees_birthday_count}}</button></button>
            <div class="col-auto float-right ml-auto">
                <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_employee"><i class="fa fa-plus"></i>თანამშრომლის დამატება</a>
            </div>
        </div>
    </div>
    <!-- /Page Header -->

    <!-- Search Filter -->
    <form action="{{ route('employee.index')}}" method="GET">
        <div class="row filter-row">
            <div class="col-4">
                <div class="form-group form-focus">
                    <input name="user_name" type="text" class="form-control floating">
                    <label class="focus-label">პირადობა/სახელი/გვარი</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group form-focus select-focus">
                    <select name="user_departemnt" class="select floating">
                        <option value=''>ყველა</option>
                        @foreach($departments as $department)
                        <option value='{{$department->id}}'>{{$department->name}}</option>
                        @endforeach>
                    </select>
                    <label class="focus-label">დეპარტამენტი</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group form-focus select-focus">
                    <select name="user_branch" class="select floating ">
                        <option value=''>ყველა</option>
                        @foreach($branches as $branch)
                        <option value='{{$branch->id}}'>{{$branch->name}}</option>
                        @endforeach

                    </select>
                    <label class="focus-label">ფილიალი</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group form-focus select-focus">
                    <select name="user_gender" class="select floating">
                        <option value=''>ყველა</option>
                        <option value='1'> მამრობით</option>
                        <option value='2'> მდედრობით</option>
                    </select>
                    <label class="focus-label">სქესი</label>
                </div>
            </div>

            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <button class="btn btn-success btn-block"> მოძებნე </button>
            </div>


        </div>
    </form>

    <!-- /Search Filter -->

    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped custom-table mb-0 datatable">
                    <thead>
                        <tr>
                            <th class="text-center">პიარდი ნომერი</th>
                            <th class="text-center">სახელი გვარი</th>
                            <th class="text-center">ტელეფონი</th>
                            <th class="text-center">განყოფილება</th>
                            <th class="text-center">ფილიალი</th>
                            <th class="text-center">დაბადების თარიღი</th>
                            <!-- <th class="text-center">მუშაობის დაწყება</th> -->
                            <th class="text-center">სქესი</th>
                            <th class="text-right">პარამეტრები</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($employees) && $employees->count())
                        @foreach ($employees as $employee)
                        @php
                        $branch = DB::table('branches')
                        ->where('id', '=', $employee->branch_id)
                        ->first();
                        $department = DB::table('departments')
                        ->where('id', '=', $employee->department)
                        ->first();
                        @endphp
                        <tr>
                            <td class="text-center">{{$employee->id_number}}</td>
                            <td class="text-center">{{$employee->name}} {{$employee->lastname}}</td>
                            <td class="text-center">{{$employee->number}}</td>
                            <td class="text-center">
                                @if($department)
                                {{$department->name}}
                                @endif
                            </td>
                            <td class="text-center">
                                @if($branch)
                                {{$branch->name}}
                                @endif
                            </td>
                            <td class="text-center">{{$employee->birthday}}</td>
                            <!-- <td class="text-center">{{$employee->start_date}}</td> -->
                            <td class="text-center">{{ $employee->gender == "1" ? "მამრობითი" : "მდედრობით" }}</td>
                            <td class="text-right">
                                <div class="dropdown dropdown-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#send_sms_user_{{$employee->id}}"> შეტყობინების გაგზავნა</a>
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edits_{{$employee->id}}"><i class="fa fa-pencil m-r-5"></i> რედაქტირება</a>
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_{{$employee->id}}"><i class="fa fa-trash-o m-r-5"></i>
                                            წაშლა</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="10">
                                <div>{!! $employees->appends(Request::all())->links() !!}</div>
                            </td>
                        </tr>
                        @else
                        <tr>
                            <td colspan="10">There are no data.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /Page Content -->

<!-- Add employee -->
<div id="add_employee" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">თანამშრომლის დამატება</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('employee.store')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>სახელი</label>
                                <input class="form-control" name='name' type="text" required placeholder="სახელი">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>გვარი</label>
                                <input class="form-control" name='lastname' type="text" required placeholder="გვარი">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>პირადი ნომერი</label>
                                <input class="form-control" name='id_number' type="text" required placeholder="პირადი ნომერი">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>ტელეფონის ნომერი</label>
                                <input class="form-control" name='number' type="number" required placeholder="ტელეფონის ნომერი">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>დაბადების თარიღი</label>
                                <div>
                                    <input class="form-control " name='birthday' type="date">
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-sm-6">
                            <div class="form-group">
                                <label>მუშაობის დაწყები თარიღი</label>
                                <div>
                                    <input class="form-control" name='start_date' type="date">
                                </div>
                            </div>
                        </div> -->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>სქესი</label>
                                <select class="select" name='gender'>
                                    <option value='0'>აირჩიეთ სქესი</option>
                                    <option value='1'>მამრობითი</option>
                                    <option value='2'>მდედრობითი</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>ფილიალი</label>
                                <select class="select" name='branch'>
                                    <option value='0'>აირჩიეთ ფილიალი</option>
                                    @foreach($branches as $branch)
                                    <option value='{{$branch->id}}'>{{$branch->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>დეპარტამენტი</label>
                                <select class="select" name='department'>
                                    <option value='0'>აირჩიეთ დეპარტამენტი</option>
                                    @foreach($departments as $department)
                                    <option value='{{$department->id}}'>{{$department->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- <div class="col-sm-6">
                            <div class="form-group">
                                <label>პოზიცია</label>
                                <input class="form-control" type="text" placeholder="პოზიცია" name='position'>
                            </div>
                        </div> -->

                    </div>

                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">დამატება</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="excels_import" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="excel-import" method="post" enctype=multipart/form-data>
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>ექსელის ფაილი</label>
                                <input class="form-control" name='excel' type="file" required placeholder="სახელი">
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">დამატება</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- /Add employee-->




<div id="birthday_employee" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <form action="{{ route('sms.birthday')}}" method="post">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">დღეს დაბადებისდღ აქვს</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body center">
                    @foreach($employees_birthday as $employee_birthday)
                    <div class="user-day">{{$employee_birthday->name}} {{$employee_birthday->lastname}}</div>
                    @endforeach
                    <hr>
                    <button type="submit" class="btn btn-send-birthday">შეტყობინების გაგზავნა</button>
                </div>
            </div>
        </form>
    </div>
</div>


@foreach ($employees as $employee)
@php
$branch = DB::table('branches')
->where('id', '=', $employee->branch_id)
->first();
$department = DB::table('departments')
->where('id', '=', $employee->department)
->first();
@endphp

<!-- Edit Ticket Modal -->
<div id="edits_{{$employee->id}}" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">თანამშრომლის დამატება</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('employee.update', ['id' => $employee->id])}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>სახელი</label>
                                <input class="form-control" value="{{$employee->name}}" name='name' type="text" placeholder="სახელი">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>გვარი</label>
                                <input class="form-control" name='lastname' value="{{$employee->lastname}}" type="text" placeholder="გვარი">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>პირადი ნომერი</label>
                                <input class="form-control" name='id_number' value="{{$employee->id_number}}" type="text" placeholder="პირადი ნომერი">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>ტელეფონის ნომერი</label>
                                <input class="form-control" name='number' type="number" value="{{$employee->number}}" placeholder="ტელეფონის ნომერი">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>დაბადების თარიღი</label>
                                <div>
                                    <input class="form-control " name='birthday' value="{{$employee->birthday}}" type="date">
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-sm-6">
                            <div class="form-group">
                                <label>მუშაობის დაწყები თარიღი
                                </label>
                                <div>
                                    <input class="form-control" name='start_date' value="{{$employee->start_date}}" type="date">
                                </div>
                            </div>
                        </div> -->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>სქესი</label>
                                <select class="select" name='gender'>
                                    <option value="{{$employee->gender}}">{{ $employee->name === "1" ? "მამრობითი" : "მდედრობით" }}</option>
                                    <option value="1">მამრობითი</option>
                                    <option value="1">მდედრობითი</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>ფილიალი</label>
                                <select class="select" name='branch'>
                                    <option value="{{$employee->branch_id}}">
                                        @if($branch)
                                        {{$branch->name}}
                                        @endif
                                    </option>
                                    @foreach($branches as $branch)
                                    <option value='{{$branch->id}}'>{{$branch->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>დეპარტამენტი</label>
                                <select class="select" name='department'>
                                    <option value="{{$employee->department}}">
                                        @if($department)
                                        {{$department->name}}
                                        @endif
                                    </option>
                                    @foreach($departments as $department)
                                    <option value='{{$department->id}}'>{{$department->name}}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <!-- <div class="col-sm-6">
                            <div class="form-group">
                                <label>პოზიცია</label>
                                <input class="form-control" type="text" placeholder="პოზიცია" value="{{$employee->name}}" name='position'>
                            </div>
                        </div> -->

                    </div>

                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">განახლება</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Edit Ticket Modal -->

<!-- Delete Ticket Modal -->
<div class="modal custom-modal fade" id="send_sms_user_{{$employee->id}}" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('sms.user', ['id' => $employee->id])}}" method="post">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">შეტყობინების გაგზავნა</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body drops">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle text-btn w-100" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        აირჩიეთ შეტყობინება
                                    </button>
                                    <div class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton">
                                        @foreach ($sms as $s)
                                        <li class="dropdown-item sms_user_{{ $s->id }}" value="{{ $s->id }}">{{ $s->name }}</li>
                                        <input id='hidden_id_{{$s->id}}' value='{{$s->id}}' type='hidden'>
                                        <script>
                                            $(".sms_user_{{ $s->id }}").click(function() {
                                                req = $.ajax({
                                                    type: 'get',
                                                    url: '{{ url("/get-sms-ajax")}}',
                                                    data: 'id=' + $('#hidden_id_{{$s->id}}').val(),
                                                    success: function(response) {
                                                        console.log(response)
                                                        $('#sms_text_{{$employee->id}}').val(response[0].text);
                                                    }
                                                })
                                                XMLHttpRequest.abort()
                                            })
                                        </script>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group drops">
                                <label>აირჩიეთ გამგზავნი</label>
                                <select class="form-select" name='sender' aria-label="Default select example">
                                    <option value="1">Gorgia</option>
                                    <option value="2">HR-Gorgia</option>
                                    <option value="3">Standards</option>
                                    <option value="4">IT-Gorgia</option>
                                    <option value="5">Marketing</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>ტექსტი</label>
                                <textarea class="form-control" id='sms_text_{{$employee->id}}' name="sms_text" type="text"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="submit-section">
                        <button type="submit" class="btn btn-primary submit-btn user-sms-submit">გაგზავნა</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="modal custom-modal fade" id="delete_{{$employee->id}}" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h3>თანამშრომლის წაშლა</h3>
                    <p>დარწმუნებული ხართ რომ გსურთ წაშლა</p>
                </div>
                <div class="modal-btn delete-action">
                    <form action="{{ route('employee.delete', ['id' => $employee->id])}}" method="post">
                        @csrf
                        @method('delete')
                        <div class="row">
                            <div class="col-6">
                                <button type="submit" class="btn btn-primary continue-btn">დადასურება</button>
                            </div>
                            <div class="col-6">
                                <button type="button" data-dismiss="modal" class="btn btn-primary cancel-btn">გაუქმება</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@if($errors->any())
<script>
    swal("{{$errors->first()}}", "", "success");
</script>
@endif
@endforeach
<input name="user_name" type="hidden" id="hidden_birthday" value="{{$birthdaySms->text}}" class="form-control floating">
@endsection