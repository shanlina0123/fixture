<?php

namespace App\Http\Controllers\Server;
use App\Http\Business\Server\FilterBusiness;
use App\Http\Controllers\Common\ServerBaseController;
use Illuminate\Http\Request;
use App\Http\Model\Store;
use DB;
class FilterController extends ServerBaseController
{
    /**
     * The user repository instance.
     */
    protected $filter;

    /**
     * 创建新的控制器实例
     *
     * @param UserRepository $users
     * @return void
     */
    public function __construct(FilterBusiness $filter)
    {
        $this->filter = $filter;
    }

    /***
     * 获取门店列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function storeIndex(Request $request)
    {

        if( $request->method() === 'POST' )
        {

        }else
        {
            
            $datas = $this->filter->getStoreList();
            //查询省市的信息
            $city = DB::table('data_city')->get();
            $sheng = DB::table('data_province')->get();

            return view('server.filter.store-index',compact('datas','city','sheng'));
        }
       
    }

    /*
        删除门店列表
    */
        public function storeDel(Request $request)
        {
            
            $id = $request['nameid'];
            $where['id'] = $id;
            $res = Store::where($where)->delete();
            if($res){
                echo json_encode(1);
            }else{
                echo json_encode(2);
            }
            
        }

    /*
        添加门店列表
    */
        public function storeAdd(Request $request)
        {
           
            
            /*echo json_encode($city->id);*/
            if($request['uname']){
                $shi = $request['shi'];
                $city = DB::table('data_city')->where(array('name'=>$shi))->first();

                $data = array( 
                'name'=>$request['uname'],
                'addr'=>$request['address'],
                'fulladdr'=>$request['sheng'].$request['shi'].$request['address'],
                'created_at'=>date('Y-m-d H:i:s'),
                'uuid'=>create_uuid(),
                'cityid'=>$city->id
                ); 
                $res = Store::insert($data);
                if($res){
                     echo json_encode(1);
                }
            }

        }

    /*
        编辑门店列表
    */    
        public function storeEdit(Request $request)
        {
           $id = $request['nameid'];
           if($id){
                $arr = Store::where(array('id'=>$id))->first();

                $shis = DB::table('data_city')->where(array('id'=>$arr->cityid))->first();
                $shengs = DB::table('data_province')->where(array('id'=>$shis->provinceid))->first();
                $zhi = array(
                'id'=>$arr->id,    
                'name'=>$arr->name,
                'addr'=>$arr->addr,
                'sheng'=>$shengs->name,
                'shi'=>$shis->name,
                ); 

                echo json_encode($zhi); 
                
              
           }
           
        }

        public function storeEdits(Request $request)
        {
           
            if($request['uname']){
                $shi = $request['shi'];
                $city = DB::table('data_city')->where(array('name'=>$shi))->first();

                $data = array( 
                'name'=>$request['uname'],
                'addr'=>$request['address'],
                'fulladdr'=>$request['sheng'].$request['shi'].$request['address'],
                'created_at'=>date('Y-m-d H:i:s'),
                'cityid'=>$city->id
                ); 
                $res = Store::where(array('id'=>$request['bid']))->update($data);
                if($res){
                     echo json_encode(1);
                }
            }
        }





    /***
     * 获取角色列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function roleIndex(Request $request)
    {
            $data = $this->filter->getRoleList();
            return view('server.filter.role-index',compact('data'));
    }
}
