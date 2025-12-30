<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {

  public function __construct() {
    parent::__construct();
    $this->require_role(['admin']);
    $this->load->model(['Event_model','Form_model','Quota_model','ApprovalBand_model']);
  }

  public function events() {
    $data['events'] = $this->Event_model->all();
    $this->load->view('layout/header');
    $this->load->view('admin/events_list', $data);
    $this->load->view('layout/footer');
  }

  public function create_event() {
    if ($this->input->method() === 'post') {
      $this->form_validation->set_rules('name','Name','required|trim');
      $this->form_validation->set_rules('start_date','Start Date','required');
      $this->form_validation->set_rules('end_date','End Date','required');

      if ($this->form_validation->run()) {
        $id = $this->Event_model->create([
          'name' => $this->input->post('name', TRUE),
          'description' => $this->input->post('description', TRUE),
          'start_date' => $this->input->post('start_date', TRUE),
          'end_date' => $this->input->post('end_date', TRUE),
        ]);
        $this->session->set_flashdata('toast_message', 'Event Created Successfully');
        redirect('admin/events');
      }
    }

    $this->load->view('layout/header');
    $this->load->view('admin/event_create');
    $this->load->view('layout/footer');
  }

  public function edit_event($id) {
    $data['event'] = $this->Event_model->get($id);
    if (!$data['event']) show_404();

    if ($this->input->method() === 'post') {
      $this->form_validation->set_rules('name','Name','required|trim');
      if ($this->form_validation->run()) {
        $this->Event_model->update($id, [
          'name' => $this->input->post('name', TRUE),
          'description' => $this->input->post('description', TRUE),
          'start_date' => $this->input->post('start_date', TRUE),
          'end_date' => $this->input->post('end_date', TRUE),
        ]);
        $this->session->set_flashdata('toast_message', 'Event Updated Successfully');
        redirect('admin/events');
      }
    }

    $this->load->view('layout/header');
    $this->load->view('admin/event_edit', $data);
    $this->load->view('layout/footer');
  }

  public function form_nodes($event_id) {
    $data['event'] = $this->Event_model->get($event_id);
    if (!$data['event']) show_404();

    if ($this->input->method() === 'post') {
      $nodes = $this->_read_form_nodes_from_post();
      $this->Form_model->upsert_nodes($event_id, $nodes);
      $this->session->set_flashdata('toast_message', 'Form Nodes Saved Successfully');
      redirect('admin/events');
    }

    $data['nodes'] = $this->Form_model->get_by_event($event_id);

    $this->load->view('layout/header');
    $this->load->view('admin/form_nodes', $data);
    $this->load->view('layout/footer');
  }

  public function quotas($event_id) {
    $data['event'] = $this->Event_model->get($event_id);
    if (!$data['event']) show_404();

    if ($this->input->method() === 'post') {
      $roles = ['employee','external','manager','director'];
      foreach ($roles as $r) {
        $val = $this->input->post('quota_'.$r, TRUE);
        if ($val !== null && $val !== '') $this->Quota_model->set_quota($event_id, $r, (int)$val);
      }
      $this->session->set_flashdata('toast_message', 'Quotas Saved Successfully');
      redirect('admin/events');
    }

    $data['quotas'] = $this->Quota_model->get_by_event($event_id);
    $this->load->view('layout/header');
    $this->load->view('admin/quotas', $data);
    $this->load->view('layout/footer');
  }

  public function approval_bands($event_id) {
    $data['event'] = $this->Event_model->get($event_id);
    if (!$data['event']) show_404();

    if ($this->input->method() === 'post') {
      $bands = $this->_read_bands_from_post();
      $this->ApprovalBand_model->upsert_bands($event_id, $bands);
      $this->session->set_flashdata('toast_message', 'Approval Bands Saved Successfully');
      redirect('admin/events');
    }

    $data['bands'] = $this->ApprovalBand_model->get_by_event($event_id);
    $this->load->view('layout/header');
    $this->load->view('admin/approval_bands', $data);
    $this->load->view('layout/footer');
  }

  private function _read_form_nodes_from_post() {
    $labels = (array)$this->input->post('label');
    $names  = (array)$this->input->post('field_name');
    $types  = (array)$this->input->post('field_type');
    $opts   = (array)$this->input->post('field_options');
    $reqs   = (array)$this->input->post('required');

    $nodes = [];
    for ($i=0; $i<count($names); $i++) {
      if (trim($names[$i]) === '') continue;
      $nodes[] = [
        'label' => $this->security->xss_clean($labels[$i]),
        'field_name' => $this->security->xss_clean($names[$i]),
        'field_type' => $types[$i],
        'field_options' => $this->security->xss_clean($opts[$i]),
        'required' => isset($reqs[$i]) ? 1 : 0
      ];
    }
    return $nodes;
  }

  private function _read_bands_from_post() {
    $ids    = (array)$this->input->post('band_id');
    $orders = (array)$this->input->post('band_order');
    $roles  = (array)$this->input->post('role');

    $bands = [];
    for ($i=0; $i<count($orders); $i++) {
      if (trim($orders[$i]) === '' || trim($roles[$i]) === '') continue;
      $bands[] = [
        'id' => isset($ids[$i]) ? $ids[$i] : null,
        'band_order' => (int)$orders[$i],
        'role' => $roles[$i]
      ];
    }
    usort($bands, fn($a,$b) => $a['band_order'] <=> $b['band_order']);
    return $bands;
  }
}
