<?php

class Zenvia
{
	private $sendSmsRequest;
	private $zenvia_auth;
    private $zenvia_from;
    private $zenvia_msg;
    private $zenvia_aggregateId;

	public function __construct($conf) 
	{
    	$this->api_token=$conf['zenvia_auth'];
    	$this->zenvia_from=$conf['zenvia_from'];
    	$this->zenvia_msg=$conf['zenvia_msg'];
    	$this->zenvia_aggregateId=$conf['zenvia_aggregateId'];    	

  	}
  	public function setData($data)
  	{
  		extract($data);
  		if(!isset($phone))
  		{
  			return false;
  		}
  		$date = new DateTime();
		$date->setTimeZone(new DateTimeZone('America/Sao_Paulo'));
		$date->modify("+10 minutes");
		$schedule = $date->format("Y-m-d\TH:i:s");
		$this->sendSmsRequest = array(
		  'sendSmsRequest'=> array(
		    'from'=>$this->zenvia_from,
		    'to'=> '55'. $phone,
		    'schedule'=> '2014-08-22T14:55:00',
		    'msg'=>$this->zenvia_msg,
		    "callbackOption"=> "NONE",
		    "id"=> uniqid(),
		    "aggregateId"=> $this->zenvia_aggregateId
		  )
		);
		return true;
  	}
	
	function send()
	{
	    $url = "https://api-rest.zenvia360.com.br/services/send-sms";
	    
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
	    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	                                    'Accept:application/json',
	                                    'Authorization: Basic '. $this->zenvia_auth,
	                                    'Content-Type:application/json'
	                                    ) );
	    //cGVkcm9AZmxvdy5jb20uYnI6RmxvdzIwMTc=


	    if($this->sendSmsRequest != null)
	    {
	        //$data_batch = array();
	        //$data_batch['members'] = $data ;
	        //$data['update_existing'] = true;
	        $data_json = json_encode($sendSmsRequest, JSON_PRETTY_PRINT);
	        
	        //var_dump($data_json);        
	        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
	        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	    }
	    //curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: ".$return));
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	    $result = curl_exec($ch);
	    //var_dump($result);

	    curl_close($ch);

	    
	    return $result;
	}
}
