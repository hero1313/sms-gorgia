@extends('main.index')
@section('content')
<!-- Page Content -->
<div class="content container-fluid">

    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">დეპარტამენტები</h3>
            </div>
            <div class="col-auto float-right ml-auto">
                <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_department"><i class="fa fa-plus"></i>დეპარტამენტის დამატება</a>
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
                            <th class="text-center">აიდი</th>
                            <th class="text-center">დეპარტამენტის სახელი</th>
                            <th class="text-right">პარამეტრები</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($departments as $department)
                        <tr>
                            <td class="text-center">{{$department->id}}</td>
                            <td class="text-center">{{$department->name}}</td>
                            <td class="text-right">
                                <div class="dropdown dropdown-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_{{$department->id}}"><i class="fa fa-trash-o m-r-5"></i>
                                            Delete</a>
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

<!-- Add employee -->
<div id="add_department" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">დეპარტამენტის დამატება</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('department.store')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>სახელი</label>
                                <input class="form-control" name='name' type="text" placeholder="სახელი">
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
<!-- /Add employee-->


@foreach ($departments as $department)
<!-- Delete Ticket Modal -->
<div class="modal custom-modal fade" id="delete_{{$department->id}}" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h3>დეპარტამენიტს წაშლა</h3>
                    <p>დარწმუნებული ხართ რომ გსურთ წაშლა</p>
                </div>
                <div class="modal-btn delete-action">
                <form action="{{ route('department.delete', ['id' => $department->id])}}"  method="post">
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
@endforeach
@endsection