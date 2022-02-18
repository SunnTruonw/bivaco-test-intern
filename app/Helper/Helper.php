<?php


namespace App\Helper;

class Helper
{

    public static function category($categories, $parent_id = 0, $char = '')
    {
        $html = '';
        foreach ($categories as $key => $category) {
            if ($category->parent_id == $parent_id) {
                $html .= '
                    <tr>
                        <td>' . $category->id . '</td>
                        <td>
                            <img style="width: 100px;"  src="/admin_asset/images/' . $category->image . '"/>
                        </td>
                        <td>' . $char . $category->name . '</td>
                        <td>' . $category->description . '</td>
                        <td>' . self::active($category->active) . '</td>
                        <td>' . date_format($category->updated_at, "Y/m/d") . '</td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="/admin/lesson/edit/' . $category->id . '">
                            <i class="fas fa-edit"></i>

                            </a>
                            <a href="#" class="btn btn-danger btn-sm"
                                onclick="removeRow(' . $category->id . ', \'/admin/lesson/destroy\')">
                                <i class="far fa-trash-alt"></i>

                            </a>
                        </td>
                        
                    </tr>
                ';

                unset($categories[$key]);

                $html .= self::category($categories, $category->id, $char . '|--');
            }
        }
        return $html;
    }

    public static function menu($menus, $parent_id = 0, $char = '')
    {
        $html = '';
        foreach ($menus as $key => $menu) {
            if ($menu->parent_id == $parent_id) {
                $html .= '
                    <tr>
                        <td>' . $menu->id . '</td>
                        <td>' . $char . $menu->name . '</td>
                        <td>' . $menu->slug . '</td>
                        <td>' . self::active($menu->active) . '</td>
                        <td>' . date_format($menu->updated_at, "Y/m/d") . '</td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="/admin/category/edit/' . $menu->id . '">
                                <i class="fas fa-edit"></i>

                            </a>
                            
                            <a href="#" class="btn btn-danger btn-sm"
                                onclick="removeRow(' . $menu->id . ', \'/admin/category/destroy\')">
                                <i class="far fa-trash-alt"></i>

                            </a>
                        </td>
                        
                    </tr>
                ';

                unset($menus[$key]);

                $html .= self::menu($menus, $menu->id, $char . '|--');
            }
        }
        return $html;
    }

    public static function active($active = 0): string
    {
        return $active == 0 ? '<i class="fas fa-check-circle" style="color:red"></i>'
            : '<i class="fas fa-check-circle"></i>';
    }
}
