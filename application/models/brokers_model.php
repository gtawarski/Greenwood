<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class brokers_model extends CI_model {
	public function delete_brokerUser ($id) {
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

	public function delete_brokerDetailById ($id) {
		$currentUser = $this->session->userdata('user');

		$sql = '
				UPDATE
					`brokers`
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

		$sql = 'SELECT * FROM `brokers` WHERE `id` ='.$id.';';

		$brokers = $this->db->query($sql)->row_array();
		$brokers['config'] = json_decode('config', true);

		unset($brokers['config']['logo']);
		unset($brokers['config']['logoType']);

		$sql = '
				UPDATE
					`brokers`
				SET
					`config` = "'.json_encode($brokers['config']).'"
				WHERE
					`id` = '.$id.'
			;
		';

		$this->db->query($sql);
	}

	public function get_allBrokers() {
		$sql = '
					SELECT
						`b`.`id` `brokers_id`,
						`b`.`name` `brokers_name`
					FROM
						`brokers` `b`
					WHERE
						`b`.`isActive` = 1 AND
						`b`.`isDeleted` = 0
					ORDER BY
						`b`.`name`
					;
		';

		$data = array('records' => array());
		$results = $this->db->query($sql)->result_array();

		$data['records'] = $results;

		return $data;
	}

	public function get_brokers($filterNameSearch, $currentPage) {
		$sql = '
					SELECT SQL_CALC_FOUND_ROWS
						`c`.`id` `brokers_id`,
						`c`.`name` `brokers_name`,
						`c`.`config` `brokers_config`,
						UNIX_TIMESTAMP() `brokers_datetime`
					FROM
						`brokers` `c`
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
			$results[$i]['brokers_config'] = json_decode($results[$i]['brokers_config']);
		}

		$data['records'] = $results;

		$page_row = $this->db->query('SELECT FOUND_ROWS() `itemCount`;')->row_array();
		$data['itemCount'] = $page_row['itemCount'];

		return $data;
	}

	public function get_brokerDetailById ($id) {
		$sql = '
				SELECT
					`c`.`id` `brokers_id`,
					`c`.`name` `brokers_name`,
					`c`.`config` `brokers_config`
				FROM
					`brokers` `c`
				WHERE
					`c`.`id` = '.$id.'
				;
		';

		return $this->db->query($sql)->row_array();
	}

	public function get_brokerUsers ($data) {
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
					`u`.`brokers_id` = '.$data['brokers_id'].' AND
					(`u`.`isActive` = 1 OR `u`.`isInvitation` = 1) AND
					`u`.`isDeleted` = 0 AND
					`u`.`isDeleted` = 0 AND
					`u`.`accessConfigs_id` IN (5,6)
				ORDER BY
					`u`.`firstname`,
					`u`.`lastname`
		';

		return $this->db->query($sql)->result_array();
	}

	public function patch_brokerDetail ($data) {
		$data['brokers_config'] = json_decode($data['brokers_config'], true);

		$sql = '
				UPDATE
					`brokers`
				SET
					`name` = "'.addslashes($data['brokers_name']).'",
					`config` = "'.addslashes(json_encode($formData['brokers_config'])).'"
				WHERE
					`id` = '.$data['brokers_id'].'
				;
			';

		$this->db->query($sql);
		return $data['brokers_id'];
	}

	public function patch_brokerDetailWithLogo ($formData, $fileData, $uuid) {
		$formData['brokers_config'] = json_decode($formData['brokers_config'], true);
		$formData['brokers_config']['logo'] = $uuid;
		$formData['brokers_config']['logoType'] = $fileData['file_type'];

		$sql = '
				UPDATE
					`brokers`
				SET
					`name` = "'.addslashes($formData['brokers_name']).'",
					`config` = "'.addslashes(json_encode($formData['brokers_config'])).'"
				WHERE
					`id` = '.$formData['brokers_id'].'
				;
			';

		$this->db->query($sql);
		return $formData;
	}

	public function put_brokerNew ($data) {
		$sql = '
				INSERT INTO `brokers` (
					`name`,
					`config`
				) VALUES (
					"'.addslashes($data['brokers_name']).'",
					"'.(isset($data['config'])?addslashes(json_encode($data['config'])):addslashes(json_encode(new stdClass()))).'"
				)
				;
			';

		$this->db->query($sql);
		return $this->db->insert_id();
	}

	public function put_brokerUser ($data) {
		if ($data['users_id'] == NULL) {

			$newPassword = substr(sha1(strtolower($data['users_email']) . date('Y-m-d')), 0, 8);
			$newPassHash = $this->encrypt->sha1($newPassword);
			
			$sql = '
						INSERT INTO `users` (
							`firstname`,
							`lastname`,
							`email`,
							`password`,
							`brokers_id`,
							`accessConfigs_id`
						) VALUES (
							"'.addslashes($data['users_firstname']).'",
							"'.addslashes($data['users_lastname']).'",
							"'.addslashes($data['users_email']).'",
							"'.$newPassHash.'",
							'.$data['brokers_id'].',
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

/* End of file brokers_model.php */
/* Location: ./application/models/brokers_model.php */