<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'auth/login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['login']  = 'auth/login';
$route['logout'] = 'auth/logout';

$route['admin'] = 'admin/events';
$route['admin/events'] = 'admin/events';
$route['admin/events/create'] = 'admin/create_event';
$route['admin/events/edit/(:num)'] = 'admin/edit_event/$1';
$route['admin/events/form-nodes/(:num)'] = 'admin/form_nodes/$1';
$route['admin/events/quotas/(:num)'] = 'admin/quotas/$1';
$route['admin/events/approval-bands/(:num)'] = 'admin/approval_bands/$1';

$route['events'] = 'events/upcoming';
$route['events/register/(:num)'] = 'events/register/$1';
$route['events/my'] = 'events/my_registrations';

$route['approver'] = 'approver/dashboard';
$route['approver/event/(:num)'] = 'approver/registrations_by_event/$1';
$route['approver/decision/(:num)'] = 'approver/decision/$1';
