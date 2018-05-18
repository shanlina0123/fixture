<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/14
 * Time: 15:43
 */

namespace App\Http\Model\Data;


use Illuminate\Database\Eloquent\Model;

class PrizeLevel extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $table = 'data_prize_level';
    public $timestamps = false;

}