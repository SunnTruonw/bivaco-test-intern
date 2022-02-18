<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Requests\LessonRequest;
use App\Models\Lesson;
use Illuminate\Http\Request;
use DB;

class AdminLessonController extends Controller
{

    public function index()
    {
        $lessons = Lesson::orderBy('id', 'desc')->paginate(10);

        return view('admin.pages.lesson.list', compact('lessons'));
    }

    public function create()
    {
        $categories = Lesson::all();

        return view('admin.pages.lesson.add', compact('categories'));
    }


    public function store(LessonRequest $request)
    {
        // //check if product has image
        // dd($request->all());
        // dd($request->has('thumbnail'));
        if ($request->has('thumbnail')) {
            $file = $request->thumbnail;
            $filename = $file->hashName(); // tạo file ngẫu nhiễn
            $file->move(public_path('admin_asset/images'), $filename);
        }
        $request->merge(['image' => $filename]);

        // dd($request->all());



        if (Lesson::create([
            'name' =>  $request->input('name'),
            'slug' =>  $request->input('slug'),
            'parent_id' =>  $request->input('parent_id'),
            'description' =>  $request->input('description'),
            'keyword' =>  $request->input('keyword'),
            'title_seo' =>  $request->input('title_seo'),
            'description_seo' =>  $request->input('description_seo'),
            'content' =>  $request->input('content'),
            'image' =>  $request->image,
            'numerical' =>  $request->input('numerical'),
            'active' =>  $request->input('active'),
        ])) {
            return redirect(url()->previous() . '#success')->with('success', 'Thêm bài thành công !');
        }
    }



    public function edit($id)
    {
        $lesson = Lesson::find($id);


        $categories = Lesson::all();

        return view('admin.pages.lesson.edit', compact('categories', 'lesson'));
    }


    public function update(LessonRequest $request, $id)
    {

        if ($request->has('thumbnail')) {
            $file = $request->thumbnail;
            $filename = $file->hashName(); // tạo file ngẫu nhiễn
            $file->move(public_path('admin_asset/images'), $filename);

            $request->merge(['image' => $filename]);

            //update co anh
            Lesson::where('id', $id)
                ->update([
                    'name' =>  $request->input('name'),
                    'slug' =>  $request->input('slug'),
                    'parent_id' =>  $request->input('parent_id'),
                    'description' =>  $request->input('description'),
                    'keyword' =>  $request->input('keyword'),
                    'title_seo' =>  $request->input('title_seo'),
                    'description_seo' =>  $request->input('description_seo'),
                    'content' =>  $request->input('content'),
                    'image' =>  $request->image,
                    'numerical' =>  $request->input('numerical'),
                    'active' =>  $request->input('active'),
                ]);
        } else {
            //update k anh

            Lesson::where('id', $id)
                ->update([
                    'name' =>  $request->input('name'),
                    'slug' =>  $request->input('slug'),
                    'parent_id' =>  $request->input('parent_id'),
                    'description' =>  $request->input('description'),
                    'keyword' =>  $request->input('keyword'),
                    'title_seo' =>  $request->input('title_seo'),
                    'description_seo' =>  $request->input('description_seo'),
                    'content' =>  $request->input('content'),
                    'numerical' =>  $request->input('numerical'),
                    'active' =>  $request->input('active'),
                ]);
        }

        session()->flash('success', 'Cập nhật  thành công');

        return redirect('admin/lesson');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->input('id');
        $lesson = Lesson::where('id', $id)->first();

        $lesson->delete();

        return response()->json([
            'error' => false,
            'message' => 'Xóa thành công danh mục'
        ]);
    }
}
