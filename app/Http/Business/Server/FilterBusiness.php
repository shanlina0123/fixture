<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/21
 * Time: 17:42
 */

namespace App\Http\Business\Server;
use App\Http\Business\Common\ServerBase;
use App\Http\Model\Store;
use DB;
class FilterBusiness extends ServerBase
{

    /**
     * @return mixed
     * 获取门店列表信息
     */
    public function getStoreList()
    {
      //查询所有门店信息
      $res = Store::paginate(3);
      //循环给省市赋值
      foreach ($res as $k => $v) {
          $ress = $v->cityid;
          $city = DB::table('data_city')->where('id',$ress)->get();
          if($city){
            $v->shi = $city;
          }
          foreach ($city as $kk => $vv) {
              $citys = $vv->provinceid;
              $sheng = DB::table('data_province')->where('id',$citys)->get();
                  if($sheng){
                    $vv->sheng = $sheng;
                  }
          }
          
      }

      
     /* dump($res);*/
      
    
    /* $res= DB::table('store')
            ->join('data_city', 'store.cityid', '=', 'data_city.id')
            ->join('data_province', 'data_city.provinceid', '=', 'data_province.id')
            ->select('store.*', 'data_city.*', 'data_province.*')
            ->get();
      dd($res);*/
       
      
       
      return $res;
    }

    /**
     * @return mixed
     * 获取角色列表信息
     */
    public function getRoleList()
    {
        return true;
    }


}