<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class system_model extends CI_model {
	public function get_userByIdAndPasshash ($id, $passhash) {
		$sql = '
				SELECT
					`id`
				FROM
					`users`
				WHERE
					`id` = '.$id.' AND
					`password` = "'.$passhash.'"
				;
		';

		return $this->db->query($sql)->num_rows();
	}

	public function get_userEmailById ($id) {
		$sql = '
			SELECT
				`email`
			FROM
				`users`
			WHERE
				`id` = "'.$id.'" AND
				`isActive` = 1 AND
				`isDeleted` = 0
			LIMIT 1;
		';

		return $this->db->query($sql)->row_array();
	}

	public function get_userByEmail ($email) {
		$email = strtolower($email);

		$sql = '
			SELECT
				*
			FROM
				`users`
			WHERE
				`email` = "'.$email.'" AND
				`isActive` = 1 AND
				`isDeleted` = 0
			LIMIT 1;
		';

		return $this->db->query($sql)->row_array();
	}

	public function get_userByEmailAndPassword ($email, $password) {
		$email = strtolower($email);
		$passHash = $this->encrypt->sha1($password);

		$sql = '
			SELECT
				`u`.`id` `users_id`,
				`u`.`firstname` `users_firstname`,
				`u`.`lastname` `users_lastname`,
				`u`.`email` `users_email`,
				`u`.`clients_id` `clients_id`,
				`c`.`name` `clients_name`,
				`u`.`brokers_id` `brokers_id`,
				`b`.`name` `brokers_name`,
				`ac`.`id` `accessConfigs_id`,
				`ac`.`name` `accessConfigs_name`,
				`ac`.`config` `accessConfigs_config`
			FROM
				`users` `u`
			JOIN
				`accessConfigs` `ac`
			ON
				`u`.`accessConfigs_id` = `ac`.`id`
			LEFT JOIN
				`brokers` `b`
			ON
				`u`.`brokers_id` = `b`.`id`
			LEFT JOIN
				`clients` `c`
			ON
				`u`.`clients_id` = `c`.`id`
			WHERE
				`u`.`email` = "'.$email.'" AND
				`u`.`password` = "'.$passHash.'" AND
				`u`.`isDeleted` = 0
			LIMIT
				1
			;
		';

		return $this->db->query($sql)->row_array();
	}

	public function set_passhashById ($id, $passhash) {
		$sql = '
			UPDATE `users` SET `password` = "'.$passhash.'" WHERE `id` = '.$id.';
		';

		$this->db->query($sql);
	}

	public function set_passwordByIdAndPasshash ($id, $passhash, $email, $password) {
		$email = strtolower($email);
		$newPassHash = $this->encrypt->sha1($password);

		$sql = '
				UPDATE `users` SET `password` = "'.$newPassHash.'" WHERE `id` = '.$id.' AND `password` = "'.$passhash.'";
		';

		$this->db->query($sql);
	}

	public function put_activation ($data) {
		$sql = '
				SELECT
					*
				FROM
					`users`
				WHERE
					`isInvitation` = 1 AND
					`email` = "'.$data['email'].'" AND
					`password` = "'.trim($data['registration']).'"
				;
			';

		$user = $this->db->query($sql)->row_array();

		if ($user == null) {
			return array ('success' => false, 'message' => 'Could not find invitation.  Contact support!');
		} else {
			$sql = '
						UPDATE
							`users`
						SET
							`isActive` = 1,
							`isInvitation` = 0,
							`password` = "'.$this->encrypt->sha1($data['password']).'"
						WHERE
							`id` = '.$user['id'].'
				';

			$this->db->query($sql);

			return array ('success' => true);
		}
	}

	public function put_resetPassword ($data) {
		$sql = '
			SELECT
				*
			FROM
				`users`
			WHERE
				`email` = "'.$data['email'].'" AND
				`isActive` = 1 AND
				`isDeleted` = 0
			LIMIT
				1
			;
		';

		$result = $this->db->query($sql)->row_array();

		if (isset($result['id']) && $result['id'] > 0) {
			$newPassword = substr(sha1(strtolower($data['email']) . date('Y-m-d')), 0, 8);
			$newPassHash = $this->encrypt->sha1($newPassword);
			
			$sql = '
					UPDATE
						`users`
					SET
						`password` = "'.$newPassHash.'"
					WHERE
						`id` = '.$result['id'].'
			';

			$this->db->query($sql);

			$this->load->model('messages_model', 'messages_model');
			$this->messages_model->put_newMessage(
				array(
					'messageType_id' => 2,
					'config' => array(
						'firstname' => $result['firstname'],
						'lastname' => $result['lastname'],
						'email' => $result['email'],
						'password' => $newPassword
					)
				)
			);

			return array('success' => true);
		} else {
			return array('success' => false);
		}
	}
}

/* End of file system_model.php */
/* Location: ./application/models/system_model.php */
