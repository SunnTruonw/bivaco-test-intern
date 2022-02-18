<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class AdminCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();

        // dd($categories);

        return view('admin.pages.category.list', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::orderByDesc('id')->get();

        return view('admin.pages.category.add', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        try {
            Category::create($request->all());

            session()->flash('success', 'Thêm danh mục thành công');

            return back();
        } catch (\Exception $exception) {
            //throw $th;
            dd($exception);
            session()->flash('error', 'Lỗi rồi. Vui lòng thử lại');
        }
    }


    public function edit($id)
    {
        $category = Category::find($id);
        $categories = Category::orderByDesc('id')->get();

        return view('admin.pages.category.edit', compact('categories', 'category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        try {
            $category = Category::find($id);

            $category->name = $request->input('name');
            $category->slug = $request->input('slug');
            $category->parent_id = $request->parent_id;
            $category->active = $request->input('active');

            $category->save();

            session()->flash('success', 'Cập nhật danh mục thành công');

            return redirect('admin/category');
        } catch (\Exception $exception) {
            //throw $th;
            dd($exception);

            session()->flash('error', 'Lỗi! Vui lòng thử lại');
        }
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
        $lesson = Category::where('id', $id)->first();

        $lesson->delete();

        return response()->json([
            'error' => false,
            'message' => 'Xóa thành công danh mục'
        ]);
    }
}
