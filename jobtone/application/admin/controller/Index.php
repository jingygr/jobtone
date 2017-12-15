<?php
namespace app\admin\controller;
use think\Model;
use app\admin\model\User as Muser;
use app\admin\model\UserRules;
use app\admin\model\Proxy;
use app\admin\model\Company;
use app\admin\model\Industry;
use app\admin\model\Jobs;
use think\Controller;
use think\helper\Time;
class Index extends Base{
    public function index(){
        $this->assign(['page_title'=>'用户管理中心']);
        $admins=array(
            'total'=>$this->getUserTotal(1),
            'today'=>$this->getUserToday(1),
            'week'=>$this->getUserWeek(1),
            'txt'=>$this->getUserInLastWeek(1)
        );
        $members=array(
            'total'=>$this->getUserTotal(2),
            'today'=>$this->getUserToday(2),
            'week'=>$this->getUserWeek(2),
            'txt'=>$this->getUserInLastWeekForJson(2)
        );
        $companys=array(
            'total'=>$this->getUserTotal(3),
            'today'=>$this->getUserToday(3),
            'week'=>$this->getUserWeek(3),
            'txt'=>$this->getUserInLastWeekForJson(3)
        );
        $proxys=array(
            'total'=>$this->getUserTotal(4),
            'today'=>$this->getUserToday(4),
            'week'=>$this->getUserWeek(4),
            'txt'=>$this->getUserInLastWeekForJson(4)
        );
        $jobs=array(
            'total'=>$this->getJobs(),
            'today'=>$this->getJobs(1),
            'week'=>$this->getJobs(7),
            'txt'=>$this->getJobsForJson()
        );
        $assign=array(
            'admins'=>$admins,
            'members'=>$members,
            'companys'=>$companys,
            'proxys'=>$proxys,
            'jobs'=>$jobs,
            'page_title'=>'管理后台首页'
        );
        $this->assign($assign);
		return view();
    }
    

    public function getUserInLastWeek($rule){
        $user=new Muser();
        $str=array();
        for($i=6;$i>-1;$i--){
            $start=strtotime(date('Y-m-d'))-$i*86400;
            $end=$start+86399;
            $map=array(
                'creat_time'=>array('between',[$start,$end]),
                'rule'=>$rule
            );
            $num=$user->where($map)->count();
            array_push($str, $num);
        }
        return implode(',', $str);
    }
    public function getUserInLastWeekForJson($rule){
        $user=new Muser();
        $str=array();
        for($i=6;$i>-1;$i--){
            $start=strtotime(date('Y-m-d'))-$i*86400;
            $end=$start+86399;
            $map=array(
                'creat_time'=>array('between',[$start,$end]),
                'rule'=>$rule
            );
            $num=$user->where($map)->count();
            $ay=array(
                'elapsed'=>date('Y-m-d',$start),
                'value'=>$num
            );
            array_push($str, $ay);
        }
        return json_encode($str);
    }
    public function getUserTotal($rule){
        $user=new Muser();
        $map=array(
            'rule'=>$rule
        );
        return $num=$user->where($map)->count();
    }
    public function getUserToday($rule=1){
        $user=new Muser();
        $today=Time::today();
        $map=array(
            'creat_time'=>array('between',$today),
            'rule'=>$rule
        );
        return $user->where($map)->count();
    }
    public function getUserWeek($rule=1){
        $user=new Muser();
        $week=Time::week();
        $map=array(
            'creat_time'=>array('between',$week),
            'rule'=>$rule
        );
        return $user->where($map)->count();
    }
    
    public function getJobs($t=0){
        $model=new Jobs();
        switch ($t){
            case 0:
                $map=array();
                break;
            case 1:
                $today=Time::today();
                $map=array(
                    'creat_time'=>array('between',$today)
                );
                break;
            case 7:
                $week=Time::week();
                $map=array(
                    'creat_time'=>array('between',$week)
                );
                break;                
        }
        return $model->where($map)->count();
    }
    public function getJobsForJson(){
        $model=new Jobs();
        $str=array();
        for($i=6;$i>-1;$i--){
            $start=strtotime(date('Y-m-d'))-$i*86400;
            $end=$start+86399;
            $map=array(
                'creat_time'=>array('between',[$start,$end])
            );
            $num=$model->where($map)->count();
            $ay=array(
                'elapsed'=>date('Y-m-d',$start),
                'value'=>$num
            );
            array_push($str, $ay);
        }
        return json_encode($str);
    }
    
}
