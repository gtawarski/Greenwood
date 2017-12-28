<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Brokers extends AjaxController {
	public function __construct () {
		parent::__construct();
		$this->load->model('brokers_model', 'brokers_model');
	}

	public function index () {
		echo json_encode(
				array(
					'success' => true,
					'message' => 'No data is returned by this service call'
				)
			);
	}

	public function delete_brokerUser () {
		$request = $this->input->post();

		$record = $this->brokers_model->delete_brokerUser($request['users_id']);

		echo json_encode(
				array (
					'success' => true
				)
			);
	}

	public function delete_brokerDetail () {
		$request = $this->input->post();

		$record = $this->brokers_model->delete_brokerDetailById($request['brokers_id']);

		echo json_encode(
				array (
					'success' => true,
					'record' => $record
				)
			);
	}

	public function delete_logo () {
		$request = $this->input->post();

		$record = $this->brokers_model->delete_logo($request['brokers_id']);

		echo json_encode(
				array (
					'success' => true
				)
			);
	}

	public function get_brokers () {
		$filterNameSearch = $this->input->post('filterNameSearch');
		$currentPage = $this->input->post('currentPage');

		$data = $this->brokers_model->get_brokers($filterNameSearch, $currentPage);

		echo json_encode(
				array (
					'success' => true,
					'records' => $data['records'],
					'itemCount' => $data['itemCount']
				)
			);
	}

	public function get_brokerDetail () {
		$request = $this->input->post();

		$record = $this->brokers_model->get_brokerDetailById($request['brokers_id']);
		$record['brokers_datetime'] = time();
		
		echo json_encode(
				array (
					'success' => true,
					'record' => $record
				)
			);
	}

	public function get_brokerUsers () {
		$data = $this->input->post();

		$records = $this->brokers_model->get_brokerUsers($data);

		echo json_encode(
				array (
					'success' => true,
					'records' => $records
				)
			);
	}

	public function patch_brokerDetail () {
		$data = $this->input->post();
		$this->brokers_model->patch_brokerDetail($data);

		echo json_encode(
				array (
					'success' => true,
					'data' => $data
				)
			);
	}

	public function patch_brokerDetailWithLogo () {
		$config['upload_path'] = DATAPATH;
		$config['allowed_types'] = strtolower(implode("|",array('JPG', 'JPEG', 'PNG')));
		$config['max_size']	= '1048576';
		$this->load->library('upload', $config);

		$this->upload->do_upload("file");
		$fileData = $this->upload->data();
		$formData = $this->input->post();

		if ($this->upload->display_errors() == "") {
			$uuid = gen_uuid();
			rename ($fileData['full_path'], DATAPATH.'/brokerLogos/'.$uuid);
			
			$formData = $this->brokers_model->patch_brokerDetailWithLogo($formData, $fileData, $uuid);
			$success = true;
		} else {
			$uuid = NULL;
			$success = false;
		}

		echo json_encode(
				array (
					'success' => $success,
					'data' => $formData
				)
			);
	}

	public function put_brokerAccess () {
		$data = $this->input->post();

		$brokers_id = $this->brokers_model->put_brokerAccess($data);

		echo json_encode(
				array (
					'success' => true
				)
			);
	}

	public function put_brokerNew () {
		$data = $this->input->post();

		$brokers_id = $this->brokers_model->put_brokerNew($data);

		echo json_encode(
				array (
					'success' => true,
					'brokers_id' => $brokers_id
				)
			);
	}

	public function put_brokerUser () {
		$data = $this->input->post();
		$this->brokers_model->put_brokerUser($data);

		echo json_encode(
				array (
					'success' => true
				)
			);
	}
}

/* End of file brokers.php */
/* Location: ./application/controllers/ajax/brokers.php */