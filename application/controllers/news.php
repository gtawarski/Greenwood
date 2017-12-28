<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News extends SecureController {
	public function index() {
		$this->data['response'] = $this->session->flashdata('response');

		$this->viewFull('news/index', $this->data);
	}
}

/* End of file news.php */
/* Location: ./application/controllers/news.php */
