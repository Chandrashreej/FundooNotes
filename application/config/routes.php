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

$route['signup']='Register/signup';
$route['signin']='Login/signin';
$route['logoff']='Logout/logoff';
$route['forgotPassword'] ='ForgotPassword/forgotPasswordFunction';

$route['getEmailId'] ='ForgotPassword/getEmailId';
$route['getNameValue'] ='DashBoard/getNameValue';

$route['setNotes'] ='DashBoard/setNotes';

$route['setNotesDialog'] ='DashBoard/setNotesDialog';

$route['setReminderDialog'] ='DashBoard/setReminderDialog';

$route['getAllReminderNotes'] ='DashBoard/getAllReminderNotes';
$route['setReminderNotes'] ='DashBoard/setReminderNotes';
$route['resetPassword'] ='ForgotPassword/resetPasswordFunction';

$route['deleteNote'] ='DashBoard/deleteNote';
$route['deleteReminder'] ='DashBoard/deleteReminder';
$route['coloringBackgroundFunction']= 'MoreOptions/coloringBackgroundFunction';
$route['coloringBackgroundForReminder']= 'MoreOptions/coloringBackgroundForReminder';

$route['dragNDrop']= 'MoreOptions/dragNDrop';




$route['unarchive'] ='Archive/unarchive';
$route['fetcharchive'] ='Archive/fetcharchive';

$route['fetchTrash'] ='Trash/fetchTrash';
$route['getAllNotes'] ='DashBoard/getAllNotes';
// $route['getAllNotes'] ='Archive/getAllNotes';

$route['getAllPinnedNotes'] ='DashBoard/getAllPinnedNotes';

// $route['getAllPinnedNotes'] ='Archive/getAllPinnedNotes';

$route['unTrash'] ='Trash/unTrash';  

$route['setlabel'] ='Label/addingLabel';
$route['fetchlabel'] ='Label/fetchingLabel';  
$route['deleteLabel'] ='Label/deleteLabel';  



$route['setlabeleledNotes'] ='Label/setlabeleledNotes';
$route['fetchlabeleledNotes'] ='Label/fetchlabeleledNotes';  

$route['socialLoginData'] ='Login/socialLogin';  

$route['imageFetcher'] ='DashBoard/imageFetcher';
$route['imageSetter'] ='DashBoard/imageSetter';

$route['default_controller'] = 'index';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


$route['adderToDatabase']='Login/adderToDatabase';


$route['updateLabel']='Label/updateLabel';
$route['getAllLabeledNotes']='Label/getAllLabeledNotes';
$route['getAllLabeledPinnedNotes']='Label/getAllLabeledPinnedNotes';
