<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/23
 * Time: 16:28
 */


namespace App\Http\Model\Store;
use Illuminate\Database\Eloquent\Model;
class Store extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'store';
    public $timestamps = true;
    protected $hidden = [
        'created_at','updated_at'
    ];
}