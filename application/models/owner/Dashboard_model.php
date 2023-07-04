<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

	public function get_summary($owner_id){

		return $this->db->select("
			( SELECT COUNT(DISTINCT(invoice_id))  FROM invoices as i 
			INNER JOIN buildings as b ON b.id = i.building_id
			WHERE b.owner_id = '".$owner_id."') as invoices,
			")
		->get()->row();

	}






}
