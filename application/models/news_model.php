<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class news_model extends CI_model {
	public function delete_newsRecord($data) {
		$user = $this->session->userdata('user');

		$sql = '
				UPDATE
					`news`
				SET
					`isActive` = 0,
					`isDeleted` = 1,
					`isDeletedOn` = NOW(),
					`isDeletedBy_id` = '.$user['users_id'].'
				WHERE
					`id` = '.$data['id'].'
				;
		';

		return $this->db->query($sql);
	}

	public function get_news() {
		$sql = '
				SELECT
					*
				FROM
					`news`
				WHERE
					`isActive` = 1 AND
					`isDeleted` = 0 AND
					`timestamp` >= NOW() - INTERVAL 30 DAY
				ORDER BY
					`timestamp` DESC;
		';

		return $this->db->query($sql)->result_array();
	}

	public function get_newsRecord($data) {
		$sql = '
				SELECT
					*
				FROM
					`news`
				WHERE
					`id` = '.$data['id'].'
				;
		';

		return $this->db->query($sql)->row_array();
	}

	public function put_newsRecord($data) {
		$user = $this->session->userdata('user');

		if ($data['id'] == NULL) {
			$sql = '
					INSERT INTO
						`news` (
							`title`,
							`subtitle`,
							`content`,
							`author_id`,
							`timestamp`
						) VALUES (
							"'.addslashes($data['title']).'",
							"'.addslashes($data['subtitle']).'",
							"'.addslashes($data['content']).'",
							"'.$user['users_id'].'",
							NOW()
						)
					;
			';

			$this->db->query($sql);
		} else {
			$sql = '
				UPDATE
					`news`
				SET
					`title` = "'.addslashes($data['title']).'",
					`subtitle` = "'.addslashes($data['subtitle']).'",
					`content` = "'.addslashes($data['content']).'"
				WHERE
					`id` = '.$data['id'].'
				;
			';

			$this->db->query($sql);
		}
	}
}

/* End of file news_model.php */
/* Location: ./application/models/news_model.php */