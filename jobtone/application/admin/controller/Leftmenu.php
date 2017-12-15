<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Leftmenu as Lmenu;
class Leftmenu extends Base{
    public function index(){        
		return view();
    }
    
    public function add(){
        $id=input('id',0,'intval');
        if($id){
            $lmenu=new Lmenu();
            $this->assign(['menu'=>$lmenu->get($id)->toArray()]);
        }
        $this->assign(['page_title'=>'左侧菜单添加']);
        return view();
    }
    
    public function addDo(){
        $id=input('id',0,'intval');
        if($id){
            $data=input('post.');
            $category=new Lmenu();
            $res=$category->data($data)->isUpdate(true)->save();
        }else{
            $data=$this->request->instance()->except('id');
            $category=new Lmenu();
            $res=$category->data($data)->save();
        }
        if($res){
            return result(1,'保存成功');
        }else{
            return result(0,'保存失败');
        }
    }
    
    function del(){
        $id=input('id',0,'intval');
        if($_POST && $id){
            $menu=new Lmenu();
            $res=$menu::destroy($id);
            if($res){
                return result(1,'删除成功');
            }else{
                return result(0,'删除失败');
            }
        }else{
            return result(0,'非法操作');
        }
    }
}
