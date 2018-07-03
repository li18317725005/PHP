<?php
/**
 * 管理员表的实体或者对象
*
* @author haijiang<821071416@qq.com>
* @since 2016/12/17
*/ 
namespace Common\Common;

class Operate extends Base
{
	protected $uuid;      //唯一标识
	protected $admin_id;  //管理员id
	protected $admin_name;//管理员名称
	protected $phone;     //被操作用户的手机号
	protected $caozuo;    //操作类型
	protected $user_uuid; //被操作用户的uuid

	public function __construct($uuid,
			              		$admin_id,
			              		$admin_name,
			              		$phone,
			              		$caozuo,
			              		$user_uuid
		                        ){
		$this->uuid = $uuid;
		$this->admin_id = $admin_id;
		$this->admin_name = $admin_name;
		$this->phone = $phone;
		$this->caozuo = $caozuo;
		$this->user_uuid = $user_uuid;
	}

}