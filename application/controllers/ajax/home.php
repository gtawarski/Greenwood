<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends AjaxController {
	public function __construct () {
		parent::__construct();
		$this->load->model('home_model', 'home_model');
	}

	public function index () {
		echo json_encode(
				array(
					'success' => true,
					'message' => 'No data is returned by this service call'
				)
			);
	}

	public function get_init () {
		$myAccount = array (
				'id' => $this->data['user']['users_id'],
				'firstname' => $this->data['user']['users_firstname'],
				'lastname' => $this->data['user']['users_lastname'],
				'originalEmail' => $this->data['user']['users_email'],
				'email' => $this->data['user']['users_email']
			);

		$recentFiles = array();
		$recentFiles['fileList'] = $this->home_model->get_recentFiles($this->data['user']['clients_id']);
		$recentFiles['showClients'] = ($this->data['user']['clients_id'] > 0?false:true);
		
		$recentNews = $this->home_model->get_news();

		echo json_encode(
				array (
					'success' => true,
					'user' => $this->data['user'],
					'myAccount' => $myAccount,
					'recentFiles' => $recentFiles,
					'recentNews' => $recentNews
				)
			);
	}

	public function patch_account () {
		$data = $this->input->post();

		$response = $this->home_model->patch_account(
				$data,
				($data['email'] != $data['originalEmail']?true:false),
				($data['firstname'] != $data['originalFirstname']?true:false),
				($data['lastname'] != $data['originalLastname']?true:false),
				($data['newPassword'] != ""?true:false)
			);

		if ($response['success']) {
			$this->data['user']['email'] = $data['email'];
			$this->data['user']['firstname'] = $data['firstname'];
			$this->data['user']['lastname'] = $data['lastname'];

			$this->session->set_userdata('user', $this->data['user']);
		}

		echo json_encode(
				$response
			);
	}
}

/* End of file home.php */
/* Location: ./application/controllers/ajax/home.php */