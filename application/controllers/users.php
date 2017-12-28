<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends SecureController {
	public function index() {
		$this->data['response'] = $this->session->flashdata('response');

		$this->viewFull('users/index', $this->data);
	}
}

/* End of file users.php */
/* Location: ./application/controllers/users.php */
