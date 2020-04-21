<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;
use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Mail\Message;

class UserController extends BaseController
{

    /**
     * 用户列表展示：
     */
    public function index(){
        //分页查询所有用户数据：
        $users=Users::paginate(10);
        return view('admin.user.index',compact('users'));
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

    /**
     * 给当前用户分配角色页面：
     * 1.获取所有角色
     * 2.获取当前用户所属角色id
     */
    public function role(int $id){
        //获取所有角色：
        $roles=\App\Models\Role::all();
        //获取当前用户所属角色id:
        $role_id=Users::find($id)->role_id;
        return view('admin.user.show_role',compact('id','roles','role_id'));
    }

    /**
     * 给当前用户分配角色功能：
     */
    public function storeRole(Request $request,int $id){
       try{
           $role_id=$this->validate($request,[
               'role_id'=>'required'
           ]);
           Users::where('id',$id)->update($role_id);
           return redirect(route('admin.user.index'))->with('success','分配角色成功');
       }catch (\Exception $exception){
           return redirect(route('admin.user.index'))->withErrors(['分配角色失败']);
       }
    }
}
