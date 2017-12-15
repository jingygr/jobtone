<?php
namespace app\admin\model;
use think\Model;
use traits\model\SoftDelete;
class Company extends Model{
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
	protected function getIndustrytxtAttr($value,$data){
	    return db('industry')->where(['id'=>$data['industry']])->value('name');
	}	
}