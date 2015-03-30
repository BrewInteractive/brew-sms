<?php
namespace Brew\Sms\Adapter;
abstract class AbstractAdapter {
	protected $url;
	public $username;
	public $password;
	public $errors = array();
	public function __construct($params = array()) {
		$this->password = array_key_exists('password', $params) ? $params['password'] : null;
		$this->username = array_key_exists('username', $params) ? $params['username'] : null;
	}
	public function run($params = array()) {}
}