<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Files extends AjaxController {
	public function __construct () {
		parent::__construct();
		$this->load->model('files_model', 'files_model');
	}

	public function index () {
		echo json_encode(
				array(
					'success' => true,
					'message' => 'No data is returned by this service call'
				)
			);
	}

	public function delete_file() {
		$data = $this->input->post();

		$this->files_model->delete_file($data);

		echo json_encode(
				array(
					'success' => true
				)
			);
	}

	public function get_filesInit() {
		$user = $this->session->userdata('user');
		
		if ($user['clients_id'] > 0) {
			$filterClients = array();
			$filterClients[] = array(
							'clients_id' => $user['clients_id'],
							'clients_name' => $user['clients_name'],
						);
		} else {
			$filterClients = $this->files_model->get_filterClients();
		}

		$filterTags = $this->files_model->get_filterTags();
		$filterClientsDefault = $this->session->userdata('filterClientsDefault');

		$recordsDetails = ($user['accessConfigs_id'] > 9?false:true);

		echo json_encode(
				array(
					'success' => true,
					'filterClients' => $filterClients,
					'filterTags' => $filterTags,
					'filterClientsDefault' => $filterClientsDefault,
					'recordsDetails' => $recordsDetails
				)
			);
	}

	public function get_files() {
		$data = $this->input->post();
		$files = $this->files_model->get_files($data);

		$records = array();
		foreach ($files as $file) {
			$file['files_size'] = FileSizeConvert(filesize(DATAPATH.'/'.$file['fileUUID']));

			if (array_key_exists($file['fileTags_name'], $records)) {
				$records[$file['fileTags_name']][] = $file;
			} else {
				$records[$file['fileTags_name']] = array($file);
			}
		}

		if ($data['clients_id'] > 0) {
			$this->session->set_userdata('filterClientsDefault', array(
				'clients_id' => $data['clients_id'],
				'clients_name' => $data['clients_name']
			));
		} else {
			$this->session->unset_userdata('filterClientsDefault');
		}

		echo json_encode(
				array(
					'success' => true,
					'records' => $records
				)
			);
	}

	public function get_file() {
		$data = $this->input->post();
		
		$response['file'] = $this->files_model->get_file($data);
		$response['fileTags'] = $this->files_model->get_fileTags();
		$response['brokers'] = $this->files_model->get_brokers($data);

		echo json_encode(
				array(
					'success' => true,
					'data' => $response
				)
			);
	}

	public function patch_file() {
		$data = $this->input->post();

		$this->files_model->patch_file($data);

		echo json_encode(
				array(
					'success' => true,
					'data' => $data
				)
			);
	}
}

/* End of file files.php */
/* Location: ./application/controllers/ajax/files.php */