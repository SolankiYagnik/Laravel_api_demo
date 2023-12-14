@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
                <div class="row justify-content-between mb-3">
                    <div class="col-md-6">
                        <h2>Products</h2>
                    </div>
                    <div class="col-md-6 text-right">
                        <a class="btn btn-success" href="{{ route('products.create') }}">Create New Product</a>
                    </div>
                </div>
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-bordered table-striped center data-table">
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
    </div>
</div>
<script type="text/javascript">
    $(function () {
      var table = $('.data-table').DataTable({
          processing: true,
          serverSide: true,
          "infoEmpty": true,
          "bLengthChange": false,
            // "lengthMenu": [ 5,10, 15, 20,],
          "pageLength": 5,
          ajax: "{{ route('products.index') }}",
          columns: [
              {data: 'DT_RowIndex', name: 'DT_RowIndex'},
              {data: 'image', name: 'image'},
              {data: 'name', name: 'name'},
              {data: 'description', name: 'description'},
              {data: 'price', name: 'price'},
              {data: 'discount', name: 'discount'},
              {data: 'type', name: 'type'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });
    });
</script>
@endsection
