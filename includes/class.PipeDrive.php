<?php

class Pipedrive
{
	private $api_token;
	private $data;
	private $person;
	private $personId;
	private $value;
	private $deal;

	public function __construct($conf) 
	{
    	$this->api_token=$conf['pipedrive_api_token'];
    	

  	}
  	public function setData($data)
  	{
  		extract($data);
  		$name = isset($name)? $name:'';
  		$phone = isset($phone)? $phone:'';
  		
		$this->person = array(
		 'name' => $name,
		 'email' => $email,
		 'phone' => $phone
		);
		$this->value = isset($value)? $value :'0';
  	}
	public function create_person()
	{
		$url = "https://api.pipedrive.com/v1/persons?api_token=" . $this->api_token;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept:application/json') );
		curl_setopt($ch, CURLOPT_POSTFIELDS, $this->person);
		curl_setopt($ch, CURLINFO_HEADER_OUT, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$output = curl_exec($ch);
		$info = curl_getinfo($ch);
		curl_close($ch);

		// create an array from the data that is sent back from the API
		$result = json_decode($output, 1);
		// check if an id came back
		//var_dump($result);
		if (!empty($result['data']['id'])) 
		{
			$person_id = $result['data']['id'];
			$this->person_id = $person_id;
			return $person_id;
		} else 
		{

			return false;
		}
	}
	 
	public function create_deal()
	{
		$deal = array
		(
		 'title' => $this->person_id,
		 'value' => '0',
		 'person_id'=> $this->person_id
		); 

		$url = "https://api.pipedrive.com/v1/deals?api_token=" .  $this->api_token;
		//var_dump($url);


		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept:application/json') );
		curl_setopt($ch, CURLOPT_POSTFIELDS, $deal);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$output = curl_exec($ch);
		$info = curl_getinfo($ch);
		curl_close($ch);

		// create an array from the data that is sent back from the API
		$result = json_decode($output, 1);
		// check if an id came back
		if (!empty($result['data']['id'])) {
		$deal_id = $result['data']['id'];
		return $deal_id;
		} else {
		return false;
		}
	}
}
