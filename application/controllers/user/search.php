<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );


class Search extends CI_Controller {
	public function search_res() {
		//include_once 'Var_Dump.php';
		$this->load->library('factual/Factual');
		$this->load->model('user/search_model');
		
		$s_keyword = $this->input->post('s_keyword');
		$s_country = $this->input->post('s_country');
		$s_postcode = $this->input->post('s_postcode');

		$factual = new Factual();
		$query = new FactualQuery;
		
		//$query->field("postcode")->equal($s_postcode);
		$query->field("country")->equal($s_country);
		$query->search($s_keyword);
		//$query->limit(3);
		$res = $factual->fetch("places", $query);
		$res = $res->getData();

		foreach ($res as $i) {
			$data = array();
			$data['name'] = $i['name'];
			$data['latitude'] = $i['latitude'];
			$data['longitude'] = $i['longitude'];
			$data['address'] = $i['address'];
			$data['country'] = $i['country'];
			$data['postcode'] = $i['postcode'];
			$data['tel'] = $i['tel'];
			$data['tags'] = implode(',', $i['category_labels'][0]);
			
			if (!$this->search_model->is_res_stored($data['name'])) {
				$this->search_model->insert_res($data);
			}
		}
		
		$r = $this->search_model->search($_POST);
		
		echo(json_encode($r));
		
	}
	
	public function search_suggestion() {
		$this->load->model('user/search_model');

		$r = $this->search_model->get_res_by_name($this->input->get());
		
		$jsonArr = array();
		$jsonArr['query'] = 'Unit';
		$jsonArr['suggestions'] = array();
		if (isset($r)) {
			foreach($r as $i) {
				$temp = array(
					'value' => $i['name'],
					'data' => $i['name']
				);
				array_push($jsonArr['suggestions'], $temp);
			}
		}
		echo(json_encode($jsonArr));
	}
	
}