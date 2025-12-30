<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function login() {
        if ($this->session->userdata('user')) {
            if (!$this->session->userdata('user_id')) {
                $this->session->set_userdata('user_id', $this->session->userdata('user')['id']);
            }
            redirect($this->_redirect_by_role());
        }

        if ($this->input->method() === 'post') {
            $email = $this->security->xss_clean($this->input->post('email', TRUE));
            $user = $this->User_model->find_by_email($email);
            if ($user) {
                $this->session->set_userdata('user', $user);
                $this->session->set_userdata('user_id', $user['id']);
                $this->session->set_flashdata('toast_message', 'Login Successful!');
                $this->session->set_flashdata('toast_type', 'success');
                redirect($this->_redirect_by_role());
            }
            $data['error'] = 'Invalid email.';
        }

        $this->load->view('layout/header');
        $this->load->view('auth/login', isset($data) ? $data : []);
        $this->load->view('layout/footer');
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('login');
    }

    private function _redirect_by_role() {
        $u = $this->session->userdata('user');
        if (!$u) return 'login';
        if ($u['role'] === 'admin') return 'admin';
        if (in_array($u['role'], ['manager','director'])) return 'approver';
        return 'events';
    }
}
