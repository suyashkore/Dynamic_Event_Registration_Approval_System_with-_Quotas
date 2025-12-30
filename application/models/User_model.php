<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    public function get($id) {
        return $this->db->get_where('users', ['id' => $id])->row_array();
    }
    public function find_by_email($email) {
        return $this->db->get_where('users', ['email' => $email])->row_array();
    }
}