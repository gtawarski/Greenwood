<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Files extends SecureController {
	public function index() {
		$this->data['response'] = $this->session->flashdata('response');

		$this->viewFull('files/index', $this->data);
	}

	public function get_file ($files_id) {
		$this->load->model('files_model', 'files_model');

		$files = $this->files_model->get_fileDownload($files_id);

		if ($files != NULL) {
			header("Content-Type: " . $files['mimeType']);
			header("Content-Transfer-Encoding: Binary"); 
			header("Content-disposition: attachment; filename=\"" . $files['name'] . "\""); 
			readfile(DATAPATH.'/'.$files['hash']);
		} else {
			$this->load->view("general/downloadNotFound");
		}
	}

	public function upload_file() {
		$this->load->model('files_model', 'files_model');
		$fileExtensions_array = $this->files_model->get_fileTypesExtensions();
		$fileExtensions_intArray = array();
		$success = false;

		$clients_id = $this->input->post('clients_id');
		$fileTags_id = $this->input->post('fileTags_id');

		for($i = 0; $i < sizeof($fileExtensions_array); $i++) {
				$fileExtensions_intArray[] = $fileExtensions_array[$i]['extension'];
		}

		$config['upload_path'] = DATAPATH;
		$config['allowed_types'] = implode("|",$fileExtensions_intArray);
		$config['max_size']     = '0';
		$this->load->library('upload', $config);
		$this->load->helper('uuid_helper');

		$this->upload->do_upload("file");
		$data = $this->upload->data();

		if ($this->upload->display_errors() == "") {
				$uuid = gen_uuid();
				rename ($data['full_path'], DATAPATH.'/'.$uuid);

				$this->files_model->put_file($data, $clients_id, $fileTags_id, $uuid);
				$success = true;
		} else {
				$uuid = NULL;
				$success = false;
		}



		echo json_encode(
				array (
						'success' => $success,
						'uuid' => $uuid,
						'clients_id' => $clients_id,
						'errors' => $this->upload->display_errors(),
						'data' => $this->upload->data(),
						'allowed' => implode("|",$fileExtensions_intArray)
				)
		);
	}
}

/* End of file files.php */
/* Location: ./application/controllers/files.php */
