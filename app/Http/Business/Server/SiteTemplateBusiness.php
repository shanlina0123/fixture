<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/21
 * Time: 17:42
 */

namespace App\Http\Business\Server;
use App\Http\Business\Common\ServerBase;
use App\Http\Model\Company\CompanyStageTemplate;
use App\Http\Model\Company\CompanyStageTemplateTag;
use App\Http\Model\Data\StageTemplate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SiteTemplateBusiness extends ServerBase
{


    /**
     * @param $user
     * @param $request
     * @return mixed
     * 模板列表
     */
    public function getTemplateList( $user,$request )
    {
        $tag = 'siteTemplate'.$user->companyid;
        $where = $tag.$request->input('page');
        $value = Cache::tags($tag)->remember( $tag.$where,config('configure.sCache'), function() use( $user, $request ){
            $data = CompanyStageTemplate::where('companyid',$user->companyid)->with('stageTemplateToTemplateTag')->paginate(config('configure.sPage'));
            if( count($data) )
            {
                $data->default = 0;
                return $data;

            }else
            {
                $data = StageTemplate::where('status',1)->with('stageTemplateToTemplateTag')->paginate(config('configure.sPage'));
                $data->default = 1;
                return $data;
            }
        });
        return $value;
    }

    /**
     * @param $data
     * @return bool
     * 添加模板
     */
    public function templateSave( $data )
    {
        $res = DB::transaction(function () use( $data ){
           $template = new CompanyStageTemplate;
           $template->uuid = create_uuid();
           $template->companyid = $data['companyid'];
           $template->name = $data['name'];
           $template->isdefault = 0;
           $template->created_at = date("Y-m-d H:i:s");
           $template->save();

           $arr = array();
           foreach ( $data['tag'] as $k=>$row )
           {
               $tag = array();
               $tag['uuid'] = create_uuid();
               $tag['companyid'] = $data['companyid'];
               $tag['stagetemplateid'] = $template->id;
               $tag['name'] = $row;
               $tag['sort'] = $k;
               $tag['created_at'] = date("Y-m-d H:i:s");
               $arr[] = $tag;
           }
           CompanyStageTemplateTag::insert($arr);
        }, 2);
        if( is_null($res) )
        {
            return true;
        }else
        {
            return false;
        }
    }


    /**
     * @param $type
     * @param $id
     * @return mixed
     * 修改数据
     */
    public function editTemplate( $type, $companyId, $id )
    {
        if(  $type == 1 )
        {
            $data = StageTemplate::where('uuid',$id)->with('stageTemplateToTemplateTag')->first();
        }else
        {
            $data = CompanyStageTemplate::where(['companyid'=>$companyId,'uuid'=>$id])->with('stageTemplateToTemplateTag')->first();
        }
        return $data;
    }


    /**
     * @param $data
     * @param $id
     * @return bool
     * 修改模板
     */
    public function updateTemplate( $data, $id )
    {
        try{
            DB::beginTransaction();
            $type = (int)$data['type'];
            switch ( $type )
            {
                //系统模板
                case 1:
                    $template = new CompanyStageTemplate;
                    $template->uuid = create_uuid();
                    $template->companyid = $data['companyid'];
                    $template->name = $data['name'];
                    $template->isdefault = 0;
                    $template->created_at = date("Y-m-d H:i:s");
                    $template->save();
                    $arr = array();
                    foreach ($data['tag'] as $k => $row) {
                        $tag = array();
                        $tag['uuid'] = create_uuid();
                        $tag['companyid'] = $data['companyid'];
                        $tag['stagetemplateid'] = $template->id;
                        $tag['name'] = $row;
                        $tag['sort'] = $k;
                        $tag['created_at'] = date("Y-m-d H:i:s");
                        $arr[] = $tag;
                    }
                    CompanyStageTemplateTag::insert($arr);
                    DB::commit();
                    return true;
                    break;
                case 0:
                    $res = CompanyStageTemplate::where(['companyid' => $data['companyid'], 'uuid' => $id])->with('stageTemplateToTemplateTag')->first();
                    if ($res->stageTemplateToSite()->count())
                    {
                        DB::commit();
                        return false;
                    }else
                    {
                        $res->name = $data['name'];
                        //删除原来的模板
                        $res->stageTemplateToTemplateTag()->delete();
                        //添加新模板
                        $arr = array();
                        foreach ($data['tag'] as $k => $row) {
                            $tag = array();
                            $tag['uuid'] = create_uuid();
                            $tag['companyid'] = $data['companyid'];
                            $tag['stagetemplateid'] = $res->id;
                            $tag['name'] = $row;
                            $tag['sort'] = $k;
                            $tag['created_at'] = date("Y-m-d H:i:s");
                            $tag['updated_at'] = date("Y-m-d H:i:s");
                            $arr[] = $tag;
                        }
                        CompanyStageTemplateTag::insert($arr);
                        DB::commit();
                        return true;
                    }
                    break;
            }
        }catch( Exception $e )
        {
            DB::rollBack();
            return false;
        }
    }
    /**
     * @param $companyId
     * @param $id
     * @return bool
     * 删除模板
     */
    public function templateDel( $companyId, $id  )
    {
        $obj = new \stdClass();
        try{
            DB::beginTransaction();
            $res = CompanyStageTemplate::where(['companyid'=>$companyId,'uuid'=>$id])->first();
            if( $res )
            {
                if( $res->stageTemplateToSite()->count() )
                {
                    $obj->status = 0;
                    $obj->msg = '模板已被使用不可删除';
                }else
                {
                    $res->delete();
                    $res->stageTemplateToTemplateTag()->delete();
                    $obj->status = 1;
                    $obj->msg = '删除成功';
                }
            }else
            {
                $obj->status = 0;
                $obj->msg = '模板不存在';
            }
            DB::commit();
            return $obj;
        }catch ( Exception $e )
        {
            $obj->status = 0;
            $obj->msg = '删除失败';
            DB::rollBack();
            return $obj;
        }
    }

    /**
     * @param $companyId
     * @param $id
     * @return \stdClass
     * 设置默认模板
     */
    public function templateDefault( $companyId, $id )
    {
        $obj = new \stdClass();
        CompanyStageTemplate::whereNotIn('uuid',[$id])->where(['companyid'=>$companyId])->update(['isdefault'=>0]);
        $res = CompanyStageTemplate::where(['companyid'=>$companyId,'uuid'=>$id])->first();
        $res->isdefault = 1;
        if( $res->save() )
        {
            $obj->status = 1;
            $obj->msg = '设置成功';

        }else
        {
            $obj->status = 0;
            $obj->msg = '设置失败';
        }
        return $obj;
    }
}