<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registration_model extends CI_Model {
    public function by_event($event_id) {
        $this->db->select('registrations.*, users.name as user_name, users.email, users.role as user_role');
        $this->db->from('registrations');
        $this->db->join('users', 'users.id = registrations.user_id');
        $this->db->where('registrations.event_id', $event_id);
        return $this->db->get()->result_array();
    }
    public function get($id) {
        return $this->db->get_where('registrations', ['id' => $id])->row_array();
    }
    public function set_status($id, $status) {
        $this->db->where('id', $id);
        $this->db->update('registrations', ['status' => $status]);
    }
    public function create($data) {
        $this->db->insert('registrations', $data);
        return $this->db->insert_id();
    }
    public function count_by_event_role($event_id, $role) {
        $this->db->where('event_id', $event_id);
        $this->db->where('status !=', 'rejected'); 
        return $this->db->count_all_results('registrations');
    }
    public function my($user_id) {
        $this->db->select('registrations.*, events.name as event_name, events.start_date, events.end_date');
        $this->db->from('registrations');
        $this->db->join('events', 'events.id = registrations.event_id');
        $this->db->where('registrations.user_id', $user_id);
        return $this->db->get()->result_array();
    }
}