<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\CategoryPost;
use App\Models\Tag;
use App\Models\PostTag;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Traits\StorageImageTrait;
use App\Traits\DeleteRecordTrait;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\ValidateAddPost;
use App\Http\Requests\Admin\ValidateEditPost;

use App\Exports\ExcelExportsDatabase;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ExcelImportsDatabase;


class AdminPostController extends Controller
{
    use StorageImageTrait, DeleteRecordTrait;
    private $post;
    private $categoryPost;
    private $htmlselect;
    private $tag;
    private $postTag;
    private $langConfig;
    private $langDefault;
    public function __construct(Post $post, CategoryPost $categoryPost,  Tag $tag, PostTag $postTag)
    {
        $this->post = $post;
        $this->categoryPost = $categoryPost;
        $this->tag = $tag;
        $this->postTag = $postTag;
        $this->langConfig = config('languages.supported');
        $this->langDefault = config('languages.default');
    }
    //
    public function index(Request $request)
    {
        $data = $this->post;
        if ($request->input('category')) {
            $categoryPostId = $request->input('category');
            $idCategorySearch = $this->categoryPost->getALlCategoryChildren($categoryPostId);
            $idCategorySearch[] = (int)($categoryPostId);
            $data = $data->whereIn('category_id', $idCategorySearch);
            $htmlselect = $this->categoryPost->getHtmlOption($categoryPostId);
        } else {
            $htmlselect = $this->categoryPost->getHtmlOption();
        }
        $where = [];
        if ($request->input('keyword')) {
           // $where[] = ['name', 'like', '%' . $request->input('keyword') . '%'];
            $data=$data->where(function($query){
                $idPostTran = $this->postTranslation->where([
                    ['name', 'like', '%' . request()->input('keyword') . '%']
                ])->pluck('product_id');
                // dd($idProTran);
                $query->whereIn('id',$idPostTran);
            });
        }
        if ($request->has('fill_action') && $request->input('fill_action')) {
            $key = $request->input('fill_action');
            switch ($key) {
                case 'hot':
                    $where[] = ['hot', '=', 1];
                    break;
                default:
                    break;
            }
        }
        if ($where) {
            $data = $data->where($where);
        }
        if ($request->input('order_with')) {
            $key = $request->input('order_with');
            switch ($key) {
                case 'dateASC':
                    $orderby = ['created_at'];
                    break;
                case 'dateDESC':
                    $orderby = [
                        'created_at',
                        'DESC'
                    ];
                    break;
                case 'viewASC':
                    $orderby = [
                        'view',
                        'ASC'
                    ];
                    break;
                case 'viewDESC':
                    $orderby = [
                        'view',
                        'DESC'
                    ];
                    break;
                default:
                    $orderby =  $orderby = [
                        'created_at',
                        'DESC'
                    ];
                    break;
            }
            $data = $data->orderBy(...$orderby);
        } else {
            $data = $data->orderBy("created_at", "DESC");
        }
        $data = $data->paginate(15);

        return view(
            "admin.pages.post.list",
            [
                'data' => $data,
                'option' => $htmlselect,
                'keyword' => $request->input('keyword') ? $request->input('keyword') : "",
                'order_with' => $request->input('order_with') ? $request->input('order_with') : "",
                'fill_action' => $request->input('fill_action') ? $request->input('fill_action') : "",
            ]
        );
    }


