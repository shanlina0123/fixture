<?php

namespace App\Http\Controllers\Server;
use App\Http\Business\Server\ClientBusiness;
use App\Http\Controllers\Common\ServerBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ClientController extends ServerBaseController
{

    protected $client;
    protected $userInfo;
    protected $request;
    public function __construct( ClientBusiness $client )
    {
        $this->middleware(function ($request, $next) {
            $userInfo = $request->session()->get('userInfo');
            $this->userInfo = $userInfo;
            $this->request = $request;
            return $next($request);
        });
        $this->client = $client;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $status = $this->client->getClientStatus();
        $data = $this->client->getClientList( $this->userInfo, $this->request );
        $where['k'] = $this->request->input('k');
        $where['status'] = $this->request->input('status');
        return view('server.client.index',compact('data','status','where'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->client->editClient( $this->userInfo, $id );
        if( $data )
        {
            responseData(\StatusCode::SUCCESS,'跟进记录',$data);
        }else
        {
            responseData(\StatusCode::ERROR,'跟进记录',[]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        //表单验证
        $this->request->validate([
            'followstatusid'=>'required|numeric',
            'followcontent'=>'required|max:255',
        ]);
        $data = trimValue($this->request->all());
        $res = $this->client->updateClient( $data, $this->userInfo, $id );
        if( $res == true )
        {
            Cache::tags(['client'.$this->userInfo->companyid])->flush();
            return redirect()->back()->with('msg','更近成功');
        }else
        {
            return redirect()->back()->with('msg','更近失败');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = $this->userInfo;
        $res = $this->client->destroyClient( $user, $id );
        if( $res == true )
        {
            Cache::tags(['client'.$user->companyid])->flush();
            return 'success';
        }else
        {
            return 'fail';
        }
    }
}
