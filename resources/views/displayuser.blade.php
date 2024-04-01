<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel CRUD using ajax</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    {{--    <link rel="stylesheet"--}}
    {{--          href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/jquery.dataTables.min.css"--}}
    {{--          integrity="sha512-1k7mWiTNoyx2XtmI96o+hdjP8nn0f3Z2N4oF/9ZZRgijyV4omsKOXEnqL1gKQNPy2MTSP9rIEWGcH/CInulptA=="--}}
    {{--          crossorigin="anonymous" referrerpolicy="no-referrer"/>--}}

    <link rel="stylesheet" href="https://cdn.datatables.net/rowgroup/1.1.1/css/rowGroup.bootstrap4.min.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.bootstrap4.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body>

<div class="fluid-container mt-5 p-2">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Users Details <a href="{{route('form')}}" type="button" class="btn btn-primary float-end"
                                         title="Add New User"><i
                                class="bi bi-plus-circle"></i> Add
                            User</a> <a href="{{ route('admin.logout') }}" class="btn float-end me-3"
                                        style="border: none"><i
                                class="bi bi-box-arrow-in-right me-1"></i>Logout</a></h3>
                </div>
                <div class="card-body">
                    {{--                    <table id="example2" class="table table-striped table-bordered" style="width:100%">--}}
                    {{--                        <thead>--}}
                    {{--                        <tr>--}}
                    {{--                            <th>Id</th>--}}
                    {{--                            <th>Name</th>--}}
                    {{--                            <th>Email</th>--}}
                    {{--                            <th>Password</th>--}}
                    {{--                            <th>Contact</th>--}}
                    {{--                            <th>Gender</th>--}}
                    {{--                            <th>Country</th>--}}
                    {{--                            <th style="width: 10%">Hobbies</th>--}}
                    {{--                            <th>Address</th>--}}
                    {{--                            <th>Image</th>--}}
                    {{--                            <th>Action</th>--}}
                    {{--                        </tr>--}}
                    {{--                        </thead>--}}
                    {{--                        <tbody>--}}
                    {{--                        @if(count($all_users) > 0)--}}
                    {{--                            @foreach($all_users as $user)--}}
                    {{--                                <tr>--}}
                    {{--                                    <td>{{ $n }}</td>--}}
                    {{--                                    <td>{{$user->username}}</td>--}}
                    {{--                                    <td>{{$user->useremail}}</td>--}}
                    {{--                                    <td>{{$user->userpassword}}</td>--}}
                    {{--                                    <td>{{$user->usercontact}}</td>--}}
                    {{--                                    <td>{{$user->usergender}}</td>--}}
                    {{--                                    <td>{{$user->usercountry}}</td>--}}
                    {{--                                    <td>{{$user->userhobbies}}</td>--}}
                    {{--                                    <td>{{$user->useraddress}}</td>--}}
                    {{--                                    <td style="text-align: center"><img src="{{asset('images/'.$user->userimage)}}" width="120px" height="120px" style="object-fit: contain">--}}
                    {{--                                    </td>--}}
                    {{--                                    <td><a href="{{ route('edit', $user->id) }}" class="btn btn-primary">Edit</a><a>--}}
                    {{--                                            <button class="btn btn-danger delete" data="{{$user->id}}">Delete</button>--}}
                    {{--                                        </a></td>--}}
                    {{--                                </tr>--}}
                    {{--                                @php--}}
                    {{--                                    $n++;--}}
                    {{--                                @endphp--}}
                    {{--                            @endforeach--}}
                    {{--                        @else--}}
                    {{--                            <td colspan="11">No Data Found</td>--}}
                    {{--                        @endif--}}
                    {{--                        </tbody>--}}
                    {{--                    </table>--}}
                    <table class="table table-striped table-bordered table-striped yajra-datatable">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Contact</th>
                            <th>Gender</th>
                            <th>Country</th>
                            <th style="width: 10%">Hobbies</th>
                            <th>Address</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
{{--<script src="https://code.jquery.com/jquery-3.7.1.js"></script>--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>--}}
{{--<script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>--}}
{{--<script src="https://cdn.datatables.net/2.0.1/js/dataTables.bootstrap5.js"></script>--}}
{{--<script src="https://cdn.datatables.net/responsive/3.0.0/js/dataTables.responsive.js"></script>--}}
{{--<script src="https://cdn.datatables.net/responsive/3.0.0/js/responsive.bootstrap5.js"></script>--}}


{{--<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>--}}
{{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>--}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"
        integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/dataTables.bootstrap4.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.5/js/responsive.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

<script>

    $(document).ready(function () {
        var table = $('.yajra-datatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('user.list') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: true, searchable: false},
                {data: 'username', name: 'username'},
                {data: 'useremail', name: 'useremail'},
                // {data: 'userpassword', name: 'userpassword'},
                {data: 'usercontact', name: 'usercontact'},
                {data: 'usergender', name: 'usergender'},
                {data: 'usercountry', name: 'usercountry'},
                {data: 'userhobbies', name: 'userhobbies'},
                {data: 'useraddress', name: 'useraddress'},
                {
                    data: 'userimage', name: 'userimage', "orderable": false,
                    render: function (data, type, full, meta) {
                        return '<div class="d-flex justify-content-center"> ' +
                            '<img src="{{asset('images/')}}/' + data + '" width="120px" height="120px" style="object-fit: contain">' +
                            '</div>';
                    }
                },
                {
                    data: 'action', "orderable": false,
                    name: 'action',
                    searchable: true,
                },
            ],
            order: [[0, 'desc']]
        });
    });
    $('body').on('click', '.delete', function (e) {
        var id = $(this).attr('data-id');
        Swal.fire({
            title: 'Are you sure you want to delete this record?',
            showClass: {popup: 'animate__animated animate__fadeInDown'},
            text: 'You will not be able to recover this record!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            showCloseButton: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('delete', '') }}" + "/" + id,
                    success: function (response) {
                        if (response.message === 'success') {
                            $(e.target).closest('tr').remove();
                            $('.yajra-datatable').DataTable().ajax.reload();
                            Swal.fire(
                                'Deleted!',
                                'Your record has been deleted successfully.',
                                'success'
                            );
                        }
                    },
                    error: function (response) {
                        Swal.fire(
                            'Error!',
                            'Something went wrong while deleting the record.',
                            'error'
                        );
                    },
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire({
                    title: 'Cancelled',
                    icon: 'error',
                    text: 'Your record is safe!',
                    confirmButtonText: 'Ok',
                    confirmButtonColor: '#3085d6',
                });
            }
        });
    });
</script>

</body>
</html>




