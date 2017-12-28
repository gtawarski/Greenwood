<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class OpenController extends CI_Controller {
	
	public function __construct () {
		parent::__construct();
		if (!isset($this->data)) {
			$this->data = array();
		}

		if (file_exists(FCPATH.'scripts/'.$this->router->fetch_class().'/controller.js') && file_exists(FCPATH.'scripts/'.$this->router->fetch_class().'/service.js')) {
			$this->data['methodScript'] = $this->router->fetch_class();
		} else {
			$this->data['methodScript'] = NULL;
		}

		$this->load->model('system_model', 'system_model');
	}
}

class SecureController extends CI_Controller {
	private $user;
	
	function __construct () {
		parent::__construct();

		if (!isset($this->data)) {
			$this->data = array();	
		}

		$this->user = $this->session->userdata('user');

		if ($this->user == NULL) {
			$this->session->set_flashdata('response', array('success' => false, 'message' => 'You must log in.'));
			redirect ('/system');
		}

		if (file_exists(FCPATH.'scripts/'.$this->router->fetch_class().'/controller.js') && file_exists(FCPATH.'scripts/'.$this->router->fetch_class().'/service.js')) {
			$this->data['methodScript'] = $this->router->fetch_class();
		} elseif (file_exists(FCPATH.'scripts/admin/'.$this->router->fetch_class().'/controller.js') && file_exists(FCPATH.'scripts/admin/'.$this->router->fetch_class().'/service.js')) {
			$this->data['methodScript'] = 'admin/' . $this->router->fetch_class();
		} else {
			$this->data['methodScript'] = NULL;
		}

		$user = $this->session->userdata('user');

		if (time() - $user['lastTime'] >= 1800) {
			redirect ('/system/autoLogout');
		}

		$user['lastTime'] = time();
		$this->session->set_userdata('user', $user);

		$this->data['user'] = $user;
	}

	public function viewFull ($file, $data) {
		$this->load->library('navigation');

		$config = json_decode($this->user['accessConfigs_config'], true);
		if (!isset($config['menu'])) {
			$config['menu'] = array();
		}

		$data['systemMenu'] = $this->navigation->get_menu ($config['menu']);
		
		$this->load->view('general/headerSecure', $data);
		if (file_exists(APPPATH."views/".$file.".php")) {
			$this->load->view($file, $data);
		} else {
			$this->load->view('general/viewNotFound', $data);
		}
		$this->load->view('general/footerSecure', $data);
	}
}

class ProfileController extends CI_Controller {
	private $user;
	
	function __construct () {
		parent::__construct();

		if (!isset($this->data)) {
			$this->data = array();	
		}

		$this->user = $this->session->userdata('user');

		if ($this->user == NULL) {
			$this->session->set_flashdata('response', array('success' => false, 'message' => 'You must log in.'));
			redirect ('/system');
		}

		if (file_exists(FCPATH.'scripts/'.$this->router->fetch_class().'/controller.js') && file_exists(FCPATH.'scripts/'.$this->router->fetch_class().'/service.js')) {
			$this->data['methodScript'] = $this->router->fetch_class();
		} else {
			$this->data['methodScript'] = NULL;
		}

		$user = $this->session->userdata('user');

		if (time() - $user['lastTime'] >= 1800) {
			redirect ('/system/autoLogout');
		}

		$user['lastTime'] = time();
		$this->session->set_userdata('user', $user);

		$this->data['user'] = $user;
	}

	public function viewFull ($file, $data) {
		$this->load->library('navigation');

		if (!isset($config['menu'])) {
			$config['menu'] = array();
		}

		$this->load->view('general/headerProfile', $data);
		if (file_exists(APPPATH."views/".$file.".php")) {
			$this->load->view($file, $data);
		} else {
			$this->load->view('general/viewNotFound', $data);
		}
		$this->load->view('general/footerProfile', $data);
	}
}

class AjaxController extends CI_Controller {
	function __construct () {
		parent::__construct();
		if (!isset($this->data)) {
			$this->data = array();	
		}

		$this->user = $this->session->userdata('user');
		if ($this->user == NULL) {
			$this->session->set_flashdata('response', array('success' => false, 'message' => 'You must log in.'));
			redirect ('/system');
		}

		$this->ajaxCheck();

		$user = $this->session->userdata('user');
		$this->data['user'] = $user;

		header ("Content-type: text/json");
		if ($this->router->class != 'secure') {
			$user['lastTime'] = time();
			$this->session->set_userdata('user', $user);
		}
	}

	public function ajaxCheck () {
		if (!$this->input->is_ajax_request()) {
			header ("Content-type: text/html");
			print ("THIS NEEDS TO BE AN AJAX REQUEST - YOU CAN'T ACCESS THIS METHOD DIRECTLY");
			exit();
		}
	}
}

class AjaxOpenController extends CI_Controller {
	function __construct () {
		parent::__construct();
		if (!isset($this->data)) {
			$this->data = array();	
		}

		$this->ajaxCheck();

		header ("Content-type: text/json");
	}

	public function ajaxCheck () {
		if (!$this->input->is_ajax_request()) {
			header ("Content-type: text/html");
			print ("THIS NEEDS TO BE AN AJAX REQUEST - YOU CAN'T ACCESS THIS METHOD DIRECTLY");
			exit();
		}
	}
}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */
