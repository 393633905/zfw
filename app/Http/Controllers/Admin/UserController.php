<?php

namespace App\Http\Controllers\Admin;

use http\Client\Curl\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Users;
use Illuminate\Mail\Message;

class UserController extends Controller
{
    protected $page_size=10;

    public function __construct()
    {
        $this->page_size=config('page.page_size');
    }

    /**
     * 用户列表展示：
     */
    public function index(){
        //分页查询所有用户数据：
        $user_model=Users::paginate($this->page_size);
        return view('admin.user.index',['users'=>$user_model]);
    }

    /**
     * 显示用户添加页面：
     */
    public function create(){
        return view('admin.user.create');
    }

    /**
     * 添加用户功能：
     */
    public function save(Request $request){
        $rule=[
            'username'=>'required|unique:users,username',
            'truename'=>'required',
            'password'=>'required|confirmed',
            'gender'=>'required',
            'mobile'=>'mobile',//自定义验证
            'email'=>'email'
        ];
        $param=$this->validate($request,$rule);
        //入库：
        $users_model=Users::create($param);
        //发送邮件：
        \Mail::send('admin.common.mail',['user'=>$users_model,'pwd'=>$param['password']],function(Message $message) use($users_model){
            $message->to($users_model->email);//发送给谁
            $message->subject('注册成功');
        });

        //跳转列表：
        return redirect(route('admin.user.index'))->with('success','注册成功');
    }

    /**
     * 删除指定用户：
     */
    public function delete($id){
        Users::destroy($id);
        $data=[
            'code'=>200,
            'msg'=>'删除成功',
            'data'=>[]
        ];
        return response()->json($data);
    }

    /**
     * 删除全部用户：
     */
    public function deleteAll(Request $request){
        $id=$request->get('id');
        Users::destroy($id);
        $data=[
            'code'=>200,
            'msg'=>'删除成功',
            'data'=>[]
        ];
        return response()->json($data);
    }

    /**
     * 用户回收站页面：
     */
    public function  restore(){
        $user_model = Users::onlyTrashed()->paginate(10);
        return view('admin.user.restore', ['users' => $user_model]);
    }

    /**
     * 还原指定用户
     * @param $id
     */
    public function rollback($id){
        Users::where('id',$id)->restore();
        $data=[
            'code'=>200,
            'msg'=>'还原成功',
            'data'=>[]
        ];
        return response()->json($data);
    }

    /**
     * 还原所有用户
     */
    public function rollbackAll(Request $request){
        $ids=$request->all('id');
        //批量删除
        foreach ($ids['id'] as $id){
            Users::where('id',$id)->restore();
        }
        $data=[
            'code'=>200,
            'msg'=>'还原成功',
            'data'=>[]
        ];
        return response()->json($data);
    }

    /**
     * 用户详情页面：
     */
    public function edit($id){
        $user_model=Users::find($id);
        return view('admin.user.edit',['user'=>$user_model]);
    }

    /**
     * 用户修改提交：
     */
    public function update(Request $request,$id){
        $rule=[
            'username'=>'required',
            'truename'=>'required',
            'gender'=>'required',
            'mobile'=>'mobile',//自定义验证
            'email'=>'email'
        ];
        $param=$this->validate($request,$rule);
        Users::where('id',$id)->update($param);
        return redirect(route('admin.user.index'))->with('success','修改成功');
    }

}
