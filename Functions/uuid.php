<?php

function uuid(){
	$charid = md5(uniqid(mt_rand(), true));
	$uuid = substr($charid, 0, 8) . '-'
			.substr($charid, 8, 4). '-'
					.substr($charid,12, 4). '-'
							.substr($charid,16, 4). '-'
									.substr($charid,20,12);
	return $uuid;
}