@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Products</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('products.create') }}"> Create New Product</a>
            </div>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <div class="col-lg-10">
        <table class="table table-bordered center data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Discount</th>
                    <th>Types</th>
                    <th width="200px">Action</th>
                </tr>
            </thead>
        </table>
    </div>
    <script type="text/javascript">
        $(function () {
          var table = $('.data-table').DataTable({
              processing: true,
              serverSide: true,
              ajax: "{{ route('products.index') }}",
              columns: [
                  {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                  {data: 'image', name: 'image'},
                  {data: 'name', name: 'name'},
                  {data: 'description', name: 'description'},
                  {data: 'price', name: 'price'},
                  {data: 'discount', name: 'discount'},
                  {data: 'type', name: 'type'},
                  {data: 'action', name: 'action', orderable: true, searchable: true},
              ]
          });
        });
    </script>
@endsection