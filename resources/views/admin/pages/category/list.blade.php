@extends('admin.layouts.main')
@section('title',"danh sach danh mục sản phẩm")
@section('css')
    <style>
         .card-header  {
            color: #4c4d5a;
            border-color: #dcdcdc;
            background: #f6f6f6;
            text-shadow: 0 -1px 0 rgb(50 50 50 / 0%);
        }
        .title-card-recusive{
            font-size: 13px;
            background: #ECF0F5;
        }
        .lb_list_category{
            font-size: 13px;
            margin-bottom: 0;
        }
        .fa-check-circle{
            color: #169F85;
            font-size: 18px;
        }
        .fa-check-circle{
            color: #169F85;
            font-size: 18px;
        }
        .fa-times-circle{
            color: #f23b3b;
           font-size: 18px;
        }
    </style>
@endsection
@section('content')
<div class="content-wrapper">


    <!-- Main content -->
    <p>@include('admin.partials.alert')</p>
    <div class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                @if(session("alert"))
                <div class="alert alert-success">
                    {{session("alert")}}
                </div>
                @elseif(session('error'))
                <div class="alert alert-warning">
                    {{session("error")}}
                </div>
                @endif
                <div class="d-flex justify-content-end">
                   <div class="text-right w-100">
                    <a href="{{route('admin.category.create')}}" class="btn  btn-info btn-md mb-2">+ Thêm mới</a>
                   </div>
                    
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"></h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Tên danh mục</th>
                                        <th>Slug</th>
                                        <th>Trạng thái</th>
                                        <th>Cập nhật</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
            
                                    

                                    {!! App\Helper\Helper::menu($categories) !!}
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>

@endsection

@section('js')

@endsection
