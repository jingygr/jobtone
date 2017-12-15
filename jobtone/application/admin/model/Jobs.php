<?php
namespace app\admin\model;
use think\Model;
use traits\model\SoftDelete;
class Jobs extends Model{
	use SoftDelete;
	protected $deleteTime = 'delete_time';
	protected $auto = [];
	protected $insert = ['creat_time','update_time'];
	protected $update = ['update_time'];
	protected $createTime = 'creat_time';
	protected $updateTime = 'update_time';
	protected $autoWriteTimestamp = true;
	protected $type = [
			'creat_time'    =>'timestamp:Y-m-d',
			'update_time'     =>'timestamp:Y-m-d',
	];
	
	protected function setCreatTimeAttr(){
		return time();
	}
	
	protected function setUpdateTimeAttr(){
		return time();
	}
	
	protected function getCompanyAttr($value,$data){
	    return db('company')->where(['id'=>$data['cid']])->find();
	}
	
	protected function getSextxtAttr($value,$data){
	    return db('configs')->where(['fid'=>1,'value'=>$data['sex']])->value('zh');
	}
	protected function getWorktimetxtAttr($value,$data){
	    return db('configs')->where(['fid'=>24,'value'=>$data['worktime']])->value('zh');
	}
	protected function getMarrytxtAttr($value,$data){
	    return db('configs')->where(['fid'=>11,'value'=>$data['marry']])->value('zh');
	}
	protected function getWorkagetxtAttr($value,$data){
	    return db('configs')->where(['fid'=>16,'value'=>$data['workage']])->value('zh');
	}
	protected function getEdutxtAttr($value,$data){
	    return db('configs')->where(['fid'=>4,'value'=>$data['edu']])->value('zh');
	}
	protected function getCategorytxtAttr($value,$data){
	    return db('job_category')->where(['id'=>$data['category']])->value('name');
	}
}