<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class files_model extends CI_model {

	public function delete_file($data) {
		$currentUser = $this->session->userdata('user');

		$sql = '
				UPDATE
					`files`
				SET
					`isDeleted` = 1,
					`isDeletedBy_id` = '.$currentUser['users_id'].',
					`isDeletedOn` = NOW()
				WHERE
					`id` = '.$data['file']['id'].'
		';

		$this->db->query($sql);
	}

	public function get_brokers ($data) {
		$sql = '
				SELECT
					`b`.`id` `brokers_id`,
					`b`.`name` `brokers_name`,
					if(`fb`.`id` IS NULL,false,true) `brokers_hasAccess`
				FROM
					`brokers` `b`
				LEFT JOIN
					`files_brokers` `fb`
				ON
					`b`.`id` = `fb`.`brokers_id` AND
					`fb`.`files_id` = '.$data['files_id'].'
				WHERE
					`b`.`isActive` = 1 AND
					`b`.`isDeleted` = 0
				ORDER BY
					`b`.`name`
		';

		return $this->db->query($sql)->result_array();
	}

	public function get_files ($data) {
		$user = $this->session->userdata('user');

		$sql = '
				SELECT
					`f`.`id` `files_id`,
					`f`.`name` `files_name`,
					`ft`.`id` `fileTags_id`,
					`ft`.`name` `fileTags_name`,
					`ft`.`fontAwesome` `fileTags_fontAwesome`,
					DATE_FORMAT(`fv`.`timestamp`, "%m/%d/%Y %h:%i %p") `files_date`,
					`c`.`name` `clients_name`,
					`fv`.`hash` `fileUUID`
				FROM
					`files` `f`
				JOIN
					`fileVersions` `fv`
				ON
					`f`.`id` = `fv`.`files_id` AND
					`fv`.`isCurrent` = 1
				JOIN
					`clients` `c`
				ON
					`f`.`clients_id` = `c`.`id`
				JOIN
					`fileTags` `ft`
				ON
					`f`.`fileTags_id` = `ft`.`id`
				'
					.($user['brokers_id'] > 0?'JOIN `files_brokers` `fb` ON `f`.`id` = `fb`.`files_id` AND `fb`.`brokers_id` = ' . $user['brokers_id']:null).
				'
				WHERE
					`f`.`isDeleted` = 0
					'.($data['clients_id'] > 0?' AND `f`.`clients_id` = '.$data['clients_id']:NULL).'
					'.($data['fileTags_id'] > 0?' AND `f`.`fileTags_id` = '.$data['fileTags_id']:NULL).'
				ORDER BY
					`ft`.`name`,
					`c`.`name`,
					`f`.`name`
		';

		return $this->db->query($sql)->result_array();
	}

	public function get_file($data) {
		$sql = '
				SELECT
					*
				FROM
					`files`
				WHERE
					`id` = '.$data['files_id'].'
		';

		return $this->db->query($sql)->row_array();
	}

	public function get_fileTypesExtensions() {
				$sql = '
								SELECT
										`extension`
								FROM
										`fileTypes`
								WHERE
										`isActive` = 1 AND
										`isDeleted` = 0
								ORDER BY
										`name`;
				';

				return $this->db->query($sql)->result_array();
		}

	public function get_fileDownload ($files_id) {
		$sql = '
				SELECT
					`f`.`name`,
					`fv`.`hash`,
					`ft`.`mimeType`,
					`ft`.`forceDownload`
				FROM
					`files` `f`
				JOIN
					`fileVersions` `fv`
				ON
					`f`.`id` = `fv`.`files_id`
				JOIN
					`fileTypes` `ft`
				ON
					`f`.`fileTypes_id` = `ft`.`id`
				WHERE
					`f`.`id` = '.$files_id.'
				;
		';

		return $this->db->query($sql)->row_array();
	}

	public function get_filterClients () {
		$sql = 'CREATE TEMPORARY TABLE `tmpClients` (
					`id` INT(10) UNIQUE,
					`name` CHAR(64)
				);';
		
		$this->db->query ($sql);

		$sql = 'INSERT INTO `tmpClients` (`id`, `name`) VALUES (0, "--SELECT A CLIENT--");';

		$this->db->query ($sql);

		$user = $this->session->userdata('user');

		$sql = 'INSERT IGNORE INTO `tmpClients` (`id`, `name`) SELECT `id`, `name` FROM `clients` WHERE `isActive` = 1 AND `isDeleted` = 0 ORDER BY `name`;';
		$this->db->query($sql);

		return $this->db->query('SELECT `id` `clients_id`, `name` `clients_name` FROM `tmpClients` ORDER BY `name`;')->result_array();
	}

	public function get_filterTags() {
		$sql = 'SELECT 0 `id`, "--ALL FILE TYPES--" `name` UNION SELECT `id`, `name` FROM `fileTags` ORDER BY `name`;';

		return $this->db->query($sql)->result_array();
	}

	public function get_fileTags() {
		$sql = 'SELECT `id`, `name` FROM `fileTags` ORDER BY `name`;';

		return $this->db->query($sql)->result_array();
	}

	public function patch_file($data) {
		$sql = '
					UPDATE
						`files`
					SET
						`fileTags_id` = '.$data['file']['fileTags_id'].'
					WHERE
						`id` = '.$data['file']['id'].'
				';

		$this->db->query($sql);

		$this->db->query('DELETE FROM `files_brokers` WHERE `files_id` = '.$data['file']['id'].';');
		foreach ($data['brokers'] as $broker) {
			if ($broker['brokers_hasAccess']) {
				$this->db->query('INSERT INTO `files_brokers` (`files_id`, `brokers_id`) VALUES ('.$data['file']['id'].','.$broker['brokers_id'].');');
			}
		}
	}

	 public function put_file($data, $clients_id, $fileTags_id, $hash) {
		$extension = substr($data['file_ext'], 1);
		$filename = $data['client_name'];

		$sql = '
				INSERT INTO
						`files` (
								`name`,
								`fileTypes_id`,
								`fileTags_id`,
								`clients_id`
						)
				VALUES (
								"'.addslashes($filename).'",
								(SELECT `id` FROM `fileTypes` WHERE `extension` = "'.$extension.'" LIMIT 1),
								'.$fileTags_id.',
								'.$clients_id.'
						);
		';

		$this->db->query($sql);
		$files_id = $this->db->insert_id();

		$sql = '
				INSERT INTO
						`fileVersions` (
								`hash`,
								`files_id`
						)
				VALUES (
								"'.$hash.'",
								'.$files_id.'
						);
		';

		$this->db->query($sql);
	}
}

/* End of file files_model.php */
/* Location: ./application/models/files_model.php */
