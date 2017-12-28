<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Clients extends SecureController {
	public function index() {
		$this->data['response'] = $this->session->flashdata('response');

		$this->viewFull('clients/index', $this->data);
	}

	public function get_clientLogo ($client_id, $dateTime) {
		$this->load->model('clients_model', 'clients_model');

		$data = $this->clients_model->get_clientDetailById($client_id);
		$data['clients_config'] = json_decode($data['clients_config'], true);

		if (isset($data['clients_config']['logoType']) && (file_exists(DATAPATH.'/clientLogos/'.$data['clients_config']['logo']))) {
			header ("Content-type: " . $data['clients_config']['logoType']);
			readfile(DATAPATH.'/clientLogos/'.$data['clients_config']['logo']);
		} else {
			header ("Content-type: image/jpeg");
			readfile(DATAPATH.'/system/nologo.jpg');
		}
		return;
	}
}

/* End of file clients.php */
/* Location: ./application/controllers/clients.php */
