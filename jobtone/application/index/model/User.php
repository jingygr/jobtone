<?php
namespace app\admin\model;
use think\Model;
class User extends Model{
	public function order(){
		return $this->hasOne('Orderinfo')->field('order,ctime as otime');
	}
}