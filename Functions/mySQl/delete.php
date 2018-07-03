<?php 
/**
*删除记录
*@param  string $table,数据表名称
*@param  string $where,删除记录的条件
*@return string $sql,标准的DELETE语句字符串
*/
function delete($table,$where = NULL){
	$sql = 'DELETE FROM ' . $table . ($where == NULL ? $where : ' WHERE '  . $where) ;
	return $sql;
}
