<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'MainController';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
// customers
$route['customers']['get'] = 'customers/CustomerManager';
$route['customer/create']['get'] = 'customers/CustomerManager/create';
$route['customer/(:num)/edit']['get'] = 'customers/CustomerManager/edit/$1';
$route['customer/store']['POST'] = 'customers/CustomerManager/store';
$route['customer/(:num)/update']['POST'] = 'customers/CustomerManager/update/$1';
$route['customer/(:num)/show']['get'] = 'customers/CustomerManager/read/$1';
$route['customer/(:num)/delete']['get'] = 'customers/CustomerManager/destroy/$1';

//billings and bill
$route['billings']['get'] = 'billings/BillingManager';
$route['billing/create']['get'] = 'billings/BillingManager/create';
$route['billing/generate_billing_file']['post'] = 'billings/BillingManager/generate_billing_file';
$route['billing/(:num)/newLine']['get'] = 'billings/BillingManager/newLine/$1';
$route['billing/(:num)/(:num)/edit']['get'] = 'billings/BillingManager/editBilling/$1/$2';
$route['billing/(:num)/store']['POST'] = 'billings/BillingManager/store/$1';
$route['billing/(:num)/(:num)/update']['POST'] = 'billings/BillingManager/update/$1/$2';
$route['billing/(:num)/(:num)/delete']['get'] = 'billings/BillingManager/destroy/$1/$2';
$route['billing/(:num)/read']['get'] = 'billings/BillingManager/read/$1';
$route['state/list_billing_file']['get'] = 'state/StateManager/list_billing';

$route['bill/create']['get'] = 'billings/BillingManager/createBill';
$route['billing/generate_bill_file']['post'] = 'billings/BillingManager/generate_bill_file';

//files and state
$route['files/create_versement_file']['get'] = 'state/StateManager/create_versement_file';
$route['files/uploading_versement_file']['post'] = 'state/StateManager/uploading_versement_file';

$route['files/create_operation_file']['get'] = 'state/StateManager/create_operation_file';
$route['files/uploading_operation_file']['post'] = 'state/StateManager/uploading_operation_file';

$route['state/(:num)/preview']['get'] = 'state/StateManager/show/$1';
$route['state/(:num)/delete']['get'] = 'state/StateManager/destroy/$1';

$route['state/create_returned_file']['get'] = 'state/StateManager/create_returned_file';
$route['state/generate_returned_file']['post'] = 'state/StateManager/generate_returned_file';
$route['state/list_returned_file']['get'] = 'state/StateManager/list_returned_file';


$route['state/create_paidonline_file']['get'] = 'state/StateManager/create_paidonline';
$route['state/generate_paidonline_file']['post'] = 'state/StateManager/generate_paidonline';
$route['state/list_paidonline_file']['get'] = 'state/StateManager/list_paidonline';


$route['state/create_delivery_file']['get'] = 'state/StateManager/create_delivery';
$route['state/generate_delivery_file']['post'] = 'state/StateManager/generate_delivery';
$route['state/list_delivery_file']['get'] = 'state/StateManager/list_delivery';

$route['state/create_croised_file']['get'] = 'state/StateManager/create_croised';
$route['state/generate_croised_file']['post'] = 'state/StateManager/generate_croised';
$route['state/list_croised_file']['get'] = 'state/StateManager/list_croised';

$route['state/create_rejected_file']['get'] = 'state/StateManager/create_rejected';
$route['state/generate_rejected_file']['post'] = 'state/StateManager/generate_rejected';
$route['state/list_rejected_file']['get'] = 'state/StateManager/list_rejected';

$route['state/create_unvoiced_file']['get'] = 'state/StateManager/create_unvoiced';
$route['state/generate_unvoiced_file']['post'] = 'state/StateManager/generate_unvoiced';
$route['state/list_unvoiced_file']['get'] = 'state/StateManager/list_unvoiced';

// adresses
$route['config/adresses']['get'] = 'config/ConfigurationManager/adress';
$route['adresse/new']['get'] = 'config/ConfigurationManager/adress/new';
$route['adresse/create']['POST'] = 'config/ConfigurationManager/adress/create/$data';
$route['adresse/(:num)/edit']['get'] = 'config/ConfigurationManager/adress/edit/$1';
$route['adresse/(:num)/update']['POST'] = 'config/ConfigurationManager/adress/update/$1';
$route['adresse/(:num)/delete']['get'] = 'config/ConfigurationManager/adress/delete/$1';

// zones
$route['config/zones']['get'] = 'config/ConfigurationManager/zone';
$route['zone/new']['get'] = 'config/ConfigurationManager/zone/new';
$route['zone/create']['POST'] = 'config/ConfigurationManager/zone/create/$data';
$route['zone/(:num)/edit']['get'] = 'config/ConfigurationManager/zone/edit/$1';
$route['zone/(:num)/update']['POST'] = 'config/ConfigurationManager/zone/update/$1';
$route['zone/(:num)/delete']['get'] = 'config/ConfigurationManager/zone/delete/$1';

// regions
$route['config/regions']['get'] = 'config/ConfigurationManager/region';
$route['region/new']['get'] = 'config/ConfigurationManager/region/new';
$route['region/create']['POST'] = 'config/ConfigurationManager/region/create/$data';
$route['region/(:num)/edit']['get'] = 'config/ConfigurationManager/region/edit/$1';
$route['region/(:num)/update']['POST'] = 'config/ConfigurationManager/region/update/$1';
$route['region/(:num)/delete']['get'] = 'config/ConfigurationManager/region/delete/$1';

// cash intervalls
$route['config/cash_intervals']['get'] = 'config/ConfigurationManager/cashInterval';
$route['cash/new']['get'] = 'config/ConfigurationManager/cashInterval/new';
$route['cash/create']['POST'] = 'config/ConfigurationManager/cashInterval/create/$data';
$route['cash/(:num)/edit']['get'] = 'config/ConfigurationManager/cashInterval/edit/$1';
$route['cash/(:num)/update']['POST'] = 'config/ConfigurationManager/cashInterval/update/$1';
$route['cash/(:num)/delete']['get'] = 'config/ConfigurationManager/cashInterval/delete/$1';

// weight intervalls
$route['config/weight_intervals']['get'] = 'config/ConfigurationManager/weightInterval';
$route['weight/new']['get'] = 'config/ConfigurationManager/weightInterval/new';
$route['weight/create']['POST'] = 'config/ConfigurationManager/weightInterval/create/$data';
$route['weight/(:num)/edit']['get'] = 'config/ConfigurationManager/weightInterval/edit/$1';
$route['weight/(:num)/update']['POST'] = 'config/ConfigurationManager/weightInterval/update/$1';
$route['weight/(:num)/delete']['get'] = 'config/ConfigurationManager/weightInterval/delete/$1';