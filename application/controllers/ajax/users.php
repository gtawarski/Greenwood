<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends AjaxController {
	public function __construct () {
		parent::__construct();
		$this->load->model('users_model', 'users_model');
	}

	public function index () {
		echo json_encode(
				array(
					'success' => true,
					'message' => 'No data is returned by this service call'
				)
			);
	}

	public function get_users () {
		$filterNameSearch = $this->input->post('filterNameSearch');
		$currentPage = $this->input->post('currentPage');

		$data = $this->users_model->get_users($filterNameSearch, $currentPage, $this->user['accessConfigs_id']);

		echo json_encode(
				array (
					'success' => true,
					'records' => $data['records'],
					'itemCount' => $data['itemCount']
				)
			);
	}

	public function get_userDetail () {
		$request = $this->input->post();

		$this->load->model('brokers_model', 'brokers_model');
		$this->load->model('clients_model', 'clients_model');
		$record = array();

		if ($request['users_id'] !== NULL && (int)$request['users_id'] > 0) {
			$record = $this->users_model->get_userDetailById($request['users_id']);
			$record['users_datetime'] = time();
		} else {
			$record['users_id'] = NULL;
			$record['user_firstname'] = "";
			$record['user_lastname'] = "";
			$record['user_email'] = "";
			$record['accessConfigs_id'] = 9;
			$record['brokers_id'] = "0";
			$record['clients_id'] = "0";
		}

		$brokers = array(0 => "-- SELECT A BROKER --");
		$clients = array(0 => "-- SELECT A BROKER --");

		$broker_set = $this->brokers_model->get_allBrokers();
		$client_set = $this->clients_model->get_allClients();

		foreach ($broker_set['records'] as $broker) {
			$brokers[$broker['brokers_id']] = $broker['brokers_name'];
		}

		foreach ($client_set['records'] as $client) {
			$clients[$client['clients_id']] = $client['clients_name'];
		}
		
		echo json_encode(
				array (
					'success' => true,
					'record' => $record,
					'clients' => $clients,
					'brokers' => $brokers
				)
			);
	}

	public function put_userNew () {
		$data = $this->input->post();
		
		$existingUser = $this->users_model->get_userDetailByEmail($data);
		
		if (!is_null($existingUser) && !isset($existingUser['users_id'])) {
			$result = $this->users_model->put_userNew($data);
			if ($result === false) {
				echo json_encode(
					array (
							'result' => $existingUser,
							'success' => false,
							'error' => 'User was not created'
					)
				);
			} else {
				echo json_encode(
					array (
							'result' => $existingUser,
							'success' => true
					)
				);
			}
		} else {
			echo json_encode(
				array (
						'result' => $existingUser,
						'success' => false,
						'error' => 'User already exists'
				)
			);
		}
	}
	


	public function delete_userDetail () {
		$request = $this->input->post();
	
		$record = $this->users_model->delete_user($request['users_id']);
	
		echo json_encode(
				array (
						'success' => true
				)
			);
	}
}
/* End of file users.php */
/* Location: ./application/controllers/ajax/users.php */