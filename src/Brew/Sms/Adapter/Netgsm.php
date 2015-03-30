<?php
namespace Brew\Sms\Adapter;
class Netgsm extends AbstractAdapter {
	protected $url = 'http://api.netgsm.com.tr/bulkhttppost.asp';
	protected $returnCodes = array(
		'00' => array(
			'status' => true,
			'message' => 'OK',
		),
		'01' => array(
			'status' => true,
			'message' => 'OK',
		),
		'02' => array(
			'status' => true,
			'message' => 'OK',
		),
		'20' => array(
			'status' => false,
			'message' => 'Failed',
		),
		'30' => array(
			'status' => false,
			'message' => 'Failed',
		),
		'40' => array(
			'status' => false,
			'message' => 'Failed',
		),
		'70' => array(
			'status' => false,
			'message' => 'Failed',
		),
	);
	public function run($params = array()) {
		$message = array_key_exists('message', $params) ? $params['message'] : null;
		$title = array_key_exists('title', $params) ? $params['title'] : null;
		$recipent = array_key_exists('recipent', $params) ? $params['recipent'] : null;		
		$query = http_build_query(array(
			'usercode' => $this->username,
			'password' => $this->password,
			'gsmno' => $recipent,
			'message' => $message,
			'msgheader' => $title,
			'startdate' => date('dmYHi'),
		));
		$curl = curl_init(); 
    	curl_setopt($curl, CURLOPT_URL, $this->url . '?' . $query);
    	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    	$response = curl_exec($curl);
    	curl_close($curl);
    	list($status, $taskID) = explode(' ', $response);
    	if(array_key_exists($status, $this->returnCodes)) {
    		$return = $this->returnCodes[$status];
    		if(!empty($taskID)) {
    			$return['taskID'] = $taskID;
    		}
    		return $return;
    	}
    	else {
    		throw new \Exception('Unknown status.');
    	}
	}
}
