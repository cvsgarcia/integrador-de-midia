<?php

$config = include_once('includes/config.php');

foreach (glob("includes/class.*.php") as $filename)
{
    include_once $filename;
}
$data = $_POST;
$refeer = isset($_SERVER['HTTP_REFERER'])  ? $_SERVER['HTTP_REFERER'] : false;

array_pop($data);
if( !isset($data['email']))
{
	return;
}

if($config['mailchimp'])
{
	$MC = new MC($config);
	$MC->setData($data);
	//$MC->send();
}
if($config['pipedrive'])
{
	$pipe = new Pipedrive($config);
	
	$pipe->setData($data);
	
	
	$personId = $pipe->create_person();
	if(isset($personId))
	{
		$ret = $pipe->create_deal();
	}
	
}
if($config['zenvia'])
{
	$zenv = new Zenvia($config);
	$sms = $zenv->setData($data);
	if($sms)
	$zenv->send();
}
header("Location: " . $refeer . "Sucesso");