<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/26
 * Time: 14:44
 */

namespace App\Http\Model\Activity;


use Illuminate\Database\Eloquent\Model;

class ActivityImages extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'activity_images';
    public $timestamps = false;
}