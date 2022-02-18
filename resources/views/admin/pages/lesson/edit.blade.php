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
    {{-- @include('admin.partials.alert') --}}
    <div class="container mt-2">
        <form action="{{route('admin.lesson.update', ['id'=> $lesson->id])}}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="row">
            

                <div class="col-9">
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-2 control-label" for="">Tên danh mục</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" value="{{$lesson->name}}" id="title" aria-describedby="emailHelp" onkeyup="ChangeToSlug()" placeholder="Nhập tên danh mục">

                                <div class="invalid-feedback d-block"></div>
                                
                            </div>
                        </div>
                    </div>
                
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-2 control-label" for="">Slug</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="slug" value="{{$lesson->slug}}" id="slug" placeholder="Nhập slug">

                                <div class="invalid-feedback d-block"></div>
                                
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                        <label class="col-sm-2 control-label" for="">Danh mục cha</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="parent_id" id="parent_id">
                                <option value="">-- Chọn danh mục cha --</option>
                                <option {{$lesson->parent_id==0 ? 'selected' : ''}} value="0">Danh muc cha</option>
                                @foreach($categories as $cate)
                                    @if($cate->parent_id == 0)
                                        <option {{$cate->id == $lesson->parent_id ? 'selected' : ''}} value="{{$cate->id}}">{{$cate->name}}</option>
                                    @endif
                                @endforeach  
                            </select>
                            
                            <div class="invalid-feedback d-block"></div>
                            
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-2 control-label" for="">Nhập giới thiệu</label>
                            <div class="col-sm-10">
                                <textarea class="form-control"  name="description" value="" id="" rows="3"  placeholder="Nhập giới thiệu">{{$lesson->description}}</textarea>
                                
                                <div class="invalid-feedback d-block"></div>
                                
                            </div>
                        </div>


                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-2 control-label" for="">Nhập nội dung</label>
                            <div class="col-sm-10">
                                <textarea class="form-control tinymce_editor_init" id="" name="content" rows="20" value=""  placeholder="Nhập nội dung" >
                                {{$lesson->content}}
                                </textarea>
                                
                                <div class="invalid-feedback d-block"></div>
                             
                            </div>
                        </div>

                    </div>
               
                </div>
                </div>
            
            
                <div class="col-3">
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="title_seo" value="{{$lesson->title_seo}}" id="" aria-describedby="emailHelp" placeholder="Nhập title seo">

                        <div class="invalid-feedback d-block"></div>
                        
                    </div>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="keyword" value="{{$lesson->keyword}}" id="name" aria-describedby="emailHelp" placeholder="Nhập khóa seo">

                        <div class="invalid-feedback d-block"></div>
                        
                    </div>
                    <div class="col-sm-10">
                        <textarea type="text" class="form-control" name="description_seo" value="" id="name" aria-describedby="emailHelp" placeholder="Nhập mô tả seo">{{$lesson->description_seo}}</textarea>

                        <div class="invalid-feedback d-block"></div>
                        
                    </div>

                    

                    <div class="col-md-4">
                        <p>Ảnh đại diện</p>
                        <img id="output" class="avatar border-radius-lg w-100 h-auto"
                            src="{{ asset('admin_asset/images/' . $lesson->image) }}">
                        <hr />
                        <input type="hidden" value="{{$lesson->image}}">
                        <input type="file" name="thumbnail" accept="image/*" onchange="loadFile(event)"
                            class="form-input">
                        <!-- view image befor upload -->
                        <script>
                            var loadFile = function(event) {
                                var output = document.getElementById('output');
                                output.src = URL.createObjectURL(event.target.files[0]);
                                output.onload = function() {
                                    URL.revokeObjectURL(output.src) // free memory
                                }
                            };
                        </script>
                    </div>

                    <div class="form-group mt-4">
                        <div class="row">
                            <label class="col-sm-2 control-label" for="">Số thứ tự</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="numerical" value="{{$lesson->numerical}}" aria-describedby="emailHelp" placeholder="Nhập tên danh mục">

                                <div class="invalid-feedback d-block"></div>
                                
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-2 control-label" for="">Trạng thái</label>
                            <div class="col-sm-10">
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                    <input type="radio" class="form-check-input" value="1" name="active" {{$lesson->active == 1 ? 'checked' : ''}}>Hiện
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" value="0" {{$lesson->active == 0 ? 'checked' : ''}} name="active">Ẩn
                                    </label>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">Sửa giới thiệu</button>
                    </div>
                </div>

               
        </form>         
    </div>
</div>


@endsection
@section('js')




@endsection
