<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> @yield('title')</title>
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <!-- Font Awesome Icons -->
  {{-- <link rel="stylesheet" href="{{asset('adminlte/plugins/fontawesome-free/css/all.min.css')}}"> --}}
  <link rel="stylesheet" type="text/css" href="{{asset('font/fontawesome-5.13.1/css/all.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('lib/adminlte/css/adminlte.min.css')}}">
  <link rel="stylesheet" href="{{asset('lib/sweetalert2/css/sweetalert2.min.css')}}">
  <link href="{{asset('lib/select2/css/select2.min.css')}}" rel="stylesheet" />
  <link rel="stylesheet" href="{{asset('admin_asset/css/stylesheet.css')}}">
  @yield('css')
</head>
<body class="hold-transition sidebar-mini">
  <div class="wrapper">

    <!-- Navbar -->
  @include('admin.partials.header')
    <!-- /.navbar -->

  @include('admin.partials.sidebar')
  @yield('content')
  @include('admin.partials.footer')
  </div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script type="text/javascript" src="{{asset('lib/jquery/jquery-3.2.1.min.js')}} "></script>
<!-- Bootstrap 4 -->
<script type="text/javascript" src="{{asset('lib/bootstrap-4.5.3-dist/js/bootstrap.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('lib/adminlte/js/adminlte.min.js')}}"></script>
<script src="{{asset('lib/sweetalert2/js/sweetalert2.all.min.js')}}"></script>
{{-- <script src="{{asset('lib/tinymce5/js/tinymce.min.js')}}"></script> --}}
<script src="https://cdn.tiny.cloud/1/si5evst7s8i3p2grgfh7i5gdsk2l26daazgefvli0hmzapgn/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
{{-- <script src="{{asset('vendor/laravel-filemanager/js/stand-alone-button.js')}}"></script> --}}
<script src="{{asset('lib/select2/js/select2.min.js')}}"></script>
<script src="{{asset('admin_asset/ajax/deleteAdminAjax.js')}}"></script>
<script src="{{asset('admin_asset/js/function.js')}}"></script>
<script src="{{asset('admin_asset/js/main.js')}}"></script>

<script>
    //slug
    function ChangeToSlug()
    {
        var title, slug;
    
        //L???y text t??? th??? input title 
        title = document.getElementById("title").value;
    
        //?????i ch??? hoa th??nh ch??? th?????ng
        slug = title.toLowerCase();
    
        //?????i k?? t??? c?? d???u th??nh kh??ng d???u
        slug = slug.replace(/??|??|???|???|??|??|???|???|???|???|???|??|???|???|???|???|???/gi, 'a');
        slug = slug.replace(/??|??|???|???|???|??|???|???|???|???|???/gi, 'e');
        slug = slug.replace(/i|??|??|???|??|???/gi, 'i');
        slug = slug.replace(/??|??|???|??|???|??|???|???|???|???|???|??|???|???|???|???|???/gi, 'o');
        slug = slug.replace(/??|??|???|??|???|??|???|???|???|???|???/gi, 'u');
        slug = slug.replace(/??|???|???|???|???/gi, 'y');
        slug = slug.replace(/??/gi, 'd');
        //X??a c??c k?? t??? ?????t bi???t
        slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
        //?????i kho???ng tr???ng th??nh k?? t??? g???ch ngang
        slug = slug.replace(/ /gi, "-");
        //?????i nhi???u k?? t??? g???ch ngang li??n ti???p th??nh 1 k?? t??? g???ch ngang
        //Ph??ng tr?????ng h???p ng?????i nh???p v??o qu?? nhi???u k?? t??? tr???ng
        slug = slug.replace(/\-\-\-\-\-/gi, '-');
        slug = slug.replace(/\-\-\-\-/gi, '-');
        slug = slug.replace(/\-\-\-/gi, '-');
        slug = slug.replace(/\-\-/gi, '-');
        //X??a c??c k?? t??? g???ch ngang ??? ?????u v?? cu???i
        slug = '@' + slug + '@';
        slug = slug.replace(/\@\-|\-\@|\@/gi, '');
        //In slug ra textbox c?? id ???slug???
        document.getElementById('slug').value = slug;
    }
</script>


<script>
    let filesAmount = [];
    function removeImage(i) {
        const fileListArr = Array.from(filesAmount);
        fileListArr.splice(i);
        filesAmount = fileListArr;
        $('.preview-images').find('.img-item').eq(i).remove();
        $('.images-input').files = fileListArr;
    }
    const imagesPreview = function (input, placeToInsertImagePreview) {
        if (input.files) {
            filesAmount = input.files;
            $('.preview-images').empty();
            for (let i = 0; i < filesAmount.length; i++) {
                const reader = new FileReader();
                reader.onload = function (event) {
                    const node = document.createElement('span');
                    node.addEventListener('click', () => {
                        removeImage(i);
                    })
                    node.style.position = 'relative';
                    node.classList.add('img-item');
                    node.innerHTML = `<img src="${event.target.result}" alt="Image" style="width:150px;height:100px;"><span class="remove-img">
<div>x</div></span>`;
                    $(placeToInsertImagePreview).append(node);
                }
                reader.readAsDataURL(input.files[i]);
            }
        }
    };
    $('.images-input').on('change', function () {
        imagesPreview(this, '.preview-images');
    });
</script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    function removeRow(id, url) {
        if (confirm('X??a m?? kh??ng th??? kh??i ph???c. B???n c?? ch???c kh??ng ??')) {
            $.ajax({
                type: 'DELETE',
                datatype: 'JSON',
                data: { id },
                url: url,
                success: function (result) {
                    if (result.error === false) {
                        alert(result.message);
                        location.reload();
                    } else {
                        console.log('Xoa thanh cong');
                    }
                }
            })
        }
    }

</script>

<script>
       // ??o???n v??n
       $(document).on('click', '#addOptionProduct', function() {
        // alert('a');
        event.preventDefault();
        //  let wrapActive = $(this).parents('.wrap-load-active');
        let urlRequest = $(this).data("url");
        //let i = $('.wrap-paragraph tbody').find('tr').length;
        //  alert(urlRequest);
        $.ajax({
            type: "GET",
            url: urlRequest,
            // data: { i: i },
            success: function(data) {
                if (data.code == 200) {
                    let html = data.html;
                    $('#wrapOption').append(html);
                    // if ($("textarea.tinymce_editor_init").length) {
                    //     tinymce.init(editor_config);
                    // }
                }
            }
        });
    });
    $(document).on('click', '.deleteOptionProduct', function() {
        event.preventDefault();
        let $this = $(this);
        Swal.fire({
            title: "B???n c?? mu???n x??a option?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'T??i ?????ng ??'
        }).then((result) => {
            if (result.isConfirmed) {
                $this.parents('.item-price').remove();
            }
        })
    });
     // load delete ????p ??n  khi ????p ??n ch??a th??m database
     $(document).on('click', '.deleteOptionProductDB', function() {
        event.preventDefault();
        let urlRequest = $(this).data("url");
        let mythis = $(this);
        Swal.fire({
            title: 'B???n c?? ch???c ch???n mu???n x??a option n??y',
            text: "B???n s??? kh??ng th??? kh??i ph???c ??i???u n??y",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'T??i ?????ng ??!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "GET",
                    url: urlRequest,
                    success: function(data) {
                        if (data.code == 200) {
                            mythis.parents(".item-price").remove();
                        }
                    },
                    error: function() {

                    }
                });
                // Swal.fire(
                // 'Deleted!',
                // 'Your file has been deleted.',
                // 'success'
                // )
            }
        })
    });
</script>
@yield('js')
</body>
</html>
