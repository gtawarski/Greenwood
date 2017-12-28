<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Brokers extends SecureController {
	public function index() {
		$this->data['response'] = $this->session->flashdata('response');

		$this->viewFull('brokers/index', $this->data);
	}

	public function get_brokerLogo ($broker_id, $dateTime) {
		$this->load->model('brokers_model', 'brokers_model');

		$data = $this->brokers_model->get_brokerDetailById($broker_id);
		$data['brokers_config'] = json_decode($data['brokers_config'], true);

		if (isset($data['brokers_config']['logoType']) && (file_exists(DATAPATH.'/brokerLogos/'.$data['brokers_config']['logo']))) {
			header ("Content-type: " . $data['brokers_config']['logoType']);
			readfile(DATAPATH.'/brokerLogos/'.$data['brokers_config']['logo']);
		} else {
			header ("Content-type: image/jpeg");
			readfile(DATAPATH.'/system/nologo.jpg');
		}
		return;
	}
}

/* End of file brokers.php */
/* Location: ./application/controllers/brokers.php */
