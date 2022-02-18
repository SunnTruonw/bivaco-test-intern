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
                    <a href="{{route('admin.lesson.create')}}" class="btn  btn-info btn-md mb-2">+ Thêm mới</a>
                   </div>
                    {{-- <!--<div class="group-button-right d-flex">
                        <form action="{{route('admin.categoryproduct.import.excel.database')}}" class="form-inline" method="post" enctype="multipart/form-lessons">
                            @csrf
                            <div class="form-group" style="max-width: 250px">
                                <input type="file" class="form-control-file" name="fileExcel" accept=".xlsx" required>
                              </div>
                            <input type="submit" value="Import Execel" class=" btn btn-info ml-1">
                        </form>
                        <form class="form-inline ml-3" action="{{route('admin.categoryproduct.export.excel.database')}}" method="post" enctype="multipart/form-lessons">
                            @csrf
                            <input type="submit" value="Export Execel" class=" btn btn-danger">
                        </form>
                    </div>--> --}}
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
                                        {{-- <th>User_ID</th> --}}
                                        <th>Hình ảnh</th>
                                        <th>Tên danh mục</th>
                                        <th>Mô tả</th>
                                        <th>Trạng thái</th>
                                        <th>Cập nhật</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
            
                                    {{-- @foreach($lessons as $lesson)
                                        <tr>
                                            <td>{{$lesson->id}}</td>
                                            <td>
                                                <a href="{{$lesson->image}}" target="_blank" rel="noopener noreferrer">
                                                    <img src="{{$lesson->image}}" alt="" width="100px">
                                                </a>
                                            </td>
                                            <td>{{$lesson->name}}</td>
                                            <td>{{$lesson->parent_id}}</td>
                                            <td>{{$lesson->description}}</td>
                                            <td><i class="fas fa-check-circle"></i></td>
                                            
                                            <td style="display:flex">
                                                <a class="btn btn-primary btn-sm" href="{{ route('admin.lesson.edit',['id'=> $lesson->id]) }}">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                
                                                <form action="{{ route('admin.lesson.destroy',['id'=> $lesson->id]) }}" method="post">
                                                    @method('delete')
                                                    @csrf
                                                    <button  class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này không ?');">
                                                    <i class="far fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                                
                                            </td>
                                        </tr>
                                    @endforeach --}}

                                    {!! App\Helper\Helper::category($lessons) !!}
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
