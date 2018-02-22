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
//bills
$route['billings']['get'] = 'billings/BillingManager';


//files and state
$route['files/create_versement_file']['get'] = 'state/StateManager/create_versement_file';
$route['files/uploading_versement_file']['post'] = 'state/StateManager/uploading_versement_file';

$route['files/create_operation_file']['get'] = 'state/StateManager/create_operation_file';
$route['files/uploading_operation_file']['post'] = 'state/StateManager/uploading_operation_file';

$route['state/(:num)/preview']['get'] = 'state/StateManager/show/$1';

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

// adresses
$route['adresses']['get'] = 'config/ConfigurationManager/getAdresses';
$route['adress/create']['get'] = 'config/ConfigurationManager/createAdress';
$route['adress/(:num)/edit']['get'] = 'config/ConfigurationManager/editAdress/$1';
$route['adress/(:num)/update']['POST'] = 'config/ConfigurationManager/updateAdress/$1';
$route['adress/(:num)/show']['get'] = 'config/ConfigurationManager/readAdresse/$1';
$route['adress/(:num)/delete']['get'] = 'config/ConfigurationManager/dropAdress/$1';

// zones
$route['zones']['get'] = 'config/ConfigurationManager/getZones';
$route['zone/create']['get'] = 'config/ConfigurationManager/createZone';
$route['zone/(:num)/edit']['get'] = 'config/ConfigurationManager/editZone/$1';
$route['zone/(:num)/update']['POST'] = 'config/ConfigurationManager/updateZone/$1';
$route['zone/(:num)/show']['get'] = 'config/ConfigurationManager/readZone/$1';
$route['zone/(:num)/delete']['get'] = 'config/ConfigurationManager/dropZone/$1';

// regions
$route['regions']['get'] = 'config/ConfigurationManager/getRegions';
$route['region/create']['get'] = 'config/ConfigurationManager/createRegion';
$route['region/(:num)/edit']['get'] = 'config/ConfigurationManager/editRegion/$1';
$route['region/(:num)/update']['POST'] = 'config/ConfigurationManager/updateRegion/$1';
$route['region/(:num)/show']['get'] = 'config/ConfigurationManager/readRegion/$1';
$route['region/(:num)/delete']['get'] = 'config/ConfigurationManager/dropRegion/$1';

// cash intervalls
$route['cash_intervals']['get'] = 'config/ConfigurationManager/getCash';
$route['cash_interval/create']['get'] = 'config/ConfigurationManager/createCashIntervall';
$route['cash_interval/(:num)/edit']['get'] = 'config/ConfigurationManager/editCashIntervall/$1';
$route['cash_interval/(:num)/update']['POST'] = 'config/ConfigurationManager/updateCashIntervall/$1';
$route['cash_interval/(:num)/show']['get'] = 'config/ConfigurationManager/readCashIntervall/$1';
$route['cash_interval/(:num)/delete']['get'] = 'config/ConfigurationManager/dropCashIntervall/$1';

// weight intervalls
$route['weight_intervals']['get'] = 'config/ConfigurationManager/getWeight';
$route['weight_interval/create']['get'] = 'config/ConfigurationManager/createWeightIntervall';
$route['weight_interval/(:num)/edit']['get'] = 'config/ConfigurationManager/editWeightIntervall/$1';
$route['weight_interval/(:num)/update']['POST'] = 'config/ConfigurationManager/updateWeightIntervall/$1';
$route['weight_interval/(:num)/show']['get'] = 'config/ConfigurationManager/readWeightIntervall/$1';
$route['weight_interval/(:num)/delete']['get'] = 'config/ConfigurationManager/dropWeightIntervall/$1';