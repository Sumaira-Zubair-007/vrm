<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

	public function get_summary($vendor_id = NULL){

		return $this->db->select("
			( SELECT COUNT(DISTINCT(invoice_id))  FROM invoices WHERE vendor_id = '".$vendor_id."' ) as invoices,
			( SELECT COUNT(DISTINCT(payment_id))  FROM payments WHERE vendor_id = '".$vendor_id."' ) as payments
			")
		->get()->row();

	}






}
