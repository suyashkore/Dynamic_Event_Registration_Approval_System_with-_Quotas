<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    public $user = null;

    public function __construct() {
        parent::__construct();
        
        $user_id = $this->session->userdata('user_id');
        if ($user_id) {
            $this->user = $this->User_model->get($user_id);
        }
    }

    public function require_role($roles) {
        if (!$this->user) {
            redirect('login');
        }
        if (is_string($roles)) $roles = [$roles];
        if (!in_array($this->user['role'], $roles)) {
            show_error('Unauthorized access: You do not have the required role.', 403);
        }
    }
}