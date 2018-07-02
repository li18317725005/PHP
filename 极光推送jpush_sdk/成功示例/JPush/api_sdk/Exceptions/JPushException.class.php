<?php
namespace OaLibs\Third\JPush\api_sdk\Exceptions;

class JPushException extends \Exception {

    function __construct($message) {
        parent::__construct($message);
    }
}
