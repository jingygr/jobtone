<?php
namespace app\admin\controller;
use app\admin\model\Jobs;
use app\admin\model\Industry;
use app\admin\model\JobCategory;
use think\Model;
class Job extends Base{
    public function index(){
        $model=new Jobs();
        $cid=input('cid',0,'intval');
        if($cid){
            $map=array('cid'=>$cid);
        }else{
            $map=array();
        }
        $list = $model::where($map)->order('update_time desc')->paginate(10);
        $assign=array(
            'page_title'=>'岗位中心',
            'list'=>$list
        );
        $this->assign($assign);
		return view();
    }
    
    public function add(){
        $id=input('id',0,'intval');
        $model=new Jobs();
        if(!$id){
            $this->redirect('index/index');
        }
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
            $category=new JobCategory();
            $info=$model->get($id)->toArray();
            $assign=array(
                'info'=>$info,
                'category'=>$category->all(['fid'=>0]),
                'prov'=>getCityAy(1),
                'city'=>getCityAy($info['prov']),
                'area'=>getCityAy($info['city']),
                'sex'=>getConfigsAy(1),
                'marry'=>getConfigsAy(11),
                'workage'=>getConfigsAy(16),
                'edu'=>getConfigsAy(4),
                'worktime'=>getConfigsAy(24),
                'page_title'=>'修改岗位信息'
            );
            $this->assign($assign);
            return view();
        }
    }
    
    public function detail(){
        $id=input('id',0,'intval');
        if(!$id){
            echo '非法操作';
        }
        $model=new Jobs();
        $info=$model->get($id);
        $assign=array(
            'page_title'=>'岗位详情',
            'info'=>$info
        );
        $this->assign($assign);
        return view();
    }
    
    public function verify(){
        $id=input('id',0,'intval');
        $status=input('status',0,'intval');
        if($id&&$status&&$_POST){
            $res=db('jobs')->where(['id'=>$id])->setField('status',$status);
            if($res){
                return result(1,'设置成功');
            }else{
                return result(0, '设置失败');
            }
        }else{
            return result(0,'非法操作');
        }
    }
    
    public function del(){
        $id=input('id',0,'intval');
        if($_POST && $id){
            $model=new Jobs();
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
