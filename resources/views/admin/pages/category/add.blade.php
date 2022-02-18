@extends('admin.layouts.main')
@section('title',"Thêm giới thiệu")
@section('css')
<link href="{{asset('lib/select2/css/select2.min.css')}}" rel="stylesheet" />
<style>
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #000 !important;
    }
    .select2-container .select2-selection--single {
        height: auto;
    }
    .tinymce_editor_init{
        height: 300px !important;
    }
</style>

@endsection
@section('content')
<div class="content-wrapper">
    @include('admin.partials.content-header',['name'=>"Sản phẩm","key"=>"Thêm Sản phẩm"])
    <!-- Main content -->
    <p>@include('admin.partials.alert')</p>
    <div class="container mt-2">
        <form action="{{route('admin.category.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-2 control-label" for="">Tên danh mục</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="name" id="title" aria-describedby="emailHelp" onkeyup="ChangeToSlug()" placeholder="Nhập tên danh mục">

                            <div class="invalid-feedback d-block"></div>
                            
                        </div>
                    </div>
                </div>
            
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-2 control-label" for="">Slug</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="slug" value="{{old('slug')}}" id="slug" placeholder="Nhập slug">

                            <div class="invalid-feedback d-block"></div>
                            
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                    <label class="col-sm-2 control-label" for="">Danh mục cha</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="parent_id" id="parent_id">
                            
                            <option value="">-- Chọn danh mục --</option>
                            <option value="0">Danh muc cha</option>
                            @foreach($categories as $cate)
                                @if($cate->parent_id == 0)
                                    <option value="{{$cate->id}}">{{$cate->name}}</option>
                                @endif
                            @endforeach  
                        </select>
                        
                        <div class="invalid-feedback d-block"></div>
                        
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-2 control-label" for="">Trạng thái</label>
                        <div class="col-sm-10">
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                <input type="radio" class="form-check-input" value="1" name="active" checked>Hiện
                                </label>
                            </div>
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" value="0" name="active">Ẩn
                                </label>
                            </div>
                            @error('active')
                            <div class="invalid-feedback d-block"></div>
                            @enderror
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">Thêm giới thiệu</button>

        </form>         
    </div>
</div>


@endsection
@section('js')




@endsection
