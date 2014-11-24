<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );


class Search extends MY_Controller {
	public function index() {
		$factual = new Factual();
		$query = new FactualQuery;
		$query->limit(3);
		$res = $factual->fetch("places", $query);
	}
}