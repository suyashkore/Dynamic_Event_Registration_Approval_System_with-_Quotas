<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Approver extends MY_Controller {

public function __construct() {
        parent::__construct();
        $this->require_role(['manager', 'director']);  
        $this->load->model(['Event_model', 'Registration_model', 'ApprovalBand_model', 'Approval_model']);
    }

    public function dashboard() {
        $data['events'] = $this->Event_model->all(); 
        $this->load->view('layout/header');
        $this->load->view('approver/dashboard', $data); 
        $this->load->view('layout/footer');
    }

  public function registrations_by_event($event_id) {
    $event = $this->Event_model->get($event_id);
    if (!$event) show_404();

    $rows = $this->Registration_model->by_event($event_id);
    $bands = $this->ApprovalBand_model->get_by_event($event_id);
    $myRole = $this->user['role'];

    $actionable = [];
    foreach ($rows as $r) {
      if ($r['status'] !== 'pending') continue;
      $nextBand = $this->_next_required_band($r['id'], $bands);
      if ($nextBand && $nextBand['role'] === $myRole) $actionable[] = $r + ['next_band' => $nextBand];
    }

    $data = [
      'event' => $event,
      'rows' => $actionable
    ];

    $this->load->view('layout/header');
    $this->load->view('approver/registrations_by_event', $data);
    $this->load->view('layout/footer');
  }

  public function decision($registration_id) {
    $reg = $this->Registration_model->get($registration_id);
    if (!$reg) show_404();
    if ($reg['status'] !== 'pending') show_error('Registration not pending', 400);

    $bands = $this->ApprovalBand_model->get_by_event($reg['event_id']);
    $nextBand = $this->_next_required_band($registration_id, $bands);
    if (!$nextBand) show_error('No approval band pending', 400);

    if ($nextBand['role'] !== $this->user['role']) show_error('Not your approval band', 403);

    $decision = $this->input->post('decision', TRUE);
    $remarks  = $this->input->post('remarks', TRUE);

    if (!in_array($decision, ['approved','rejected'])) show_error('Invalid decision', 400);

    $already = $this->Approval_model->has_decision_for_band($registration_id, $nextBand['id']);
    if ($already) show_error('Already decided for this band', 400);

    $this->Approval_model->create_log([
      'registration_id' => (int)$registration_id,
      'approved_by' => (int)$this->user['id'],
      'band_id' => (int)$nextBand['id'],
      'decision' => $decision,
      'remarks' => $remarks
    ]);

    if ($decision === 'rejected') {
      $this->Registration_model->set_status($registration_id, 'rejected');
      $this->session->set_flashdata('toast_message', 'Registration has been rejected.');
      $this->session->set_flashdata('toast_type', 'error');
      redirect('approver/event/'.$reg['event_id']);
    }

    $nextAfter = $this->_next_required_band($registration_id, $bands);
    if (!$nextAfter) {
      $this->Registration_model->set_status($registration_id, 'approved');
    }
    $this->session->set_flashdata('toast_message', 'Decision recorded successfully.');
    redirect('approver/event/'.$reg['event_id']);
  }

  private function _next_required_band($registration_id, $bands) {
    foreach ($bands as $b) {
      $done = $this->Approval_model->has_decision_for_band($registration_id, $b['id']);
      if (!$done) return $b;
      if ($done['decision'] === 'rejected') return null;
    }
    return null;
  }
}
