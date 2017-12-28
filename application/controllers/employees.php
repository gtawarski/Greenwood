<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employees extends SecureController {
	public function _remap ($method, $params = array()) {
		switch ($method) {
			case 'broker':
				$this->broker();
				break;
			case 'client':
				$this->client();
				break;
			default:
				$this->account();
				break;
		}
		return;
	}

	public function account () {
		$this->data['methodScript'] = 'employeeAccount';
		$this->data['user'] = $this->session->userdata('user');

		$this->viewFull('employees/account', $this->data);
	}

	public function broker () {
		$this->data['methodScript'] = 'employeeBroker';

		$this->viewFull('employees/broker', $this->data);
	}

	public function client () {
		$this->data['methodScript'] = 'employeeClient';

		$this->viewFull('employees/client', $this->data);
	}
}

/* End of file employees.php */
/* Location: ./application/controllers/employees.php */