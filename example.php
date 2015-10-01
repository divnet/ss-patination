<?php

	require 'libs/Pagination.php';
	
	$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_NUMBER_INT);
	$pagination = (new Pagination());
	$pagination->setCurrent($page);
	$pagination->setRpp(20);
	//$pagination->setTarget(DOMAIN_URL);
	$data = array('id'=>1,'id'=>2);
	$pagination->setTotal(count($data));

	$data = array();
	$data['prevNext'] = $pagination->getPrevNext();
	$data['CannonicalUrl'] = $pagination->getCannonicalUrl();
	$data['fooNavegation'] = $pagination->getNavigation();