    public function create(Request $request = null)
    {
        $htmlselect = $this->categoryPost->getHtmlOption();
        return view("admin.pages.post.add",
            [
                'option' => $htmlselect,
                'request' => $request
            ]
        );
    }
    public function store(ValidateAddPost $request)
    {
       // dd($request->all());
        try {
            DB::beginTransaction();
            $dataPostCreate = [
              //  "name" => $request->input('name'),
              //  "slug" => $request->input('slug'),
                "hot" => $request->input('hot') ?? 0,
                "view" => $request->input('view') ?? 0,
              //  "description" => $request->input('description'),
              //  "description_seo" => $request->input('description_seo'),
              //  "title_seo" => $request->input('title_seo'),
             //   "content" => $request->input('content'),
                 "order" => $request->input('order') ?? null,
                "active" => $request->input('active'),
                "category_id" => $request->input('category_id'),
                "admin_id" => auth()->guard('admin')->id()
            ];
            $dataUploadAvatar = $this->storageTraitUpload($request, "avatar_path", "post");
            if (!empty($dataUploadAvatar)) {
                $dataPostCreate["avatar_path"] = $dataUploadAvatar["file_path"];
            }

            // insert database in posts table
            $post = $this->post->create($dataPostCreate);
            // dd($post);
              // insert data product lang
              $dataPostTranslation = [];
            //  dd($this->langConfig);
              foreach ($this->langConfig as $key => $value) {
                  $itemPostTranslation = [];
                  $itemPostTranslation['name'] = $request->input('name_' . $key);
                  $itemPostTranslation['slug'] = $request->input('slug_' . $key);
                  $itemPostTranslation['description'] = $request->input('description_' . $key);
                  $itemPostTranslation['description_seo'] = $request->input('description_seo_' . $key);
                  $itemPostTranslation['title_seo'] = $request->input('title_seo_' . $key);
                  $itemPostTranslation['keyword_seo'] = $request->input('keyword_seo_' . $key);
                  $itemPostTranslation['content'] = $request->input('content_' . $key);
                  $itemPostTranslation['language'] = $key;
                //  dd($itemPostTranslation);
                  $dataPostTranslation[] = $itemPostTranslation;
              }
             // dd($dataPostTranslation);
            // dd($post->translations());
              $postTranslation =   $post->translations()->createMany($dataPostTranslation);
             // dd($postTranslation);
            // insert database to post_tags table

            foreach ($this->langConfig as $key => $value) {
                if ($request->has("tags_" . $key)) {
                    $tag_ids = [];
                    foreach ($request->input('tags_' . $key) as $tagItem) {
                        $tagInstance = $this->tag->firstOrCreate(["name" => $tagItem]);
                        $tag_ids[] = $tagInstance->id;
                    }
                    $post->tags()->attach($tag_ids, ['language' => $key]);
                }
            }

            // dd($post->tags);
            DB::commit();
            return redirect()->route('admin.post.index')->with("alert", "Th??m b??i vi???t th??nh c??ng");
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.post.index')->with("error", "Th??m b??i vi???t kh??ng th??nh c??ng");
        }
    }
    public function edit($id)
    {
        $data = $this->post->find($id);
        $category_id = $data->category_id;
        $htmlselect = $this->categoryPost->getHtmlOption($category_id);
        return view("admin.pages.post.edit", [
            'option' => $htmlselect,
            'data' => $data
        ]);
    }
    public function update(ValidateEditPost $request, $id)
    {
        try {
            DB::beginTransaction();
            $dataPostUpdate = [
              //  "name" => $request->input('name'),
             //   "slug" => $request->input('slug'),
                "hot" => $request->input('hot') ?? 0,
                // "view" => $request->input('view'),
               // "description" => $request->input('description'),
              //  "description_seo" => $request->input('description_seo'),
              //  "title_seo" => $request->input('title_seo'),
               // "content" => $request->input('content'),
                "active" => $request->input('active'),
                "category_id" => $request->input('category_id'),
                "admin_id" => auth()->guard('admin')->id(),
            ];
            $dataUploadAvatar = $this->storageTraitUpload($request, "avatar_path", "post");
            if (!empty($dataUploadAvatar)) {
                $path=$this->post->find($id)->avatar_path;
                if($path){
                    Storage::delete($this->makePathDelete($path));
                }
                $dataPostUpdate["avatar_path"] = $dataUploadAvatar["file_path"];
            }
            // insert database in post table
            $this->post->find($id)->update($dataPostUpdate);
            $post = $this->post->find($id);

            // insert data product lang
            $dataPostTranslationUpdate = [];
            foreach ($this->langConfig as $key => $value) {
                $itemPostTranslationUpdate = [];
                $itemPostTranslationUpdate['name'] = $request->input('name_' . $key);
                $itemPostTranslationUpdate['slug'] = $request->input('slug_' . $key);
                $itemPostTranslationUpdate['description'] = $request->input('description_' . $key);
                $itemPostTranslationUpdate['description_seo'] = $request->input('description_seo_' . $key);
                $itemPostTranslationUpdate['title_seo'] = $request->input('title_seo_' . $key);
                $itemPostTranslationUpdate['keyword_seo'] = $request->input('keyword_seo_' . $key);
                $itemPostTranslationUpdate['content'] = $request->input('content_' . $key);
                $itemPostTranslationUpdate['language'] = $key;

                if($post->translationsLanguage($key)->first()){
                    $post->translationsLanguage($key)->first()->update($itemPostTranslationUpdate);
                }else{
                    $post->translationsLanguage($key)->create($itemPostTranslationUpdate);
                }

            }

            // insert database to post_tags table

            $tag_ids = [];
            foreach ($this->langConfig as $key => $value) {

                if ($request->has("tags_" . $key)) {
                    foreach ($request->input('tags_' . $key) as $tagItem) {
                        $tagInstance = $this->tag->firstOrCreate(["name" => $tagItem]);
                        $tag_ids[$tagInstance->id] = ['language' => $key];
                    }
                    //   $product->tags()->attach($tag_ids, ['language' => $key]);
                    // C??c syncph????ng ph??p ch???p nh???n m???t lo???t c??c ID ????? ra tr??n b???ng trung gian. B???t k??? ID n??o kh??ng n???m trong m???ng ???? cho s??? b??? x??a kh???i b???ng trung gian.
                }
            }
            // dd($tag_ids);
            $post->tags()->sync($tag_ids);

            DB::commit();
            return redirect()->route('admin.post.index')->with("alert", "s???a b??i vi???t th??nh c??ng");
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.post.index')->with("error", "S???a b??i vi???t kh??ng th??nh c??ng");
        }
    }
    public function destroy($id)
    {
        return $this->deleteTrait($this->post, $id);
    }

