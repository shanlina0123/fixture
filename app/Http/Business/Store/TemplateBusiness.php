<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/4
 * Time: 15:58
 */

namespace App\Http\Business\Store;
use App\Http\Business\Common\StoreBase;
use App\Http\Model\Company\CompanyStageTemplate;
use App\Http\Model\Company\CompanyStageTemplateTag;
use App\Http\Model\Data\StageTemplate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
class TemplateBusiness extends StoreBase
{
    /**
     * @param $data
     * @return mixed
     * 添加工地默认模板
     */
    public function getDefaultTemplate( $data )
    {
        //Cache::flush();
        $tag = 'defaultTemplateHome'.$data['companyid'];
        $value = Cache::tags($tag)->remember( $tag,config('configure.sCache'), function() use( $data ){
            return CompanyStageTemplate::where(['companyid'=>$data['companyid'],'isdefault'=>1])->with(['stageTemplateToTemplateTag'=>function($query){
                $query->orderBy('sort','asc')->select('id','name','stagetemplateid');
            }])->first();

        });
        return $value;
    }


    /**
     * @param $data
     * @return mixed
     * 模板列表
     */
    public function getTemplateList( $data )
    {
        //Cache::flush();
        $tag = 'templateListHome'.$data['companyid'];
        $value = Cache::tags($tag)->remember( $tag,config('configure.sCache'), function() use( $data ){
            return CompanyStageTemplate::where('companyid',$data['companyid'])->with('stageTemplateToTemplateTag')->orderBy('isdefault','desc')->orderBy('id','desc')->get();
        });
        return $value;
    }


    /**
     * @param $data
     * @return mixed
     * 设置默认模板
     */
    public function setTemplate( $data )
    {
        $res = CompanyStageTemplate::where(['companyid'=>$data['companyid'],'id'=>$data['id']])->first();
        if( $res )
        {
            CompanyStageTemplate::where(['companyid'=>$data['companyid']])->update(['isdefault'=>0]);
            $res->isdefault = 1;
            return $res->save();
        }else
        {
            responseData(\StatusCode::ERROR,'未检索到信息');
        }
    }


    /**
     * @param $data
     * 删除模板
     */
    public function destroyTemplate( $data )
    {
        $count = Site::where(['companyid'=>$data['companyid'],'stagetemplateid'=>$data['id']])->count();
        if( $count )
        {
            responseData(\StatusCode::ERROR,'模板已使用不能删除');
        }

        try{
            DB::beginTransaction();
            $res = CompanyStageTemplate::where(['companyid'=>$data['companyid'],'id'=>$data['id']])->first();
            if( !$res )
            {
                responseData(\StatusCode::ERROR,'模板不存在');
            }
            if( $res->issystem == 1 )
            {
                responseData(\StatusCode::ERROR,'系统模板不能删除');
            }
            $tem = $res->delete();
            CompanyStageTemplateTag::where(['companyid'=>$data['companyid'],'stagetemplateid'=>$data['id']])->delete();
            if( $tem )
            {
                //删除成功
                DB::commit();
                return true;
            }
            DB::rollBack();
            return false;
        }catch (\Exception $e )
        {
            DB::rollBack();
            return false;
        }

    }
}