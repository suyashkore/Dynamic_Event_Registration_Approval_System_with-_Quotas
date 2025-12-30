<?php
class CI_Controller {

    public $config;
    public $hooks;
    public $log;
    public $utf8;
    public $router;
    public $output;
    public $security;
    public $input;
    public $lang;
    public $db;
    public $session;
    public $form_validation;

    public function __construct() {
        $this->config = get_config();
        $this->hooks = &load_class('Hooks', 'core');
        $this->log = &load_class('Log', 'core');
        $this->utf8 = load_class('UTF8', 'core');
        $this->router = &load_class('Router', 'core');
        $this->output = &load_class('Output', 'core');
        $this->security = &load_class('Security', 'core');
        $this->input = &load_class('Input', 'core');
        $this->lang = &load_class('Lang', 'core');
        $this->db = &load_class('DB', 'database');
        $this->session = &load_class('Session', 'libraries');
        $this->form_validation = &load_class('Form_validation', 'libraries');
    }
}
