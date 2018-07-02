<?php

namespace OaLibs\Third\JPush;

use OaLibs\Third\JPush\api_sdk\Client;
use OaLibs\Third\JPush\api_sdk\Exceptions\APIConnectionException;
use OaLibs\SysConst\SysConst;

/**
 * 极光推送服务类
 *
 * @author KK
 */
class Jpush {
    /**
     * 发送推送消息
     * @param type $jpushIds 极光推送用户标识数组转成的json(最多1000个)
     * @param type $msg 推送信息, json格式
     */
    public function sendJpushMsg($jpushIds, $title, $msg = '') {
        if (count($jpushIds) > 1000) {
            return array('code' => -1, 'msg' => '推送个数不能超过1000个');
        }
//      header("Access-Control-Allow-Origin: *");
//      $client = new Client('d9048d5517e09554e83341f2', '12adebef289cd56ac5495597', null);
        $client = new Client(SysConst::APP_KEY, SysConst::MASTER_SECRET, null);
        
        try {
            $response = $client->push()
                    ->setPlatform(array('ios', 'android'))
                    ->addRegistrationId($jpushIds)
                    ->setNotificationAlert('你好！')
                    ->iosNotification($title, array(
                        'extras' => array(
                            'msg' => $msg
                        ),
                    ))
                    ->androidNotification($title, array(
                        'extras' => array(
                            'msg' => $msg
                        ),
                    ))
                    ->options(array(
                        // sendno: 表示推送序号，纯粹用来作为 API 调用标识，
                        // API 返回时被原样返回，以方便 API 调用方匹配请求与返回
                        // 这里设置为 100 仅作为示例
                        // 'sendno' => 100,
                        // time_to_live: 表示离线消息保留时长(秒)，
                        // 推送当前用户不在线时，为该用户保留多长时间的离线消息，以便其上线时再次推送。
                        // 默认 86400 （1 天），最长 10 天。设置为 0 表示不保留离线消息，只有推送当前在线的用户可以收到
                        // 这里设置为 1 仅作为示例
                        // 'time_to_live' => 1,
                        // apns_production: 表示APNs是否生产环境，
                        // True 表示推送生产环境，False 表示要推送开发环境；如果不指定则默认为推送生产环境

                        'apns_production' => false,
                            // big_push_duration: 表示定速推送时长(分钟)，又名缓慢推送，把原本尽可能快的推送速度，降低下来，
                            // 给定的 n 分钟内，均匀地向这次推送的目标用户推送。最大值为1400.未设置则不是定速推送
                            // 这里设置为 1 仅作为示例
                            // 'big_push_duration' => 1
                    ))
                    ->send();
            if ($response['http_code'] == 200) {
                return array('code' => 200, 'msg' => '推送成功', 'data' => array('success' => 1));
            } else {
                return array('code' => -2, 'msg' => '推送失败');
            }
        } catch (APIConnectionException $e) {
            // try something here
            \Think\Log::write(print_r($e, true));
        }
    }

}
