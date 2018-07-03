<?php

/**
 * 大文件分割服务类
 */

namespace SplitMerge\Service;

class SplitService {
    
    /**
     * 切割大文件
     * @param type $file 文件路径及名称
     * @param type $logFile 记录分割信息的文件
     * @param type $size 切割后每个文件的大小
     */
    public function split($file, $logFile, $size = 2097152) {
        if (!file_exists($file) || empty($size) || $size <= 0) {
            return false;
        }
        $pathName = substr($file, 0, strrpos($file, '.'));
        $extension = "." . substr($file, strrpos($file, '.') + 1);
        $fp = fopen($file, "rb"); //要分割的文件
        $log = fopen($logFile, "a");    //记录分割的信息的文本文件，实际生产环境存在redis更合适
        $i = 0; //分割的块编号
        while (!feof($fp)) {
            $handle = fopen($pathName. '_' . $i . $extension, "wb");
            fwrite($handle, fread($fp, $size)); //切割的块大小, 默认2M
            fwrite($log, $pathName. '_' . $i . $extension . "\r\n");
            fclose($handle);
            unset($handle);
            $i++;
        }
        fclose($fp);
        fclose($log);
        return true;
    }

}
