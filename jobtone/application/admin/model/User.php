<?php
namespace app\admin\model;
use think\Model;
use traits\model\SoftDelete;
class User extends Model{
	use SoftDelete;
	protected $deleteTime = 'delete_time';
	protected $auto = [];
	protected $insert = ['creat_time','update_time','last_ip'];
	protected $update = ['update_time','last_ip'];
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
		
	public function setLastIpAttr(){
		return request()->ip();
	}	
}