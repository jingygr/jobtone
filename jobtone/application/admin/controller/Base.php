<?php
namespace app\admin\controller;
use think\Request;
use think\Controller;
use app\admin\model\Leftmenu;
class Base extends Controller{
	public function _initialize(){
	   // cookie('userinfo',null);die;
		$this->request=Request::instance();
		$menuinfo=array(
				'controller'=>$this->request->controller(),
				'action'=>$this->request->action()
		);
		
		$this->assign('menuinfo',$menuinfo);
		$this->userinfo=cookie('userinfo');
		
		if(empty($this->userinfo)){
			$this->redirect('passport/index');
		}else{
		    if($this->userinfo['rule']==1){
		        $leftMenu=db('leftmenu')->where(['delete_time'=>NULL,'fid'=>0])->select();
		        for($i=0;$i<count($leftMenu);$i++){
		            $leftMenu[$i]['son']=db('leftmenu')->where(['delete_time'=>NULL,'fid'=>$leftMenu[$i]['id']])->select();
		        }
		        
		        $this->assign(['userinfo'=>$this->userinfo,'leftMenu'=>$leftMenu]);
		    }else{
		        echo '非法访问哦，小坏蛋~';
		    }
		}
	}
}