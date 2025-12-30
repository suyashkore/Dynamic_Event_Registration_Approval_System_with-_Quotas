<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Form_model extends CI_Model {

  public function get_by_event($event_id) {
    return $this->db->order_by('id','ASC')->get_where('form_nodes', [
      'event_id' => (int)$event_id
    ])->result_array();
  }

  public function upsert_nodes($event_id, $nodes) {
    $this->db->where('event_id',(int)$event_id)->delete('form_nodes');
    foreach ($nodes as $n) {
      $n['event_id'] = (int)$event_id;
      $this->db->insert('form_nodes', $n);
    }
  }
}
