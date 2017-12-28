<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class accounts_model extends CI_model {
	public function delete_user ($id) {
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

	public function get_users () {
		$currentUser = $this->session->userdata('user');
		if ($currentUser['accessConfigs_id'] == 1) {
			$accessArray = array(1,2,3,4);
		} else {
			$accessArray = array(2,3,4);
		}

		$sql = '
				SELECT
					`u`.`id` `users_id`,
					`u`.`firstname` `users_firstname`,
					`u`.`lastname` `users_lastname`,
					`u`.`email` `users_email`,
					`u`.`isActive` `users_isActive`,
					`ac`.`id` `accessConfigs_id`,
					`ac`.`name` `accessConfigs_name`
				FROM
					`users` `u`
				JOIN
					`accessConfigs` `ac`
				ON
					`u`.`accessConfigs_id` = `ac`.`id`
				WHERE
					`u`.`id` != '.$currentUser['users_id'].' AND
					(`u`.`isActive` = 1 OR `u`.`isInvitation` = 1) AND
					`u`.`isDeleted` = 0 AND
					`u`.`isDeleted` = 0 AND
					`u`.`accessConfigs_id` IN('.implode(',',$accessArray).')
				ORDER BY
					`u`.`firstname`,
					`u`.`lastname`
		';

		return $this->db->query($sql)->result_array();
	}

	public function put_user ($data) {
		if ($data['users_id'] == NULL) {

			$newPassword = substr(sha1(strtolower($data['users_email']) . date('Y-m-d')), 0, 8);
			$newPassHash = $this->encrypt->sha1($newPassword);
			
			$sql = '
						INSERT INTO `users` (
							`firstname`,
							`lastname`,
							`email`,
							`password`,
							`accessConfigs_id`
						) VALUES (
							"'.addslashes($data['users_firstname']).'",
							"'.addslashes($data['users_lastname']).'",
							"'.addslashes($data['users_email']).'",
							"'.$newPassHash.'",
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
			if ($data['users_isActive'] == 0) {
				$newPassword = substr(sha1(strtolower($data['users_email']) . date('Y-m-d')), 0, 8);
				$newPassHash = $this->encrypt->sha1($newPassword);

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
			}

			$sql = '
						UPDATE
							`users`
						SET
							`firstname` = "'.addslashes($data['users_firstname']).'",
							`lastname` = "'.addslashes($data['users_lastname']).'",
							`email` = "'.addslashes($data['users_email']).'",
							`accessConfigs_id` = '.$data['accessConfigs_id'].'
							'.($data['users_isActive'] == 0?',`password` = "'.$newPassHash.'"':NULL).'
						WHERE
							`id` = '.$data['users_id'].'
						;
				';

			$this->db->query($sql);
		}
	}

	public function put_userInvitationRequest($data) {
		$newPassword = substr(sha1(strtolower($data['users_email']) . date('Y-m-d')), 0, 8);
		$newPassHash = $this->encrypt->sha1($newPassword);

		$sql = '
					UPDATE
						`users`
					SET
						`password` = "'.$newPassHash.'"
					WHERE
						`id` = '.$data['users_id'].'
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
	}
}

/* End of file accounts_model.php */
/* Location: ./application/models/accounts_model.php */