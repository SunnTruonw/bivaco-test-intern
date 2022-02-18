<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductStar extends Model
{
    //
    protected $table="product_stars";
    protected $guarded = [];


    public function name_tat($string)
    {
        $ret = '';
        foreach (explode(' ', $string) as $word)
            $ret .= strtoupper($word[0]);
        return $ret;
        
    }
}


