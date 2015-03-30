<?php
namespace Brew\Sms;
class Sender {
	private $adapter;
	private $message;
	private $title = null;
	private $recipents = array();
	public $results = array();
	public function __construct($params = array()) {
		$this->adapter = array_key_exists('adapter', $params) ? $params['adapter'] : null;
		$this->message = array_key_exists('message', $params) ? $params['message'] : null;
		$this->title = array_key_exists('title', $params) ? $params['title'] : null;
		$this->recipents = array_key_exists('recipents', $params) ? $params['recipents'] : array();
	}
	public function setMessage($message, $title = null) {
		$this->message = $message;
		if($title != null) {
			$this->title = $title;
		}
		return $this;
	}
	public function setTitle($title) {
		$this->title = $title;
		return $this;
	}
	public function setAdapter($adapter) {
		$this->adapter = $adapter;
		return $this;
	}
	public function addRecipent($number, $name = null) {
		array_push($this->recipents, array(
			'number' => $number,
			'name' => $name,
		));
		return $this;
	}
	public function send() {
		foreach($this->recipents as $recipent) {
			$status = $this->adapter->run(array(
				'message' => $this->message,
				'title' => $this->title,
				'recipent' => $recipent['number'],
			));
			array_push($this->results, array(
				$recipent['number'] => $status
			));
		}
		if(!empty($this->results)) {
			return true;
		}
		return false;
	}
}