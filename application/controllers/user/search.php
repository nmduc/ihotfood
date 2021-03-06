<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );


class Search extends CI_Controller {
	public function search_res() {
		//include_once 'Var_Dump.php';
		$this->load->library('factual/Factual');
		$this->load->model('user/search_model');
		$this->load->model('utils/utils_model');
		
		$s_keyword 	= $this->input->post('s_keyword');
		$s_country 	= $this->input->post('s_country');
		$s_postcode = $this->input->post('s_postcode');
		$s_event 	= $this->input->post('s_event');
		
		//add supporting tags retrieved from user queries
		$keywordClean = $this->utils_model->removeCommonWords($s_keyword);
		$keywordArr = explode(" ", $keywordClean);
		
		$jsonArr = array ();
		try {
			$url = 'https://maps.googleapis.com/maps/api/place/textsearch/json?query=' . urlencode($s_keyword) . '&key=AIzaSyDnFgyjhnO9aeD29mvPtgL8tGnt5z90SZA';
			$json = file_get_contents($url);
			$res = json_decode($json, true	);
			$res = $res['results'];
			
			foreach ($res as $i) {
				$data = array();
				
				if(isset($i['name'])) {
					$data['name'] = $i['name'];
				}
				if(isset($i['geometry']['location']['lat']) && isset($i['geometry']['location']['lng'])) {
					$latlong = array($i['geometry']['location']['lat'],
							$i['geometry']['location']['lng']);
					$data['latlong'] = implode(",", $latlong);
				}
				
				if(isset($i['formatted_address'])) {
					$data['address'] = $i['formatted_address'];
				}
				if(isset($i['rating'])) {
					$data['rating'] = $i['rating'];
				}

				//if restaurant name exits
				if(isset($i['name'])) {
					$restaurant_id = null;
					//if it does not exist, insert, otherwise, get id by exact name
					if (!$this->search_model->is_res_stored($data['name'])) {
						$restaurant_id = $this->search_model->insert_res($data);
					} else {
						$restaurant_id = $this->search_model->get_res_id_by_name($data['name']);
					}
					//if tags from Places API exists, insert it
					if (isset($i['types'])) {
						//merge 2 tags array
						if (!empty($keywordArr)) {
							$tagArr = array_merge($i['types'], $keywordArr);
						}
						//insert tag 1-by-1
						foreach($tagArr as $tag) {
							if (strlen($tag) > 0){
								$tag_id = $this->search_model->is_tag_stored($tag);
								// store if tag is new, and create a link between tag and restaurant
								// if tag exists, verify if tag and restaurant is linked, if not, link them
								if ($tag_id == null) {
									$tag_id = $this->search_model->insert_tag($tag);
									$this->search_model->insert_tag_and_restaurant_link($tag_id, $restaurant_id);
								} else {
									$is_tag_and_res_linked = $this->search_model->is_tag_res_linked($tag_id, $restaurant_id);
									if ($is_tag_and_res_linked == false) {
										$this->search_model->insert_tag_and_restaurant_link($tag_id, $restaurant_id);
									}
								}
							}
						}
					}
				}
				
				//adds additional detail
				if(isset($i['photos'])) {
					$data['photoRef'] = $i['photos'][0]['photo_reference'];
				}
				
				if(isset($i['name'])) {
					$data['place_id'] = $i['place_id'];
				}
				
				$data['restaurant_id'] = $restaurant_id;
				
				//enrich restaurant information
				//$this->enrich_detail_res($restaurant_id, $i['place_id']);
				
				//push to jsonArr for displaying
				array_push($jsonArr, $data);
			}
		} catch(Exception $e) {
			echo $e;
		} finally {
			//$r = $this->search_model->search($this->input->post());
			$result = json_encode($jsonArr);
			echo($result);
		}	
	}
	
	public function search_suggestion() {
		$this->load->model('user/search_model');
		$query = $this->input->get('query');
		$url = 'https://maps.googleapis.com/maps/api/place/queryautocomplete/json?key=AIzaSyDnFgyjhnO9aeD29mvPtgL8tGnt5z90SZA&input=' . urlencode($query);
		$json = file_get_contents($url);
		$res = json_decode($json, true	);
		$res = $res['predictions'];
		
		$jsonArr = array();
		$jsonArr['query'] = 'Unit';
		$jsonArr['suggestions'] = array();
		if (isset($res)) {
			foreach($res as $i) {
				$temp = array(
					'value' => $i['description'],
					'data' => $i['description']
				);
				array_push($jsonArr['suggestions'], $temp);
			}
		}
		echo(json_encode($jsonArr));
	}
	
	public function get_place_photo() {
		$photoRef = $this->input->post('photoRef');
		$url = 'https://maps.googleapis.com/maps/api/place/photo?maxwidth=400&key=AIzaSyDnFgyjhnO9aeD29mvPtgL8tGnt5z90SZA&photoreference=' . $photoRef;
		$json = file_get_contents($url);
		$res = json_decode($json, true	);
		echo($res);
	}
	
	public function search_postcode_suggestion() {
		$this->load->model('user/search_model');
		$r = $this->search_model->get_postcode_for_suggestion($this->input->get());
	
		$jsonArr = array();
		$jsonArr['query'] = 'Unit';
		$jsonArr['suggestions'] = array();
		
		if (isset($r)) {
			foreach($r as $i) {
				$temp = array(
						'value' => $i['postcode'],
						'data' => $i['postcode']
				);
				array_push($jsonArr['suggestions'], $temp);
			}
		}
		echo(json_encode($jsonArr));
	}
	
	public function enrich_detail_res($restaurant_id, $place_id){
		$this->load->model("restaurant/review_model");
		$this->load->model( 'restaurant/restaurant_model' );
		
// 		$recent_updated_time = $this->restaurant_model->get_updated_time_for_restaurant($restaurant_id);
// 		$today = date('Y-m-d H:i:s');
		
		
// 		$date1 = new DateTime("2014-9-12");
// 		$date2 = new DateTime("2014-6-12");
// 		var_dump($recent_updated_time);
// 		break;
		$paramArr = $this->uri->uri_to_assoc(4);
		$restaurant_id = $paramArr['restaurantid'];
		$place_id = $paramArr['placeid'];

		$url = 'https://maps.googleapis.com/maps/api/place/details/json?key=AIzaSyDnFgyjhnO9aeD29mvPtgL8tGnt5z90SZA&placeid=' . $place_id;
		$json = file_get_contents($url);
		$res = json_decode($json, true	);
		
		if (array_key_exists('reviews', $res['result'])) {
			$reviewArr = $res['result']['reviews'];
			foreach($reviewArr as $r) {
				$content = $r['text'];
				$rating = $r['rating'];
				$new_review_id = $this->review_model->create_review_for_search($restaurant_id, 'A review',
						$content, $rating);
			}
		}
		$data = null;
		if (array_key_exists('address_components', $res['result'])) {
			$addressArr = $res['result']['address_components'];
			if (count($addressArr) > 3) {
				$data["address_number"] = $addressArr[0]["long_name"];
				$data["address_street"] = $addressArr[1]["long_name"];
				$data["address_city"] = $addressArr[2]["long_name"];
				$data["address_country"] = $addressArr[3]["long_name"];
				$data["zipcode"] = $addressArr[4]["long_name"];
			}
		}
		if (array_key_exists('international_phone_number', $res['result'])) {
			$data["phone_number"] = $res['result']['international_phone_number'];
		}
		if (array_key_exists('website', $res['result'])) {
			$data["website"] = $res['result']['website'];
		}
		$this->restaurant_model->update_restaurant_for_search($restaurant_id, $data);
	}
	
}