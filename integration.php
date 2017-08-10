<?php

$config = include_once('config.php');

foreach (glob("includes/class.*.php") as $filename)
{
    include_once $filename;
    var_dump($filename);
}
$data = $_POST;


if($config['mailchimp'])
{
	$MC = new MC($conf);
	$MC->setData($data);
	$MC->send();
}
if($config['pipedrive'])
{
	$pipe = new Pipedrive($conf);
	if($pipe->setData($data))
	{
		$personId = $pipe->createPerson();
		if(isset($personId))
		{
			$pipe->create_deal();
		}
	}
}
if($config['zenvia'])
{
	$zenv = new Zenvia($conf);
	$sms = $zenv->setData($data);
	if($sms)
	$zenv->send();
}