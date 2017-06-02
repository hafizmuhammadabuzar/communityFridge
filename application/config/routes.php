<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
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
  |	http://codeigniter.com/user_guide/general/routing.html
  |
  | -------------------------------------------------------------------------
  | RESERVED ROUTES
  | -------------------------------------------------------------------------
  |
  | There area two reserved routes:
  |
  |	$route['default_controller'] = 'welcome';
  |
  | This route indicates which controller class should be loaded if the
  | URI contains no data. In the above example, the "welcome" class
  | would be loaded.
  |
  |	$route['404_override'] = 'errors/page_missing';
  |
  | This route will tell the Router what URI segments to use if those provided
  | in the URL cannot be matched to a valid route.
  |
 */

// Api
$route['api/signup'] = "api/save_user";
$route['api/signin'] = "api/user_login";
$route['api/signout'] = "api/logout";
$route['verification'] = "api/user_verify";
$route['api/forgot_password'] = "api/forgot_password";
$route['password/reset'] = "api/reset_password";
$route['api/save_item'] = "api/save_item";
$route['api/get_user_items'] = "api/get_items";
$route['api/get_items'] = "api/get_items";
$route['api/report'] = "api/report";
$route['api/request_refill'] = "api/request_refill";
$route['api/get_activities'] = "api/get_activities";
$route['api/save_fridge_refill'] = "api/save_fridge_refill";
$route['api/add_token'] = "api/save_token";
$route['api/add_token_android'] = "api/save_android_token";

// Web
$route['index'] = "home/index";
$route['getCities'] = "home/get_cities_by_country";
$route['search'] = "home/search";
$route['download/(:any)'] = "home/image_download/$1";
$route['get_direction'] = "home/get_direction";
$route['about-us'] = "home/about";
$route['privacy-policy'] = "home/privacy_policy";
$route['resources'] = "home/resource";
$route['faq'] = "home/faqs";
$route['contact-us'] = "home/contact";
$route['contact-form'] = "home/send_email";
$route['press-release'] = "home/press_release";
$route['support'] = "home/support";

//Admin
$route['dashboard'] = "admin/dashboard";
$route['push_form'] = "admin/push_form";
$route['product_notification'] = "admin/product_notification";
$route['ind_push_form'] = "admin/ind_push_form";
$route['ind_product_notification'] = "admin/ind_product_notification";


/*$route['admin'] = "home/admin_index";
$route['admin_login'] = "home/admin_login";
$route['admin_logout'] = "home/admin_logout";
$route['dashboard'] = "home/dashboard";
$route['push_form'] = "home/push_form";
$route['product_notification'] = "home/product_notification";
$route['ind_push_form'] = "home/ind_push_form";
$route['ind_product_notification'] = "home/ind_product_notification";*/

$route['default_controller'] = "home";
$route['404_override'] = '';
