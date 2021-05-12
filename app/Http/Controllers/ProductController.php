<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CategoryProduct;
use App\Models\CategoryPost;
use App\Models\Setting;

class ProductController extends Controller
{
    //

    private $product;
    private $header;
    private $unit = 'đ';
    private $categoryProduct;
    private $categoryPost;
    private $limitProduct = 9;
    private $limitProductRelate = 5;
    private $idCategoryProductRoot = 67;
    private $breadcrumbFirst = [
        // 'name'=>'Sản phẩm',
        //  'slug'=>'san-pham',
    ];
    public function __construct(Product $product, CategoryProduct $categoryProduct, CategoryPost $categoryPost, Setting $setting)
    {

        $this->product = $product;
        $this->categoryProduct = $categoryProduct;
        $this->categoryPost = $categoryPost;
        $this->setting = $setting;
    }
    // danh sách toàn bộ product
    public function index(Request $request)
    {
        $breadcrumbs = [];
        $data = [];
        // get category
        $category = $this->categoryProduct->where([
            ['id', $this->idCategoryProductRoot],
        ])->first();
        if ($category) {
            if ($category->count()) {
                $categoryId = $category->id;
                $listIdChildren = $this->categoryProduct->getALlCategoryChildrenAndSelf($categoryId);

                $data =  $this->product->whereIn('category_id', $listIdChildren)->paginate($this->limitProduct);
                $breadcrumbs[] = $this->categoryProduct->select('id', 'name', 'slug')->find($this->idCategoryProductRoot)->toArray();
            }
        }

      //  dd($category);
        return view('frontend.pages.product', [
            'data' => $data,
            'unit' => $this->unit,
            'breadcrumbs' => $breadcrumbs,
            'typeBreadcrumb' => 'product_all',

            'category'=>$category,
            'seo' => [
                'title' =>  $category->title_seo?? "",
                'keywords' =>  $category->keywords_seo ?? "",
                'description' =>  $category->description_seo ?? "",
                'image' => $category->avatar_path ?? "",
                'abstract' =>  $category->description_seo ?? "",
            ]
        ]);

    }
    public function detail($id, $slug)
    {
        //   $data= $this->categoryProduct->setAppends(['breadcrumb'])->where('parent_id',0)->orderBy("created_at", "desc")->paginate(15);

        $breadcrumbs = [];
        $data = [];
        $data = $this->product->where([
            ['id', $id],
            ["slug", $slug],
        ])->first();
        $categoryId = $data->category_id;
        $listIdChildren = $this->categoryProduct->getALlCategoryChildrenAndSelf($categoryId);

        $dataRelate =  $this->product->whereIn('category_id', $listIdChildren)->where([
            ["id", "<>", $data->id],
        ])->limit($this->limitProductRelate)->get();
        $listIdParent = $this->categoryProduct->getALlCategoryParentAndSelf($categoryId);

        foreach ($listIdParent as $parent ) {
            $breadcrumbs[] = $this->categoryProduct->select('id', 'name', 'slug')->find($parent)->toArray();
        }
        return view('frontend.pages.product-detail', [
            'data' => $data,
            'unit' => $this->unit,
            "dataRelate" => $dataRelate,
            'breadcrumbs' => $breadcrumbs,
            'typeBreadcrumb' => 'category_products',
            'title' => $data ? $data->name : "",
            'category'=>$data->category??null,
            'seo' => [
                'title' =>  $data->title_seo?? "",
                'keywords' =>  $data->keywords_seo ?? "",
                'description' =>  $data->description_seo ?? "",
                'image' => $data->avatar_path ?? "",
                'abstract' =>  $data->description_seo ?? "",
            ]
        ]);
    }

    // danh sách product theo category
    public function productByCategory($id, $slug)
    {
        // dd(route('product.index',['category'=>$request->category]));
        $breadcrumbs = [];
        // get category
        $category = $this->categoryProduct->where([
            ['id', $id],
        ])->first();
        if ($category) {
            if ($category->count()) {
                $categoryId = $category->id;
                $listIdChildren = $this->categoryProduct->getALlCategoryChildrenAndSelf($categoryId);

                $data =  $this->product->whereIn('category_id', $listIdChildren)->paginate($this->limitProduct);
                $listIdParent = $this->categoryProduct->getALlCategoryParentAndSelf($categoryId);
                foreach ($listIdParent as $parent ) {
                    $breadcrumbs[] = $this->categoryProduct->select('id', 'name', 'slug')->find($parent)->toArray();
                }
            }
        }

        //   if($this->breadcrumbFirst){
        //       array_unshift($breadcrumbs,$this->breadcrumbFirst);
        //   }

        return view('frontend.pages.product', [
            'data' => $data,
            'unit' => $this->unit,
            'breadcrumbs' => $breadcrumbs,
            'typeBreadcrumb' => 'category_products',
            'category'=>$category,
            'seo' => [
                'title' =>  $category->title_seo?? "",
                'keywords' =>  $category->keywords_seo ?? "",
                'description' =>  $category->description_seo ?? "",
                'image' => $category->avatar_path ?? "",
                'abstract' =>  $category->description_seo ?? "",
            ]
        ]);
    }
}
