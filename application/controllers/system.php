<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class System extends OpenController {
	public function _remap ($method, $params = array()) {
		switch ($method) {
			case 'logout':
			case 'autoLogout':
				$this->$method();
				break;
			case 'activate':
				$this->activate($params);
				break;
			default:
				$this->index();
				break;
		}
		return;
	}

	public function index() {
		$this->data['response'] = $this->session->flashdata('response');

		$this->load->view('general/headerLogin', $this->data);
		$this->load->view('system/index', $this->data);
		$this->load->view('general/footerLogin', $this->data);
	}

	public function logout () {
		$user = $this->session->userdata('user');
		if ($user != NULL) {
			$this->session->unset_userdata('user');
			$this->session->set_flashdata('response', array('success' => true, 'message' => 'Logout Successful'));
		}
		redirect ('/system');
	}

	public function autoLogout () {
		$user = $this->session->userdata('user');
		if ($user != NULL) {
			$this->session->unset_userdata('user');
			$this->session->set_flashdata('response', array('success' => true, 'message' => 'You were automatically logged out due to inactivity'));
		}
		redirect ('/system');
	}

	public function activate ($params = array()) {
		$this->data['response'] = $this->session->flashdata('response');

		$this->data['activate'] = true;
		$this->data['params'] = $params;

		$this->load->view('general/headerLogin', $this->data);
		$this->load->view('system/index', $this->data);
		$this->load->view('general/footerLogin', $this->data);
	}
}

/* End of file system.php */
/* Location: ./application/controllers/system.php */
