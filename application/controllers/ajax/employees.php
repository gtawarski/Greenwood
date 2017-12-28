<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employees extends AjaxController {
	public function delete_user () {
		$this->load->model('accounts_model', 'accounts_model');
		$request = $this->input->post();

		$record = $this->accounts_model->delete_user($request['users_id']);

		echo json_encode(
				array (
					'success' => true
				)
			);
	}

	public function get_account() {
		$this->load->model('accounts_model', 'accounts_model');
		$data = $this->accounts_model->get_users();

		echo json_encode(
				array (
					'success' => true,
					'data' => $data
				)
			);
	}

	public function put_userInvitationRequest() {
		$this->load->model('accounts_model', 'accounts_model');
		$data = $this->input->post();
		$this->accounts_model->put_userInvitationRequest($data);

		echo json_encode(
				array (
					'success' => true
				)
			);
	}

	public function put_user () {
		$this->load->model('accounts_model', 'accounts_model');
		$data = $this->input->post();
		$this->accounts_model->put_user($data);

		echo json_encode(
				array (
					'success' => true
				)
			);
	}
	
}
/* End of file employees.php */
/* Location: ./application/controllers/ajax/employees.php */