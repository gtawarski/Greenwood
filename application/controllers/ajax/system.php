<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class System extends AjaxOpenController {

	public function __construct () {
		parent::__construct();
		$this->load->model('system_model', 'system_model');
	}

	public function index () {
		echo json_encode(
				array(
					'success' => true,
					'message' => 'No data is returned by this service call'
				)
			);
	}

	public function get_login () {
		$email = $this->input->post('email');
		$password = $this->input->post('password');

		$user = $this->system_model->get_userByEmailAndPassword($email, $password);

		if (sizeof($user) == 0) {
			echo json_encode(
				array(
					'success' => false,
					'message' => 'Invalid Login'
				)
			);
			return false;
		}

		if (isset($user['isActive']) && ($user['isActive'] == 0)) {
			echo json_encode(
				array(
					'success' => false,
					'message' => 'Account not active - contact support'
				)
			);
			return false;
		}

		$user['lastTime'] = time();
		
		echo json_encode(
			array(
				'success' => true,
				'location' => '/home'
			)
		);
		
		$this->session->set_userdata('user', $user);
		return true;
	}

	public function put_activation () {
		$data = $this->input->post();

		$response = $this->system_model->put_activation($data);

		if ($response['success'] == true) {
			$user = $this->system_model->get_userByEmailAndPassword($data['email'], $data['password']);
			$user['lastTime'] = time();
			
			$response['location'] = '/home';
			
			$this->session->set_userdata('user', $user);
		}

		echo json_encode(
			$response
		);
	}

	public function put_resetPassword () {
		$data = $this->input->post();

		$response = $this->system_model->put_resetPassword($data);

		if ($response['success'] == true) {
			$response['message'] = 'A reset email was sent to you.  Make sure to check your junk / spam folder.';
		} else {
			$response['message'] = 'There was a problem resetting your password.  Contact support!';
		}

		echo json_encode(
			$response
		);
	}
}

/* End of file system.php */
/* Location: ./application/controllers/ajax/system.php */