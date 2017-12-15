<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
function p_arr($arr){
    echo "<pre>";
    var_dump($arr);
    echo "</pre>";
}
//判断是否是微信登录
function is_weixin(){
    if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
        return true;
    }else{
        return false;
    }
}

function result($status,$msg){
    $result=array(
        'status'=>$status,
        'msg'=>$msg
    );
    return $result;
}

function getCity($id){
    return db('citydata')->where('id',$id)->value('name');
}
function getCityAy($fid){
    return db('citydata')->where(['fid'=>$fid])->select();
}
//获取代理商旗下的公司数量
function getCompanyNumByProxy($proxyId){
    $num=db('user')->where(['rule'=>3,'proxy'=>$proxyId])->count();
    return $num;
}
//获取一组配置项
function getConfigsAy($fid){
    return db('configs')->where(['fid'=>$fid])->select();
}