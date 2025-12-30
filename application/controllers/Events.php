<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Events extends MY_Controller {

  public function __construct() {
    parent::__construct();
    $this->require_role(['employee','external','manager','director']); 
    $this->load->model(['Event_model','Form_model','Quota_model','Registration_model','ApprovalBand_model']);
  }

  public function upcoming() {
    $data['events'] = $this->Event_model->upcoming();
    $this->load->view('layout/header');
    $this->load->view('user/events_upcoming', $data);
    $this->load->view('layout/footer');
  }

  public function register($event_id) {
    $event = $this->Event_model->get($event_id);
    if (!$event) show_404();

    $nodes = $this->Form_model->get_by_event($event_id);
    $data = ['event' => $event, 'nodes' => $nodes];

    if ($this->input->method() === 'post') {
      foreach ($nodes as $n) {
        if ((int)$n['required'] === 1) {
          $rule = 'required|trim';
          if ($n['field_type'] === 'email') $rule .= '|valid_email';
          if ($n['field_type'] === 'number') $rule .= '|numeric';
          $this->form_validation->set_rules($n['field_name'], $n['label'], $rule);
        }
      }

      if ($this->form_validation->run()) {
        $formData = [];
        foreach ($nodes as $n) {
          $formData[$n['field_name']] = $this->input->post($n['field_name'], TRUE);
        }

        $role = $this->user['role'];
        $quota = $this->Quota_model->get_quota($event_id, $role);
        $status = 'pending';

        if ($quota) {
          $used = $this->Quota_model->used_count($event_id, $role);
          if ($used >= (int)$quota['max_participants']) {
            $wantWait = $this->input->post('waitlist', TRUE);
            $status = ($wantWait === '1') ? 'waitlisted' : 'pending'; 
          }
        }

        $bands = $this->ApprovalBand_model->get_by_event($event_id);
        if (empty($bands) && $status !== 'waitlisted') $status = 'approved';

        $regId = $this->Registration_model->create([
          'event_id' => (int)$event_id,
          'user_id' => (int)$this->user['id'],
          'status' => $status,
          'form_data' => json_encode($formData, JSON_UNESCAPED_UNICODE)
        ]);

        $message = ($status === 'waitlisted')
          ? "Quota is full. You have been added to the waitlist."
          : "Registration submitted successfully!";
        $this->session->set_flashdata('toast_message', $message);
        redirect('events');
      }
    }

    $this->load->view('layout/header');
    $this->load->view('user/register', $data);
    $this->load->view('layout/footer');
  }

  public function my_registrations() {
    $data['rows'] = $this->Registration_model->my($this->user['id']);
    $this->load->view('layout/header');
    $this->load->view('user/my_registrations', $data);
    $this->load->view('layout/footer');
  }
}
