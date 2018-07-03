<?php
/*数组分页结果*/
public function getPage($array, $pageSize){
	$total = count($array);
	$page = new \Think\Page($total, $pageSize);
	$page->setConfig( 'next',"下一页" );
	$page->setConfig( 'prev',"上一页" );
	$page->setConfig( 'first',"首页" );
	$page->setConfig( 'last',"尾页" );
	$pageStr = $page->show();
	$list = array_slice($array, $page->firstRow, $page->listRows);
	$data['posts'] = $list;
	$data['page'] = $pageStr;
	return $data;
}