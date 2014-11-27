<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );


class Search extends CI_Controller {
	public function index() {
		include_once 'Var_Dump.php';
		$this->load->library('factual/Factual');
		
		$s_keyword = $this->input->post('s_keyword');
		$s_country = $this->input->post('s_country');
		$s_postcode = $this->input->post('s_postcode');
		Var_Dump::display($this->input->post('s_country'));
		break;
		$factual = new Factual();
		$query = new FactualQuery;
		
		$query->field("postcode")->equal("4101");
		$query->field("country")->equal('au');
		$query->search($s_keyword);
		//$query->limit(3);
		
		$res = $factual->fetch("places", $query);
		Var_Dump::display($res->getData());
		//echo(json_decode(array_values($res)));
		
	}
	
}