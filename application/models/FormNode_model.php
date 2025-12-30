<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FormNode_model extends CI_Model {
    public function get_by_event($event_id) {
        return $this->db->get_where('form_nodes', ['event_id' => $event_id])->result_array();
    }
    public function create($data) {
        $this->db->insert('form_nodes', $data);
    }
}