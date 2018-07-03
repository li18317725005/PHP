<?php
/**
*更新记录
*@param  string $table,数据表名称
*@param  array  $bind,由字段名称和字段值组成的关联数组
*@param  string $where,更新记录的条件
*@return string $sql,标准的UPDATE语句字符串
*/

function update($table,$bind,$where = NULL){	
    foreach ($bind as $key => $value) {    
    	$sql .= ($sql === NULL ? $sql : ',') .  $key . '=\'' . $value . '\'';
    }
    $sql = 'UPDATE ' . $table . ' SET ' . $sql . ($where === NULL ? $where : ' WHERE ' . $where);
    return $sql;
}