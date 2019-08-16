<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    public function login()
    {
        return view('user.profile');
    }
    public function test(Request $request){ 
        $name= $request->session()->get('name');

        return view('user.show',['name'=>$name]);
    }
    public function show(Request $request){
        $users = DB::select('select * from hello');
        $data=['code'=>'0','status'=>'ok','data'=>$users];
        echo $json=json_encode($data);
        die;
    }
    public function add_login(Request $request){
        // $data=Request::all();
        // $name=$data['name'];
        // $password=$data['password'];
        $name=$request->input('name');
        $password=$request->input('password');
        $arr = DB::select("select * from user where name='$name' and password='$password'");
        if (empty($arr)) {
           
            $res=['code'=>'1','status'=>'error','data'=>'用户名或者密码错误'];
            echo $json=json_encode($res);
        }else{
            //$nem= $request->session()->put('name', $name);
            
            $add= $request->session()->put('name', $name);
            
            // // echo $name = $request->session()->get('name', $name);
            $res=['code'=>'0','status'=>'ok','data'=>'登录成功'];
            echo $json=json_encode($res);
            
        }
       
    }
    public function delete(Request $request){
        $id=$request->input('id');
        $arr = DB::delete("delete from hello where id='$id'");
        $res=['code'=>'0','status'=>'ok','data'=>'删除成功'];
            echo $json=json_encode($res);
    }
    public function addaction(Request $request){
        $name=$request->input('name');
        $age=$request->input('age');
        $arr = DB::select("select * from hello where name='$name' and age='$age'");
        if (empty($arr)) {
            DB::table('hello')->insert(['name'=>$name,'age'=>$age]);
            $res=['code'=>'0','status'=>'ok','data'=>'添加成功'];
            echo $json=json_encode($res);
        }else{
            $res=['code'=>'1','status'=>'error','data'=>'有重复'];
            echo $json=json_encode($res);
        }
       

    }
    public function action_login(Request $request){
        $request->session()->forget('name');
        return redirect()->action('UserController@login');

    }
    public function update(Request $request){
        $id=$request->input('id');
        $name=$request->input('name');
        $age=$request->input('age');
        $arr=array('name'=>$name,'age'=>$age);
        DB::table('hello')->where('id','=',$id)->update($arr);
    }
}