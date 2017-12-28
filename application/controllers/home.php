<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends SecureController {
	public function index() {
		$this->data['response'] = $this->session->flashdata('response');

		$this->viewFull('home/index', $this->data);
	}

	public function notFound () {
		$this->data['response'] = $this->session->flashdata('response');
		$this->data['methodScript'] = NULL;

		$this->viewFull('general/viewNotFound', $this->data);
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
