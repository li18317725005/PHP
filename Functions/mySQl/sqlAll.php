<?php
/**
*向数据表插入记录
*@param  string $table,数据表名称
*@param  array $bind,由字段名称和字段值组成的关联数组
*@return string $sql,标准的INSERT语句字符串
*/
function insert($table,$bind){
   $keys = join(',',array_keys($bind));
   $vals = join('\',\'',$bind);
   $sql = 'INSERT ' . $table . '(' . $keys . ') VALUES(\'' . $vals . '\')';
   mysql_query($sql);
   return mysql_affected_rows();
}


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
