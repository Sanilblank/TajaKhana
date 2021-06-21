@extends('backend.layouts.app')
@push('styles')
<link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush
@section('content')
<div class="right_col" role="main">
    <!-- MAIN -->
    @if (session('success'))
    <div class="col-sm-12">
        <div class="alert  alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @endif

    <h1 class="mt-3">View Branches <a href="{{route('branch.create')}}" class="btn btn-primary btn-sm"> <i class="fa fa-plus" aria-hidden="true"></i> Register New Branch</a></h1>
    <div class="card mt-3">
        <div class="card-body table-responsive">
            <table class="table table-bordered yajra-datatable text-center">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Branch Name</th>
                        <th class="text-center">Branch Image</th>
                        <th class="text-center">Location</th>
                        <th class="text-center">Latitude</th>
                        <th class="text-center">Longitude</th>
                        <th class="text-center">Contact No</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
    $(function () {

      var table = $('.yajra-datatable').DataTable({

          processing: true,
          serverSide: true,
          ajax: "{{ route('branch.index') }}",
          columns: [
              {data: 'DT_RowIndex', name: 'DT_RowIndex'},
              {data: 'branchname', name: 'branchname'},
              {data: 'branchimage', name: 'branchimage'},
              {data: 'branchlocation', name: 'branchlocation'},
              {data: 'latitude', name: 'latitude'},
              {data: 'longitude', name: 'longitude'},
              {data: 'phone', name: 'phone'},
              {data: 'status', name: 'status'},
              {
                  data: 'action',
                  name: 'action',
                  orderable: true,
                  searchable: true
              },
          ]
      });

    });
  </script>
@endpush
