<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Secure extends AjaxController {

	public function __construct () {
		parent::__construct();
	}

	public function index () {
		$user = $this->session->userdata('user');

		if (time() - $user['lastTime'] >= 1800) {
			print (json_encode(array('logout' => true)));
		} else {
			print (json_encode(array('logout' => false, 'timeLeft' => (1800 - (time() - $user['lastTime'])))));
		}
	}
}

/* End of file secure.php */
/* Location: ./application/controllers/ajax/secure.php */