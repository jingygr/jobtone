<?php
namespace app\admin\controller;
use app\admin\model\Industry;
use think\Model;
use app\admin\model\JobCategory;
use app\admin\model\Configs;
use think\Controller;
use Phinx\Config;
class System extends Base{
    public function index(){
        $assign=array(
            'page_title'=>'系统配置'
        );
        $this->assign($assign);
		return view();
    }
    
    public function industry(){
        $id=input('id',0,'intval');
        $industry=new Industry();
        if($_POST){
            if($id){
                $data=input('post.');
                $res=$industry->data($data)->isUpdate(true)->save();
            }else{
                $data=$this->request->instance()->except('id');
                $res=$industry->data($data)->save();
            }
            if($res){
                return result(1,'保存成功');
            }else{
                return result(0,'保存失败');
            }
        }else{
            $list=$industry->all(['fid'=>0]);
            if($list){
                for($i=0;$i<count($list);$i++){
                    $list[$i]['son']=$industry->all(['fid'=>$list[$i]['id']]);
                }
            }
            $assign=array(
                'industry'=>$list,
                'page_title'=>'行业配置'
            );
            if($id){
                $assign['info']=$industry->get($id)->toArray();
            }
            $this->assign($assign);
            return view();
        }        
    }
    
    public function industryDel(){
        $id=input('id',0,'intval');
        if($_POST && $id){
            $model=new Industry();
            $res=$model->destroy($id);
            if($res){
                return result(1,'删除成功');
            }else{
                return result(0,'删除失败');
            }
        }else{
            return result(0,'非法操作');
        }
    }
    
    public function category(){
        $id=input('id',0,'intval');
        $model=model('JobCategory');
        if($_POST){
            if($id){
                $data=input('post.');                
                $res=$model->data($data)->isUpdate(true)->save();
            }else{
                $data=$this->request->instance()->except('id');
                $res=$model->data($data)->save();
            }
            if($res){
                return result(1,'保存成功');
            }else{
                return result(0,'保存失败');
            }
        }else{
            $fid=input('fid',0,'intval');
            $list=$model->all(['fid'=>$fid]);
            for($i=0;$i<count($list);$i++){
                $list[$i]['son']=$model->all(['fid'=>$list[$i]['id']]);
                
            }
            $assign=array(
                'category'=>$list,
                'page_title'=>'岗位分类中心'
            );
            if($id){
                $assign['info']=$model->get($id)->toArray();
            }
            $this->assign($assign);
            return view();
        }        
    }
    
    public function categoryDel(){
        $id=input('id',0,'intval');
        if($_POST && $id){
            $model=new JobCategory();
            $res=$model->destroy($id);
            if($res){
                return result(1,'删除成功');
            }else{
                return result(0,'删除失败');
            }
        }else{
            return result(0,'非法操作');
        }
    }
    
    public function config(){
        $id=input('id',0,'intval');
        $model=new Configs();
        if($_POST){
            if($id){
                $data=input('post.');
                $res=$model->data($data)->isUpdate(true)->save();
            }else{
                $data=$this->request->instance()->except('id');
                $res=$model->data($data)->save();
            }
            if($res){
                return result(1,'保存成功');
            }else{
                return result(0,'保存失败');
            }
        }else{
            $fid=input('fid',0,'intval');
            $list = Configs::where(['fid'=>$fid])->order('creat_time desc')->paginate(10);
            $fids=$model->all(['fid'=>0]);
            $assign=array(
                'fids'=>$fids,
                'list'=>$list,
                'page_title'=>'系统常用参数配置'
            );
            if($id){
                $assign['info']=$model->get($id)->toArray();
            }
            $this->assign($assign);
            return view();
        }
    }
    
    public function configDel(){
        $id=input('id',0,'intval');
        if($_POST && $id){
            $model=new Configs();
            $res=$model->destroy($id);
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
