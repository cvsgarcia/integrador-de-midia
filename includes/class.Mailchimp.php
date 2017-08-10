<?php

class MC
{
	private $list_id;
	private $api_key;
	private $data; 

	public function __construct($conf) 
	{
    	$this->list_id=$conf['mailchimp_listId'];
    	$this->api_key=$conf['mailchimp_apiKey'];

  	}
  	public function setData($data)
  	{
  		$i=0;
  		$this->data['email_address']= $data['email'];
  		$this->data['status'] = 'subscribed';

  		foreach ($data as $key => $value) 
  		{
  			if(!empty($value))
  			{
	  			$merge_fields['MERGE'.strval($i)] =  $value;
	  			$i++;
	  		}
  		}
  		$this->data['merge_fields'] = $merge_fields;

  	}
	public  function send()
	{
		$url = "https://%s.api.mailchimp.com/3.0/lists/%s/members/";
	    $api_key = $this->api_key;
	    $list_id= $this->list_id; 
	    //$status="subscribed";
	    list(,$dc) = explode('-',$api_key);
	    
	    $url = sprintf($url,$dc,$list_id);
	    
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
	    curl_setopt($ch, CURLOPT_USERPWD, 'anystring:'.$api_key);
	    
	    ///curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');


	    if($this->data != null)
	    {
	        $data_batch = array();
	        //$data_batch['members'] = $data ;
	        $this->data['update_existing'] = true;
	        $data_json = json_encode($this->data, JSON_PRETTY_PRINT);
	        
	        //var_dump($data_json);        
	        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
	        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	    }
	    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	    $result = curl_exec($ch);
	    //var_dump($result);

	    curl_close($ch);

	    
	    return $result;
	}
}
