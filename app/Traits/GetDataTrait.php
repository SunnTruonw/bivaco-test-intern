<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Setting;
use App\Models\CategoryPost;
use App\Models\CategoryProduct;
use App\Helper\CartHelper;

/**
 *
 */
trait GetDataTrait
{
    /*
     store image upload and return null || array
     @param
     $request type Request, data input
     $fieldName type string, name of field input file
     $folderName type string; name of folder store
     return array
     [
         "file_name","file_path"
     ]
    */
    public function getDataHeaderTrait($setting)
    {
        $cart = new CartHelper();
        $totalQuantity =  $cart->getTotalQuantity();


        $header['hotline'] = $setting->find(2);
        $header['email'] = $setting->find(3);
        $header['address'] = $setting->find(6);
        $header['logo'] = $setting->find(13);
        $header['socialParent'] = $setting->find(11);
        $header['totalQuantity'] = $totalQuantity;

        $categoryPost=new CategoryPost();
        $menu=[];
        $listCategoryPost=$categoryPost->whereIn(
            'parent_id',[21]
        )->pluck('id');


        foreach ($listCategoryPost as $id) {
            array_push($menu,menuRecusive($categoryPost,$id));
        }

        $categoryProduct=new CategoryProduct();

        $listCategoryProduct=$categoryProduct->whereIn(
            'id',[67]
        )->pluck('id');
        foreach ($listCategoryProduct as $id) {
            array_push($menu,menuRecusive($categoryProduct,$id));
        }



        $header['menu']=  [
            [
                'name'=>'Trang chủ',
                'slug_full'=>makeLink('home'),
                'childs'=>[
                ]
            ],
            [
                'name'=>'Giới thiệu',
                'slug_full'=>makeLink('about-us'),
                'childs'=>[
                ]
            ],
            ...$menu,
            [
                'name'=>'Liên hệ',
                'slug_full'=>makeLink('contact'),
            ],
        ];


        return  $header;
    }

    public function getDataFooterTrait($setting)
    {
        $footer = [];
        $footer['dataAddress'] = $setting->find(19);
        $footer['linkFooter'] = $setting->find([37, 41]);
        $footer['registerSale'] = $setting->find(45);
        $footer['logo'] = $setting->find(15);
        $footer['coppy_right'] = $setting->find(46);
        $footer['socialParent'] = $setting->find(47);
        $footer['pay'] = $setting->find(52);
        return  $footer;
    }
    public function getDataSidebarTrait($categoryPost, $categoryProduct)
    {
        $sidebar = [];

        $sidebar['categoryPost'] = $categoryPost->whereIn(
            'parent_id',
            [0]
        )->whereNotIn(
            'id',
            [14]
        )->get();

        $sidebar['categoryProduct']  = $categoryProduct->whereIn(
            'parent_id',
            [0]
        )->get();

        return  $sidebar;
    }
}
