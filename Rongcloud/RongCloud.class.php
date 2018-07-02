<?php

namespace OaLibs\Third\Rongcloud;

/**
 * 融云 Server API PHP 客户端
 * create by kitName
 * create datetime : 2016-09-05 
 * 
 * v2.0.1
 */
use OaLibs\Third\Rongcloud\methods\User;
use OaLibs\Third\Rongcloud\methods\Message;
use OaLibs\Third\Rongcloud\methods\Wordfilter;
use OaLibs\Third\Rongcloud\methods\Group;
use OaLibs\Third\Rongcloud\methods\Chatroom;
use OaLibs\Third\Rongcloud\methods\Push;
use OaLibs\Third\Rongcloud\SendRequest;
use OaLibs\Third\Rongcloud\SMS;
use OaLibs\SysConst\SysConst;

class RongCloud {

    /**
     * 参数初始化
     * @param $appKey
     * @param $appSecret
     * @param string $format
     */
    public function __construct($appKey = SysConst::RONG_APP_KEY, $appSecret = SysConst::RONG_APP_SECRET, $format = SysConst::FORMAT) {
        $this->SendRequest = new SendRequest($appKey, $appSecret, $format);
    }

    public function User() {
        $User = new User($this->SendRequest);
        return $User;
    }

    public function Message() {
        $Message = new Message($this->SendRequest);
        return $Message;
    }

    public function Wordfilter() {
        $Wordfilter = new Wordfilter($this->SendRequest);
        return $Wordfilter;
    }

    public function Group() {
        $Group = new Group($this->SendRequest);
        return $Group;
    }

    public function Chatroom() {
        $Chatroom = new Chatroom($this->SendRequest);
        return $Chatroom;
    }

    public function Push() {
        $Push = new Push($this->SendRequest);
        return $Push;
    }

    public function SMS() {
        $SMS = new SMS($this->SendRequest);
        return $SMS;
    }

}
