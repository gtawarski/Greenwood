<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News extends AjaxController {
	public function __construct () {
		parent::__construct();
		$this->load->model('news_model', 'news_model');
	}

	public function index () {
		echo json_encode(
				array(
					'success' => true,
					'message' => 'No data is returned by this service call'
				)
			);
	}

	public function delete_newsRecord () {
		$data = $this->input->post();
		$this->news_model->delete_newsRecord($data);

		echo json_encode(
				array(
					'success' => true
				)
			);
	}

	public function get_news () {
		$records = $this->news_model->get_news();

		echo json_encode(
				array(
					'success' => true,
					'records' => $records
				)
			);
	}

	public function get_newsRecord () {
		$data = $this->input->post();
		$record = $this->news_model->get_newsRecord($data);

		echo json_encode(
				array(
					'success' => true,
					'record' => $record
				)
			);
	}

	public function put_newsRecord () {
		$data = $this->input->post();
		$this->news_model->put_newsRecord($data);

		echo json_encode(
				array(
					'success' => true
				)
			);
	}
}

/* End of file news.php */
/* Location: ./application/controllers/ajax/news.php */