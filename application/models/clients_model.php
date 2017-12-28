<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class clients_model extends CI_model {
	public function delete_clientUser ($id) {
		$currentUser = $this->session->userdata('user');

		$sql = '
				UPDATE
					`users`
				SET
					`isActive` = 0,
					`isDeleted` = 1,
					`isDeletedBy_id` = '.$currentUser['users_id'].',
					`isDeletedOn` = NOW()
				WHERE
					`id` = '.$id.'
		';

		$this->db->query($sql);
	}

	public function delete_clientDetailById ($id) {
		$currentUser = $this->session->userdata('user');

		$sql = '
				UPDATE
					`clients`
				SET
					`isActive` = 0,
					`isDeleted` = 1,
					`isDeletedBy_id` = '.$currentUser['users_id'].',
					`isDeletedOn` = NOW()
				WHERE
					`id` = '.$id.'
		';

		$this->db->query($sql);
	}

	public function delete_logo ($id) {
		$currentUser = $this->session->userdata('user');

		$sql = 'SELECT * FROM `clients` WHERE `id` ='.$id.';';

		$client = $this->db->query($sql)->row_array();
		$client['config'] = json_decode('config', true);

		unset($client['config']['logo']);
		unset($client['config']['logoType']);

		$sql = '
				UPDATE
					`clients`
				SET
					`config` = "'.json_encode($client['config']).'"
				WHERE
					`id` = '.$id.'
			;
		';

		$this->db->query($sql);
	}

	public function get_allClients() {
		$sql = '
					SELECT
						`c`.`id` `clients_id`,
						`c`.`name` `clients_name`
					FROM
						`clients` `c`
					WHERE
						`c`.`isActive` = 1 AND
						`c`.`isDeleted` = 0
					ORDER BY
						`c`.`name`
					;
		';

		$data = array('records' => array());
		$results = $this->db->query($sql)->result_array();

		$data['records'] = $results;

		return $data;
	}

	public function get_clients($filterNameSearch, $currentPage) {
		$sql = '
					SELECT SQL_CALC_FOUND_ROWS
						`c`.`id` `clients_id`,
						`c`.`name` `clients_name`,
						`c`.`config` `clients_config`,
						UNIX_TIMESTAMP() `clients_datetime`
					FROM
						`clients` `c`
					WHERE
						`c`.`isActive` = 1 AND
						`c`.`isDeleted` = 0
					' . ($filterNameSearch == NULL?NULL:' AND `c`.`name` LIKE "%'. $filterNameSearch . '%"') . '
					ORDER BY
						`c`.`name`
					LIMIT
						14
					OFFSET
						'.(($currentPage - 1)* 14).'
					;
		';

		$data = array('records' => array());
		$results = $this->db->query($sql)->result_array();

		for ($i = 0; $i < sizeof ($results); $i++) {
			$results[$i]['clients_config'] = json_decode($results[$i]['clients_config']);
		}

		$data['records'] = $results;

		$page_row = $this->db->query('SELECT FOUND_ROWS() `itemCount`;')->row_array();
		$data['itemCount'] = $page_row['itemCount'];

		return $data;
	}

	public function get_clientDetailById ($id) {
		$sql = '
				SELECT
					`c`.`id` `clients_id`,
					`c`.`name` `clients_name`,
					`c`.`config` `clients_config`
				FROM
					`clients` `c`
				WHERE
					`c`.`id` = '.$id.'
				;
		';

		return $this->db->query($sql)->row_array();
	}

	public function get_clientManagersById ($id) {
		$currentUser = $this->session->userdata('user');

		$sql = '
				SELECT
					`ua`.`id` `userAccess_id`,
					`u`.`id` `users_id`,
					`u`.`firstname` `firstname`,
					`u`.`lastname` `lastname`,
					`u`.`email` `email`
				FROM
					`users` `u`
				JOIN
					`userAccess` `ua`
				ON
					`u`.`id` = `ua`.`users_id`
				WHERE
					`ua`.`clients_id` = '.$id.' AND
					`ua`.`isActive` = 1 AND
					`ua`.`isDeleted` = 0 AND
					(`u`.`isActive` = 1 OR `u`.`isInvitation` = 1) AND
					`u`.`isDeleted` = 0 AND
					`ua`.`accessConfigs_id` = 7 AND
					`u`.`id` != '.$currentUser['id'].'
				ORDER BY
					`u`.`firstname`,
					`u`.`lastname`
		';

		return $this->db->query($sql)->result_array();
	}

	public function get_clientUsers ($data) {
		$currentUser = $this->session->userdata('user');

		$sql = '
				SELECT
					`u`.`id` `users_id`,
					`u`.`firstname` `users_firstname`,
					`u`.`lastname` `users_lastname`,
					`u`.`email` `users_email`,
					`ac`.`id` `accessConfigs_id`,
					`ac`.`name` `accessConfigs_name`
				FROM
					`users` `u`
				JOIN
					`accessConfigs` `ac`
				ON
					`u`.`accessConfigs_id` = `ac`.`id`
				WHERE
					`u`.`clients_id` = '.$data['clients_id'].' AND
					(`u`.`isActive` = 1 OR `u`.`isInvitation` = 1) AND
					`u`.`isDeleted` = 0 AND
					`u`.`isDeleted` = 0 AND
					`u`.`accessConfigs_id` IN (7,8)
				ORDER BY
					`u`.`firstname`,
					`u`.`lastname`
		';

		return $this->db->query($sql)->result_array();
	}

	public function patch_clientDetail ($data) {
		$data['clients_config'] = json_decode($data['clients_config'], true);

		$sql = '
				UPDATE
					`clients`
				SET
					`name` = "'.addslashes($data['clients_name']).'",
					`config` = "'.addslashes(json_encode($formData['clients_config'])).'"
				WHERE
					`id` = '.$data['clients_id'].'
				;
			';

		$this->db->query($sql);
		return $data['clients_id'];
	}

	public function patch_clientDetailWithLogo ($formData, $fileData, $uuid) {
		$formData['clients_config'] = json_decode($formData['clients_config'], true);
		$formData['clients_config']['logo'] = $uuid;
		$formData['clients_config']['logoType'] = $fileData['file_type'];

		$sql = '
				UPDATE
					`clients`
				SET
					`name` = "'.addslashes($formData['clients_name']).'",
					`config` = "'.addslashes(json_encode($formData['clients_config'])).'"
				WHERE
					`id` = '.$formData['clients_id'].'
				;
			';

		$this->db->query($sql);
		return $formData;
	}

	public function put_clientNew ($data) {
		$sql = '
				INSERT INTO `clients` (
					`name`,
					`config`
				) VALUES (
					"'.addslashes($data['clients_name']).'",
					"'.(isset($data['config'])?addslashes(json_encode($data['config'])):addslashes(json_encode(new stdClass()))).'"
				)
				;
			';

		$this->db->query($sql);
		return $this->db->insert_id();
	}

	public function put_clientUser ($data) {
		if ($data['users_id'] == NULL) {

			$newPassword = substr(sha1(strtolower($data['users_email']) . date('Y-m-d')), 0, 8);
			$newPassHash = $this->encrypt->sha1($newPassword);
			
			$sql = '
						INSERT INTO `users` (
							`firstname`,
							`lastname`,
							`email`,
							`password`,
							`clients_id`,
							`accessConfigs_id`
						) VALUES (
							"'.addslashes($data['users_firstname']).'",
							"'.addslashes($data['users_lastname']).'",
							"'.addslashes($data['users_email']).'",
							"'.$newPassHash.'",
							'.$data['clients_id'].',
							'.$data['accessConfigs_id'].'
						)
						;
				';

			$this->db->query($sql);

			$this->load->model('messages_model', 'messages_model');
			$this->messages_model->put_newMessage(
				array(
					'messageType_id' => 1,
					'config' => array(
						'firstname' => $data['users_firstname'],
						'lastname' => $data['users_lastname'],
						'email' => $data['users_email'],
						'password' => $newPassword
					)
				)
			);
		} else {
			$sql = '
						UPDATE
							`users`
						SET
							`firstname` = "'.addslashes($data['users_firstname']).'",
							`lastname` = "'.addslashes($data['users_lastname']).'",
							`email` = "'.addslashes($data['users_email']).'",
							`accessConfigs_id` = '.$data['accessConfigs_id'].'
						WHERE
							`id` = '.$data['users_id'].'
						;
				';

			$this->db->query($sql);
		}
	}
}

/* End of file clients_model.php */
/* Location: ./application/models/clients_model.php */