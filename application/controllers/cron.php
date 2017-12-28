<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cron extends OpenController {
	public function __construct() {
		parent::__construct();
		if (!$this->input->is_cli_request()) {
			echo 'This only works from the CLI'.PHP_EOL;
			exit(0);
		}
	}

	public function index() {
	}

	public function messages() {
		$this->load->model('messages_model', 'messages_model');
		$this->load->library('email');

		$config['protocol'] = 'sendmail';
		$config['mailpath'] = '/usr/sbin/sendmail';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'html';

		$messages = $this->messages_model->get_messageQueue();
		foreach ($messages as $message) {
			$message['messageConfig'] = json_decode($message['messageConfig'], true);

			$this->email->initialize($config);
			$this->email->from ('no-reply@ourinterchange.com');
			$this->email->to($message['messageConfig']['email']);
			$this->email->subject ($message['messageSubject']);

			$this->email->message($this->load->view('emails/'.$message['messageTemplate'], $message['messageConfig'], true));
			$this->email->send();

			$this->messages_model->patch_message($message['messageId']);
		}
	}
}

/* End of file cron.php */
/* Location: ./application/controllers/cron.php */