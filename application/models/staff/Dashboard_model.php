<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

	public function get_summary(){

		return $this->db->select("
			( SELECT COUNT(DISTINCT(invoice_id))  FROM invoices ) as invoices,
			( SELECT COUNT(DISTINCT(payment_id))  FROM payments ) as payments
			")
		->get()->row();

	}






}
