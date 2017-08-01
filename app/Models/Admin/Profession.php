<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profession extends Model
{
    use SoftDeletes;

    //注定表名
    protected $table = 'profession';

    //添加白名单
    protected $fillable = ['pro_name','protype_id','teachers_ids','cover_img','ppt_imgs','view_count','sort',
        'duration','pricr','description'];
}
