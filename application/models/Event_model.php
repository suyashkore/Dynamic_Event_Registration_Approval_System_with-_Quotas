<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event_model extends CI_Model {
    public function all() {
        return $this->db->get('events')->result_array();
    }
    public function get($id) {
        return $this->db->get_where('events', ['id' => $id])->row_array();
    }
    public function create($data) {
        $this->db->insert('events', $data);
        return $this->db->insert_id();
    }
    public function update($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('events', $data);
    }
    public function upcoming() {
        $this->db->where('start_date >=', date('Y-m-d'));
        return $this->db->get('events')->result_array();
    }
}