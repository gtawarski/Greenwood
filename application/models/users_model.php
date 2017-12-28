<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class users_model extends CI_model {
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
	
	public function get_users($filterNameSearch, $currentPage, $accessConfigs_id) {
		$sql = '
					SELECT SQL_CALC_FOUND_ROWS
						`u`.`id` `users_id`,
						`u`.`firstname` `firstname`,
						`u`.`lastname` `lastname`,
						`u`.`email` `email`,
						`ac`.`name` `access`,
						`b`.`name` `broker_name`,
						`c`.`name` `client_name`,
						(
							CASE
								WHEN `u`.`isActive` = 1 THEN "Active"
								WHEN `u`.`isInvitation` = 1 THEN "Invitation"
							END
						) `status`
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
						'.($accessConfigs_id != 1?'`u`.`accessConfigs_id` != 1 AND ':'').'
						(`u`.`isActive` = 1 OR `u`.`isInvitation` = 1) AND 
						`u`.`isDeleted` = 0 AND
						`ac`.`isActive` = 1
					ORDER BY
						`u`.`lastname`
					LIMIT
						50
					OFFSET
						'.(($currentPage - 1)* 50).'
					;
		';

		$data = array('records' => array());
		$results = $this->db->query($sql)->result_array();

		$data['records'] = $results;

		$page_row = $this->db->query('SELECT FOUND_ROWS() `itemCount`;')->row_array();
		$data['itemCount'] = $page_row['itemCount'];

		return $data;
	}

	public function get_userDetailById ($id) {
		$sql = '
				SELECT
					`u`.`id` `users_id`,
					`u`.`firstname` `users_firstname`,
					`u`.`lastname` `users_lastname`,
					`u`.`email` `users_email`,
					`u`.`accessConfigs_id` `accessConfigs_id`,
					`u`.`brokers_id` `brokers_id`,
					`u`.`clients_id` `clients_id`
				FROM
					`users` `u`
				WHERE
					`u`.`id` = '.$id.'
				;
		';

		return $this->db->query($sql)->row_array();
	}
	
	public function get_userDetailByEmail($data) {
		$sql = '
				SELECT
					`u`.`id` `users_id`,
					`u`.`firstname` `users_firstname`,
					`u`.`lastname` `users_lastname`,
					`u`.`email` `users_email`,
					`u`.`accessConfigs_id` `accessConfigs_id`,
					`u`.`brokers_id` `brokers_id`,
					`u`.`clients_id` `clients_id`
				FROM
					`users` `u`
				WHERE
					`u`.`email` = "'.trim($data['users_email']).'" AND
					`u`.`isDeleted` = 0
				;
		';
		
		return $this->db->query($sql)->row_array();
	}
	
	public function put_userNew ($data) {
		//$newPassword = $data['users_password'];
		//$newPassHash = $this->encrypt->sha1($newPassword);
		$newPassHash = sha1(trim($data['users_email']).date('YmdHis'));
			
		$sql = '
					INSERT INTO `users` (
						`firstname`,
						`lastname`,
						`email`,
						`password`,
						`brokers_id`,
						`clients_id`,
						`accessConfigs_id`
					) VALUES (
						"'.addslashes($data['users_firstname']).'",
						"'.addslashes($data['users_lastname']).'",
						"'.addslashes($data['users_email']).'",
						"'.$newPassHash.'",
						'.$data['brokers_id'].',
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
							'password' => $newPassHash
					)
			)
		);
	}
}

/* End of file users_model.php */
/* Location: ./application/models/users_model.php */
