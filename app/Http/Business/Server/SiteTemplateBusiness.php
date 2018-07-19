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
            $data = new \stdClass();
            $data->default = StageTemplate::where('status',1)->with('stageTemplateToTemplateTag')->with(['stageTemplateToCompanyTemplate'=>function( $query ) use( $user ){
                $query->where('companyid',$user->companyid);
            }])->get();
            $data->definition = CompanyStageTemplate::where('companyid',$user->companyid)->with('stageTemplateToTemplateTag')->orderBy('issystem','desc')->orderBy('id','desc')->paginate(config('configure.sPage'));
            return $data;
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
        });
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
    public function editTemplate( $companyId, $id )
    {
        return CompanyStageTemplate::where(['companyid'=>$companyId,'uuid'=>$id])->with('stageTemplateToTemplateTag')->first();
    }


    /**
     * @param $data
     * @param $id
     * @return bool
     * 修改模板
     */
    public function updateTemplate( $data, $id )
    {
        $obj = new \stdClass();
        try{
            DB::beginTransaction();
            $res = CompanyStageTemplate::where(['companyid' => $data['companyid'], 'uuid' => $id])->with('stageTemplateToTemplateTag')->first();
            if ( $res->stageTemplateToSite()->count() )
            {
                $obj->ststus = 0;
                $obj->msg = '模板已被使用不能修改';
                return $obj;
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
                $obj->ststus = 1;
                $obj->msg = '模板修改成功';
                return $obj;
            }
        }catch( Exception $e )
        {
            DB::rollBack();
            $obj->ststus = 0;
            $obj->msg = '模板修改失败';
            return $obj;
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
                if( $res->issystem == 1 )
                {
                    $obj->status = 0;
                    $obj->msg = '系统模板不能删除';
                    return $obj;
                }
                if( $res->stageTemplateToSite()->count() )
                {
                    $obj->status = 0;
                    $obj->msg = '模板已被使用不可删除';
                    return $obj;
                }else
                {
                    $res->stageTemplateToTemplateTag()->delete();
                    if( $res->delete() )
                    {
                        DB::commit();
                        $obj->status = 1;
                        $obj->msg = '删除成功';
                    }else
                    {
                        $obj->status = 0;
                        $obj->msg = '删除失败';
                    }
                    return $obj;
                }
            }else
            {
                $obj->status = 0;
                $obj->msg = '模板不存在';
                return $obj;
            }

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
        CompanyStageTemplate::where(['companyid'=>$companyId])->update(['isdefault'=>0]);
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

    /**
     * @param $companyId
     * @param $id
     * 给公司模板表添加模板
     */
    public function addDefaultTemplate(  $companyId, $id  )
    {
        $obj = new \stdClass();
        try{
            DB::beginTransaction();
            //查看是否使用
            $isDefault = CompanyStageTemplate::where(['companyid'=>$companyId,'defaulttemplateid'=>$id])->count();
            if( $isDefault )
            {
                $obj->status = 0;
                $obj->msg = '模板已被使用';
                return $obj;
            }
            //模板信息
            $res = StageTemplate::where(['id'=>$id,'status'=>1])->with('stageTemplateToTemplateTag')->first();
            if( $res )
            {
                $template = new CompanyStageTemplate;
                $template->uuid = create_uuid();
                $template->companyid = $companyId;
                $template->name = $res->name;
                $template->defaulttemplateid = $res->id;
                $template->issystem = 1;
                $template->isdefault = 0;
                $template->created_at = date("Y-m-d H:i:s");
                $template->save();
                $tag = array();
                foreach ( $res->stageTemplateToTemplateTag as $k =>$row ) {
                    $tag[$k]['uuid'] = create_uuid();
                    $tag[$k]['companyid'] = $companyId;
                    $tag[$k]['stagetemplateid'] = $template->id;
                    $tag[$k]['name'] = $row->name;
                    $tag[$k]['sort'] = $k;
                    $tag[$k]['created_at'] = date("Y-m-d H:i:s");
                }
                CompanyStageTemplateTag::insert($tag);
                $obj->status = 1;
                $obj->msg = '使用成功';
                DB::commit();
                return $obj;
            }else
            {
                $obj->status = 0;
                $obj->msg = '未查询到信息';
                return $obj;
            }
        }catch ( Exception $e )
        {
            $obj->status = 0;
            $obj->msg = '使用失败';
            DB::rollBack();
            return $obj;
        }
    }
}