<?php

/**
 * 分割文件合并分务类
 */

namespace SplitMerge\Service;

class MergeService {
    /**
     * 合并
     * @param type $file 合并之后的文件名
     * @param type $logFile 记录分割信息的文件
     */
    public function merge($file, $logFile) {
        if (!file_exists($logFile)) {
            return false;
        }
        $hash = file_get_contents($logFile); //读取分割文件的信息
        $list = explode("\r\n", $hash);
        $fp = fopen($file, "ab");    //合并后的文件名
        if ($list) {
            foreach ($list as $value) {
                if (!empty($value)) {
                    $handle = fopen($value, "rb");
                    fwrite($fp, fread($handle, filesize($value)));
                    fclose($handle);
                    unset($handle);
                }
            }
        }
        fclose($fp);
        return true;
    }

}
