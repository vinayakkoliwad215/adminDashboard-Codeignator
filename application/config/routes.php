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
|	https://codeigniter.com/userguide3/general/routing.html
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
$route['default_controller'] = 'HomeController';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


$route['home'] = 'PageController/index';
$route['about'] = 'PageController/aboutus';

//$route['blog/(:any)'] = 'PageController/blog/$1';
$route['blog/(:num)'] = 'PageController/blog/$1';


$route['products'] = "ProductController/index";
$route['products/show_all'] = 'ProductController/show_all';
$route['products/create'] = "ProductController/create";
$route['products/store']['post'] = "ProductController/store";
$route['products/show/(:num)'] = 'ProductController/show/$1';
$route['products/edit/(:num)'] = "ProductController/edit/$1";
$route['products/update/(:num)']['post'] = "ProductController/update/$1";
$route['products/delete/(:num)']['delete'] = "ProductController/delete/$1";

// $route['default_controller'] = 'auth';

// $route['loginuser'] = 'AuthController/index';
// $route['send-otp'] = 'AuthController/send_otp';
// $route['verify-otp'] = 'AuthController/verify_otp';
// // $route['dashboard'] = 'AuthController/dashboard';
// $route['logout'] = 'AuthController/logout';

// USERS
$route['users'] = "UserController/index";
$route['users/show_all'] = 'UserController/show_all';
$route['users/edit/(:num)'] = "UserController/edit/$1";
$route['users/store']['post'] = "UserController/store";
$route['users/update/(:num)']['post'] = "UserController/update/$1";
$route['users/delete/(:any)'] = "UserController/delete/$1";
$route['users/update_otp_status'] = "UserController/update_otp_status";
$route['users/getBranches'] = "UserController/getBranches";

$route['login'] = 'LoginController/login';
$route['login/send-otp'] = 'LoginController/sendOtp';
$route['login/verify-otp'] = 'LoginController/verifyOtp';

//payment modes
$route['payment-modes'] = 'PaymentModeController/index';
$route['payment-modes/show_all'] = 'PaymentModeController/show_all';
$route['payment-modes/store'] = 'PaymentModeController/store';
$route['payment-modes/edit/(:any)'] = 'PaymentModeController/edit/$1';
$route['payment-modes/update/(:any)'] = 'PaymentModeController/update/$1';
$route['payment-modes/delete/(:any)'] = 'PaymentModeController/delete/$1';
$route['payment-modes/list'] = 'UserController/loadPaymentModes';

// USERS Credentials
$route['users-credentials'] = "UserCredentialsController/index";
$route['users-credentials/show_all'] = 'UserCredentialsController/show_all';
$route['users-credentials/send-sms']['post'] = "UserCredentialsController/sendSmsToUsers";
$route['users-credentials/send-sms-email']['post'] = 'UserCredentialsController/sendSmsAndEmail';

//sms reports
$route['sms-reports'] = "SMSController/index";
$route['sms-reports/show_all'] = 'SMSController/show_all';

//email reports
$route['email-reports'] = "EmailController/index";
$route['email-reports/loginEmails'] = 'EmailController/loginEmails';

$route['generalSettings'] = 'GeneralSettingsController/index';
$route['generalSettings/gs_showall'] = 'GeneralSettingsController/show_all';

//General Settings
$route['generalSettings'] = 'GeneralSettingsController/index';
$route['generalSettings/store'] = 'GeneralSettingsController/store';
$route['generalSettings/edit/(:any)'] = 'GeneralSettingsController/edit/$1';
$route['generalSettings/update/(:any)'] = 'GeneralSettingsController/update/$1';
$route['generalSettings/delete/(:any)'] = 'GeneralSettingsController/delete/$1';
$route['generalSettings/storeImages'] = 'GeneralSettingsController/storeImages';

//Payment Transactions
$route['users-payments'] = "UserPaymentController/index";
$route['users-payments/payment_all'] = 'UserController/show_all';
$route['users/list'] = "UserPaymentController/loadUsers";
$route['payment-transactions/transactions_all'] = "UserPaymentController/show_all";
$route['payment-transactions/store'] = "UserPaymentController/store";
$route['depositTypes/list'] = "UserPaymentController/loadDepositTypes";
$route['payment-transactions/view/(:num)'] = 'UserPaymentController/getUserTransactions/$1';
$route['paymentTransactions/getPayments'] = 'UserPaymentController/transation_show_all';
$route['users-transactions'] = "UserPaymentController/userTransactions";

//Deposit Types
$route['deposit-types'] = "DepositTypeController/index";
$route['deposit-types/depositTypes_all'] = 'DepositTypeController/show_all';
$route['deposit-types/store'] = 'DepositTypeController/store';
$route['deposit-types/edit/(:any)'] = 'DepositTypeController/edit/$1';
$route['deposit-types/update/(:any)'] = 'DepositTypeController/update/$1';
$route['deposit-types/delete/(:any)'] = 'DepositTypeController/delete/$1';

//Dashboard
$route['dashboard'] = "HomeController/index";

//logout
$route['logout'] = 'LoginController/logout';

//Receipt
$route['user-payments/receipt/(:num)'] = 'UserPaymentController/receipt_view/$1';
$route['user-payments/receipt-download/(:num)'] = 'UserPaymentController/download_receipt/$1';

//filter payments
$route['filter-payments'] = 'FilterController/index';
$route['filter-payments/getPayments'] = 'FilterController/getPayments';


//employee controller ajax auto save
$route['clients'] = 'ClientsController/index';
$route['clients/auto-save'] = 'ClientsController/auto_save';
$route['clients/list'] = 'ClientsController/list';
$route['clients/show_all'] = 'ClientsController/show_all';
$route['clients/edit/(:num)']   = 'ClientsController/edit/$1';
$route['clients/update/(:num)'] = 'ClientsController/update/$1';
$route['clients/delete/(:num)'] = 'ClientsController/delete/$1';

//branches
$route['branches'] = 'BranchesController/index';
$route['branches/show_all'] = 'BranchesController/show_all';
$route['branches/create'] = 'BranchesController/create';
$route['branches/store'] = 'BranchesController/store';
$route['branches/edit/(:num)'] = 'BranchesController/edit/$1';
$route['branches/update/(:num)'] = 'BranchesController/update/$1';
$route['branches/delete/(:num)'] = 'BranchesController/delete/$1';
$route['branches/view/(:num)'] = 'BranchesController/view/$1';

//client transactions
$route['client-transactions'] = "ClientTransactionController/index";
$route['client-loads'] = "ClientTransactionController/loadClients";
$route['client-transactions/store'] = "ClientTransactionController/store";
$route['client-transactions/transactions_all'] = "ClientTransactionController/client_transactions";
$route['client-transactions/view/(:num)'] = 'ClientTransactionController/getClientTransactions/$1';
$route['client-transactions/receipt-download/(:num)'] = 'ClientTransactionController/download_receipt/$1';

//thems
$route['themeSettings'] = 'ThemeController/index';
$route['themeSettings/store'] = 'ThemeController/store';
