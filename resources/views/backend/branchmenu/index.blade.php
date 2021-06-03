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

    <h1 class="mt-3">Menu of Branch => {{$branch->branchname}}({{$branch->branchlocation}}) <a href="{{route('branchmenu.create', $branch->id)}}" class="btn btn-primary btn-sm"> <i class="fa fa-plus" aria-hidden="true"></i> Add New Items</a> <a href="{{route('branch.index')}}" class="btn btn-success btn-sm"> <i class="fa fa-eye" aria-hidden="true"></i> All Branches</a></h1>
    <div class="card mt-3">
        <div class="card-body table-responsive">
            <table class="table table-bordered yajra-datatable text-center">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Image</th>
                        <th class="text-center">Category</th>
                        <th class="text-center">Item</th>
                        <th class="text-center">Cost Price</th>
                        <th class="text-center">Discount</th>
                        <th class="text-center">Price</th>
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
          ajax: "{{ route('branchmenu.index', $branch->id) }}",
          columns: [
              {data: 'DT_RowIndex', name: 'DT_RowIndex'},
              {data: 'photo', name: 'photo'},
              {data: 'category_id', name: 'category_id'},
              {data: 'menuitem_id', name: 'menuitem_id'},
              {data: 'costprice', name: 'costprice'},
              {data: 'discount', name: 'discount'},
              {data: 'price', name: 'price'},
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
