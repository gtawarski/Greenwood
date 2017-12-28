<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Clients extends AjaxController {
	public function __construct () {
		parent::__construct();
		$this->load->model('clients_model', 'clients_model');
	}

	public function index () {
		echo json_encode(
				array(
					'success' => true,
					'message' => 'No data is returned by this service call'
				)
			);
	}

	public function delete_clientUser () {
		$request = $this->input->post();

		$record = $this->clients_model->delete_clientUser($request['users_id']);

		echo json_encode(
				array (
					'success' => true
				)
			);
	}

	public function delete_clientDetail () {
		$request = $this->input->post();

		$record = $this->clients_model->delete_clientDetailById($request['clients_id']);

		echo json_encode(
				array (
					'success' => true,
					'record' => $record
				)
			);
	}

	public function delete_logo () {
		$request = $this->input->post();

		$record = $this->clients_model->delete_logo($request['clients_id']);

		echo json_encode(
				array (
					'success' => true
				)
			);
	}

	public function get_clients () {
		$filterNameSearch = $this->input->post('filterNameSearch');
		$currentPage = $this->input->post('currentPage');

		$data = $this->clients_model->get_clients($filterNameSearch, $currentPage);

		echo json_encode(
				array (
					'success' => true,
					'records' => $data['records'],
					'itemCount' => $data['itemCount']
				)
			);
	}

	public function get_clientDetail () {
		$request = $this->input->post();

		$record = $this->clients_model->get_clientDetailById($request['clients_id']);
		$record['clients_datetime'] = time();
		
		echo json_encode(
				array (
					'success' => true,
					'record' => $record
				)
			);
	}

	public function get_clientFiles () {
		$data = $this->input->post();

		$this->session->set_userdata('filterClientsDefault', $data);

		echo json_encode(
				array (
					'success' => true
				)
			);
	}

	public function get_clientUsers () {
		$data = $this->input->post();

		$records = $this->clients_model->get_clientUsers($data);

		echo json_encode(
				array (
					'success' => true,
					'records' => $records
				)
			);
	}

	public function patch_clientDetail () {
		$data = $this->input->post();
		$this->clients_model->patch_clientDetail($data);

		echo json_encode(
				array (
					'success' => true,
					'data' => $data
				)
			);
	}

	public function patch_clientDetailWithLogo () {
		$config['upload_path'] = DATAPATH;
		$config['allowed_types'] = strtolower(implode("|",array('JPG', 'JPEG', 'PNG')));
		$config['max_size']	= '1048576';
		$this->load->library('upload', $config);

		$this->upload->do_upload("file");
		$fileData = $this->upload->data();
		$formData = $this->input->post();

		if ($this->upload->display_errors() == "") {
			$uuid = gen_uuid();
			rename ($fileData['full_path'], DATAPATH.'/clientLogos/'.$uuid);
			
			$formData = $this->clients_model->patch_clientDetailWithLogo($formData, $fileData, $uuid);
			$success = true;
		} else {
			$uuid = NULL;
			$success = false;
		}

		echo json_encode(
				array (
					'success' => $success,
					'data' => $formData,
					'errors' => $this->upload->display_errors()
				)
			);
	}

	public function put_clientNew () {
		$data = $this->input->post();

		$clients_id = $this->clients_model->put_clientNew($data);

		echo json_encode(
				array (
					'success' => true,
					'clients_id' => $clients_id
				)
			);
	}

	public function put_clientUser () {
		$data = $this->input->post();
		$this->clients_model->put_clientUser($data);

		echo json_encode(
				array (
					'success' => true
				)
			);
	}
}

/* End of file clients.php */
/* Location: ./application/controllers/ajax/clients.php */