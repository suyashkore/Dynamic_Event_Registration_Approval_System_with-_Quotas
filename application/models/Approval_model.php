<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Approval_model extends CI_Model {
    public function has_decision_for_band($reg_id, $band_id) {
        $this->db->where('registration_id', $reg_id);
        $this->db->where('band_id', $band_id);
        return $this->db->get('approvals')->row_array();
    }
    public function create_log($data) {
        $this->db->insert('approvals', $data);
    }
}