<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class home_model extends CI_model {
	public function get_news () {
		$sql = '
				SELECT
					`n`.`title` `news_title`,
					`n`.`subtitle` `news_subtitle`,
					`n`.`content` `news_content`,
					DATE_FORMAT(`n`.`timestamp`, "%b %e, %Y - %l:%i %p") `news_date`,
					`u`.`firstname` `users_firstname`,
					`u`.`lastname` `users_lastname`
				FROM
					`news` `n`
				JOIN
					`users` `u`
				ON
					`n`.`author_id` = `u`.`id`
				WHERE
					`n`.`isActive` = 1 AND
					`n`.`isDeleted` = 0 AND
					`n`.`timestamp` >= NOW() - INTERVAL 30 DAY
				ORDER BY
					`n`.`timestamp` DESC
		';

		return $this->db->query($sql)->result_array();
	}

	public function patch_account($data, $updateEmail = false, $updateFirstname = false, $updateLastname = false, $updatePassword = false) {
		$sql = '
				UPDATE
					`users`
				SET
					'.($updateEmail ? '`email` = "'.$data['email'].'",' : NULL).'
					'.($updateFirstname ? '`firstname` = "'.$data['firstname'].'",' : NULL).'
					'.($updateLastname ? '`lastname` = "'.$data['lastname'].'",' : NULL).'
					'.($updatePassword ? '`password` = "'.$this->encrypt->sha1($data['newPassword']).'",' : NULL).'
					`id` = '.$data['id'].'
				WHERE
					`id` = '.$data['id'].'
				;
		';

		$this->db->query($sql);
		if ($this->db->affected_rows() == 1) {
			unset ($data['newPassword']);
			unset ($data['confirmNewPassword']);



			return array(
						'success' => true,
						'account' => $data,
						'errorMessage' => null
					);
		} else {
			unset ($data['newPassword']);
			unset ($data['confirmNewPassword']);

			return array(
						'success' => false,
						'account' => $data,
						'errorMessage' => 'There was an error updating your account.  If the problem persists, contact support!',
					);
		}
	}

	public function get_recentFiles ($clients_id) {
		$sql = '
				SELECT
					`f`.`id` `files_id`,
					`f`.`name` `filesName`,
					`ft`.`id` `fileTags_id`,
					`ft`.`name` `fileTags_name`,
					`ft`.`fontAwesome` `fileTags_fontAwesome`,
					DATE_FORMAT(`fv`.`timestamp`, "%m/%d/%Y %h:%i %p") `files_date`,
					`c`.`name` `clientsName`,
					DATE_FORMAT(`fv`.`timestamp`, "%m/%d/%Y - %h:%i %p") `lastUpdated`
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
					`c`.`id` = `f`.`clients_id`
				JOIN
					`fileTags` `ft`
				ON
					`f`.`fileTags_id` = `ft`.`id`
				WHERE
					`f`.`isDeleted` = 0 AND 
					`c`.`isDeleted` = 0 AND
					`c`.`isActive` = 1
		';

		if ($clients_id > 0) {
			$sql .= ' AND `f`.`clients_id` = '.$clients_id;
		}

		$sql .= '
				ORDER BY
					`fv`.`timestamp` DESC
				LIMIT
					5
				;
		';

		return $this->db->query($sql)->result_array();
	}
}

/* End of file home_model.php */
/* Location: ./application/models/home_model.php */