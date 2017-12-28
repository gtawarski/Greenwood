<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class messages_model extends CI_model {
	public function get_messageQueue() {
		$sql = '
				SELECT
					`mq`.`id` `messageId`,
					`mq`.`config` `messageConfig`,
					`mq`.`createdOn`,
					`mt`.`name` `messageType`,
					`mt`.`subject` `messageSubject`,
					`mt`.`template` `messageTemplate`
				FROM
					`messageQueue` `mq`
				JOIN
					`messageType` `mt`
				ON
					`mq`.`messageType_id` = `mt`.`id`
				WHERE
					`mq`.`sentOn` IS NULL
				ORDER BY
					`mq`.`createdOn`
				LIMIT
					20
				;
			';

		return $this->db->query($sql)->result_array();
	}

	public function patch_message($id) {
		$sql = '
				UPDATE
					`messageQueue`
				SET
					`sentOn` = NOW()
				WHERE
					`id` = '.$id.'
			';

		$this->db->query($sql);
	}

	public function put_newMessage($data) {
		$sql = '
				INSERT INTO `messageQueue` (
					`messageType_id`,
					`config`,
					`createdOn`
				) VALUES (
					'.$data['messageType_id'].',
					"'.addslashes(json_encode($data['config'])).'",
					NOW()
				)
			';

		$this->db->query($sql);
	}
}

/* End of file message_model.php */
/* Location: ./application/models/messages_model.php */