    public function loadActive($id)
    {
        $post   =  $this->post->find($id);
        $active =$post->active;
        if($active){
            $activeUpdate=0;
        }else{
            $activeUpdate=1;
        }
        $updateResult =  $post->update([
            'active'=>$activeUpdate,
        ]);
        $post   =  $this->post->find($id);
        if( $updateResult){
            return response()->json([
                "code" => 200,
                "html"=>view('admin.components.load-change-active',['data'=>$post,'type'=>'b??i vi???t'])->render(),
                "message" => "success"
            ], 200);
        }else{
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);
        }

    }
    public function loadHot($id)
    {
        $post   =  $this->post->find($id);
        $hot =$post->hot;

        if($hot){
            $hotUpdate=0;
        }else{
            $hotUpdate=1;
        }
        $updateResult =  $post->update([
            'hot'=>$hotUpdate,
        ]);

        $post   =  $this->post->find($id);
        if( $updateResult){
            return response()->json([
                "code" => 200,
                "html"=>view('admin.components.load-change-hot',['data'=>$post,'type'=>'b??i vi???t'])->render(),
                "message" => "success"
            ], 200);
        }else{
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);
        }

    }

    public function excelExportDatabase()
    {
        return Excel::download(new ExcelExportsDatabase(config('excel_database.post')), config('excel_database.post.excelfile'));
    }
    public function excelImportDatabase()
    {
        $path =request()->file('fileExcel')->getRealPath();
        Excel::import(new ExcelImportsDatabase(config('excel_database.post')), $path);
    }
}
