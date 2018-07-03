<?php

namespace ThinkLib\Ext\Jwt;

class Jwt {
    //获取加密类型和加密字符串
    public function jwtSignType($name) {
        $type = [
            'jt1' => ['typ' => 'jt1', 'sign_key' => 'JIJIAPP666'],
        ];
        return $type[$name];
    }
    
    /**
     * 获取jwt
     */
    public function getJwt($info, $name) {
        $sType = $this->jwtSignType($name);
        $sign = $this->getJwtSign($sType, $info);
        return base64_encode(json_encode($sType)) . '.' . base64_encode(json_encode($info)) . '.' . $sign;
    }

    //生成携带用户信息的加密串
    public function getJwtSign($sType, $info) {
        switch ($sType['typ']) {
            case "jt1":
                return $this->jt1Sign($sType, $info);
                break;
            default :
                return '';
        }
    }
    
    //-----------------------jt1加密方式开始--------------------------
    public function jt1Sign($sType, $info) {
        $data = array_merge($sType, $info);
        $sign = $this->getSign($data, 1, 1, $sType['sign_key']);
        return $sign;
    }
    
    function getSign($data, $type, $time, $signKey = '') {
        if (!$signKey) {
            $signKey = S('config')['app_sign_key'];
        }
        ksort($data);
        $str1 = '';
        foreach ($data as $d) {
            $str1 .= $d;
        }
        $str2 = md5($str1);
        $str3 = $signKey . $str2 . $time . $type;
        return md5($str3);
    }
    //-----------------------jt1加密方式结束--------------------------
  
//////////////////以下是验证部分
    public function checkJwtSign($jwt) {
        $arr = explode('.', $jwt);
        $sType = json_decode(base64_decode($arr[0]), true);
        $info = json_decode(base64_decode($arr[1]), true);
        $sign = $arr[2];
        switch ($sType['typ']) {
            case 'jt1':
                return $this->checkJt1Sign($sType, $info, $sign);
                break;
            default :
                return '';
        }
    }
    
    public function checkJt1Sign($sType, $info, $sign) {
        if ($this->jt1Sign($sType, $info) == $sign) {
            return $info;
        } else {
            return false;
        }
    }

}