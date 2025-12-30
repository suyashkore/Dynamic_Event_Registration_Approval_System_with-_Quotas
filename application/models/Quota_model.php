<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quota_model extends CI_Model {
    public function get_limit($event_id, $role) {
        $row = $this->db->get_where('quotas', ['event_id' => $event_id, 'role' => $role])->row_array();
        return $row ? $row['max_participants'] : 0;
    }
    public function create($data) {
        $this->db->insert('quotas', $data);
    }
    public function get_by_event($event_id) {
        return $this->db->get_where('quotas', ['event_id' => $event_id])->result_array();
    }
    public function set_quota($event_id, $role, $limit) {
        $row = $this->db->get_where('quotas', ['event_id' => $event_id, 'role' => $role])->row_array();
        if ($row) {
            $this->db->where('id', $row['id']);
            $this->db->update('quotas', ['max_participants' => $limit]);
        } else {
            $this->db->insert('quotas', ['event_id' => $event_id, 'role' => $role, 'max_participants' => $limit]);
        }
    }
    public function get_quota($event_id, $role) {
        return $this->db->get_where('quotas', ['event_id' => $event_id, 'role' => $role])->row_array();
    }
    public function used_count($event_id, $role) {
        $this->db->from('registrations');
        $this->db->join('users', 'users.id = registrations.user_id');
        $this->db->where('registrations.event_id', $event_id);
        $this->db->where('users.role', $role);
        $this->db->where_in('registrations.status', ['pending', 'approved']);
        return $this->db->count_all_results();
    }
}