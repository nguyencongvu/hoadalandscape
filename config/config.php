<?php 

session_start(); 

//----------------------------------------------
// CONFIG HERE 
//----------------------------------------------
error_reporting(E_ERROR | E_PARSE ); // not E_ALL 

$SUB = ''; // app run on subfolder: domain.com/[beta] <-- 
$VENDOR_DIR = '';

$VERSION = "0.9.3";  
$DEFAULT_LANG = 'en';  // CHANGE-HERE
$customer = "hoadalandscape" ; // CHANGE-HERE 

if (is_local()) {  //DEV 
    $SUB = '';
    $VENDOR_DIR = __DIR__ . '/../../vendor/autoload.php';

    $api = 'http://localhost:3001';
    $admin_api = 'http://localhost:3002';

} else {  // PROD 
    // $SUB = '/web/shilenanailsspa';
    $SUB = ''
    $VENDOR_DIR = __DIR__ . '/vendor/autoload.php'; // CHANGE-HERE 

    $api = 'https://api.hitime.vn'; 
    $admin_api = 'https://module.hitime.vn'; 

}

require $VENDOR_DIR; // php composer /vendor folder on hosting 


//----------------------------------------------
// END CONFIG  
//----------------------------------------------

// param meters and sessions  
$lang = $_GET['lang'] ? $_GET['lang'] : $DEFAULT_LANG; 
$_SESSION['lang'] = $lang;


//----------------------
// test - unrem to check 
//----------------------
$res =  check(); 
// var_dump($res);
// die(); 


//----------------------------------------------
// FUNCTIONS  
//----------------------------------------------
function check(){
    global $SUB, $VERSION, $DEFAULT_LANG; 
    global $customer, $api, $admin_api, $lang;

    $data = array(
        "version"=>$VERSION,
        "default_lang"=>$DEFAULT_LANG,
        "lang"=>$lang, 
        "subdomain"=>$SUB,
        "customer"=>$customer,
        "api"=>$api,
        "admin_api"=>$admin_api,

    );
    return $data;
}  

function is_local(){
    return strpos($_SERVER["HTTP_HOST"],"localhost") ? true : false;
}





