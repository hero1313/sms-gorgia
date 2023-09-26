@extends('main.index')
@section('content')
<!-- Page Content -->
<div class="content container-fluid">

    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">შეტყობინებები</h3>
            </div>
            <div class="col-auto float-right ml-auto">
                <a href="#" class="btn add-btn " data-toggle="modal" data-target="#add_sms"><i class="fa fa-plus"></i>შეტყობინების დამატება</a>

                <a href="#" class="btn add-btn mr-5" data-toggle="modal" data-target="#send_sms">შეტყობინების გაგზავნა</a>
            </div>
        </div>
    </div>
    <!-- /Page Header -->


    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped custom-table mb-0 datatable">
                    <thead>
                        <tr>
                            <th class="text-center">შეტყობინების სახელი</th>
                            <th class="text-center">ტექსტი</th>
                            <th class="text-right">პარამეტრები</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sms as $s)
                        <tr>
                            <td class="text-center">{{$s->name}}</td>
                            <td class="text-center">{{$s->text}}</td>
                            <td class="text-right">
                                <div class="dropdown dropdown-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_{{$s->id}}"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                        @if($s->id != 1)
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_{{$s->id}}"><i class="fa fa-trash-o m-r-5"></i>
                                            Delete</a>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /Page Content -->

<!-- Add sms -->
<div id="add_sms" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">შეტყობინების დამატება</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('sms.store')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>შეტყობინების სახელი</label>
                                <input class="form-control" name='name' type="text" placeholder="სახელი">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>ტექსტი</label>
                                <textarea class="form-control" name='text' id="exampleFormControlTextarea1" type="text" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">დამატება</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Add sms-->


<!-- send sms -->
<div id="send_sms" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <form action="{{ route('sms.group')}}" method="post">
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
                                <label>აირჩიეთ შეტყობინება</label>

                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle text-btn w-100" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        აირჩიეთ შეტყობინება
                                    </button>
                                    <div class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton">
                                        @foreach ($sms as $s)
                                        <li class="dropdown-item" id="sms_{{ $s->id }}" value="{{ $s->id }}">{{ $s->name }}</li>
                                        <script>
                                            $("#sms_{{ $s->id }}").click(function() {
                                                var id = $("#sms_{{ $s->id }}").val();
                                                $.ajax({
                                                    type: 'get',
                                                    url: '{{ url("/get-sms-ajax")}}',
                                                    data: 'id=' + id,
                                                    success: function(response) {
                                                        $('#sms_text').val(response[0].text);
                                                        $(".text-btn").html(response[0].name);
                                                    }
                                                })
                                            })
                                        </script>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-sm-12">
                            <div class="form-group drops">
                                <label>აირჩიეთ დეპარტამენტი</label>
                                <select class="form-select" name='department' aria-label="Default select example">
                                    <option value="">ყველა დეპარტამენტი</option>
                                    @foreach ($departments as $department)
                                    <option value="{{$department->id}}">{{$department->name}}</option>
                                    @endforeach
                                </select>
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
                            <div class="form-group drops">
                                <label>აირჩიეთ ფილიალი</label>
                                <select class="form-select" name='branch' aria-label="Default select example">
                                    <option value="">ყველა ფილიალი</option>
                                    @foreach ($branches as $branch)
                                    <option value="{{$branch->id}}">{{$branch->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>ტექსტი</label>
                                <textarea class="form-control" id='sms_text' name='sms_text' type="text"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="submit-section">
                        <button type="submit" class="btn btn-primary submit-btn">გაგზავნა</button>
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>
<!-- /Add sms-->


@foreach ($sms as $s)
<!-- Edit Ticket Modal -->
<div id="edit_{{$s->id}}" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">შეტყობინების რედაქტირება</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('sms.update', ['id' => $s->id])}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>შეტყობინების სახელი</label>
                                <input class="form-control" value="{{$s->name}}" name='name' type="text" placeholder="სახელი">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>ტექსტი</label>
                                <textarea class="form-control" name='text' id="exampleFormControlTextarea1" type="text" rows="3">{{$s->text}}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">დამატება</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Edit Ticket Modal -->

<!-- Delete Ticket Modal -->
<div class="modal custom-modal fade" id="delete_{{$s->id}}" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h3>შეტყობინების წაშლა</h3>
                    <p>დარწმუნებული ხართ რომ გსურთ წაშლა</p>
                </div>
                <div class="modal-btn delete-action">
                    <form action="{{ route('sms.delete', ['id' => $s->id])}}" method="post">
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
</div>`
@endforeach
@if($errors->any())
<script>
    swal("{{$errors->first()}}", "", "success");
</script>
@endif
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@endsection