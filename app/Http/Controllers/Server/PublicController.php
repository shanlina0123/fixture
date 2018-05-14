<?php
namespace App\Http\Controllers\Server;
use App\Http\Business\Server\PublicBusiness;
use App\Http\Controllers\Common\ServerBaseController;
use App\Http\Model\User\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class PublicController extends ServerBaseController
{
    /**
     * The user repository instance.
     */
    protected $public_business;
    protected $request;
    public function __construct(Request $request)
    {
        $this->public_business =  new PublicBusiness($request);
        $this->request = $request;
    }

    /**
     * 上传图片到本地临时目录
     */
    public function uploadImgToTemp(Request $request)
    {
        $obj = new \stdClass();
        $src = new \stdClass();
        if( $request->file('file') == false ) return '';
        try {
            $res = $request->file('file')->store('temp', 'temp');
            $name = explode('/',$res)[1];
            $obj->code = 1;
            $obj->msg = '上传成功';
            $src->src = "http://".$_SERVER['HTTP_HOST'].'/temp/'.$name;
            $src->name = $name;
            $obj->data = $src;
            return response()->json($obj, 200);
        } catch (Exception $e)
        {
            $obj->code = 0;
            $obj->msg = '上传失败';
            $obj->data = '';
            return response()->json($obj, 200);
        }
    }

    /**
     *  获取腾讯地图搜索的地址
     */
    public function getMapAddress( Request $request )
    {
        $keyword = $request->input('keyword');
        if( $keyword )
        {
            $url = 'https://apis.map.qq.com/ws/place/v1/suggestion/?filter%3Dcategory%3D%E5%B0%8F%E5%8C%BA&keyword='.$keyword.'&key=N6LBZ-XRSWP-NM5DY-LW7S6-GCKO7-WBFF7';
            $data = file_get_contents($url);
            return $data;

        }else
        {
            return response()->json('', 200);
        }
    }


    /***
     * 获取菜单
     */
    public  function  getMenu()
    {
        //获取用户信息
        $admin_user=$this->request->get("admin_user");//对象

        //获取业务数据
        $list=$this->public_business->getMenu($admin_user->id,$admin_user->roleFunids);
        //接口返回结果
        responseData(\StatusCode::SUCCESS,"获取成功",$list);
    }

    /**
     * @param $phone
     * @param $type
     * 发送短息
     */
    public function sendSms()
    {
        $data = trimValue( $this->request->all() );
        $validator = Validator::make(
            $data,
            [
                'phone'=>'bail|regex:/^1[34578][0-9]{9}$/',
                'type'=>'bail|required|numeric',//类型
            ],[
                'phone.regex'=>'手机号码不正确',
                'type.numeric'=>'类型不正确',
            ]
        );
        if ($validator->fails())
        {
            $messages = $validator->errors()->first();
            responseData(\StatusCode::CHECK_FORM,'验证失败','',$messages);
        }
        switch ( (int)$data['type'] )
        {
            case 1: //注册
            case 2: //修改手机号码
                $validator = Validator::make(
                    $data,
                    [
                        'phone'=>'unique:user',
                    ],[
                        'phone.unique'=>'手机号码已存在',
                    ]
                );
                if ($validator->fails())
                {
                    $messages = $validator->errors()->first();
                    responseData(\StatusCode::CHECK_FORM,$messages);
                }
                \Sms::getCode($data['phone'],$data['type']);
                break;
            case 3: //修改密码
                $user = session('userInfo');
                if( $user->phone != $data['phone'] )
                {
                    responseData(\StatusCode::ERROR,'电话号码与实际注册的不符');
                }
                \Sms::getCode($data['phone'],$data['type']);
                break;
            case 4: //密码登陆 忘记密码
                $where['type'] = 0;
                $where['isinvitationed'] = 0;
                $where['isadminafter'] = 1;
                $where['phone'] = $data['phone'];
                $user = User::where($where)->first();
                if( !$user )
                {
                    responseData(\StatusCode::ERROR,'账号不存在');
                }
                if( $user->status != 1 )
                {
                    responseData(\StatusCode::ERROR,'账号已冻结');
                }
                \Sms::getCode($data['phone'],$data['type']);
                break;

        }
        responseData(\StatusCode::ERROR,'发送失败');
    }
}