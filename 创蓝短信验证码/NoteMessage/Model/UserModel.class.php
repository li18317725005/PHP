<?php
/**
 * 用户表数据表数据模型类
 * User: haijiang
 * Date: 2017/04/17
 * Time: 21：00
 */
namespace NoteMessage\Model;

use Common\Model\CommonModel;

class UserModel extends CommonModel
{
	protected $tableName = 'user';

	/**
	 * 重置短信记录信息
	 */
	public function saveMessageInfo($user_uuid, $date){
		$where['uuid'] = $user_uuid;
		$data['message_num'] = 1;
		$data['send_time'] = $date;
		$re = $this->where($where)->save($data);
		if ($re){
			return true;
		}else{
			return false;
		}
	}

	/**
	 * 接收短信次数加 1
	 */
	public function setIncMessageNum($user_uuid){
		$where['uuid'] = $user_uuid;
		$re = $this->where($where)->setInc('message_num', 1);
		if ($re){
			return true;
		}else{
			return false;
		}
	}
}