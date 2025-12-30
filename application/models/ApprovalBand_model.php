<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ApprovalBand_model extends CI_Model {
    public function get_by_event($event_id) {
        $this->db->where('event_id', $event_id);
        $this->db->order_by('band_order', 'ASC');
        return $this->db->get('approval_bands')->result_array();
    }
    public function create($data) {
        $this->db->insert('approval_bands', $data);
    }
    public function upsert_bands($event_id, $bands) {
        $existing = $this->db->select('id')->get_where('approval_bands', ['event_id' => $event_id])->result_array();
        $existing_ids = array_column($existing, 'id');
        $processed_ids = [];

        foreach ($bands as $b) {
            $data = ['event_id' => (int)$event_id, 'band_order' => $b['band_order'], 'role' => $b['role']];
            
            if (!empty($b['id']) && in_array($b['id'], $existing_ids)) {
                $this->db->where('id', $b['id']);
                $this->db->update('approval_bands', $data);
                $processed_ids[] = $b['id'];
            } else {
                $this->db->insert('approval_bands', $data);
            }
        }

        $to_delete = array_diff($existing_ids, $processed_ids);
        if (!empty($to_delete)) {
            $this->db->where_in('id', $to_delete)->delete('approval_bands');
        }
    }
}