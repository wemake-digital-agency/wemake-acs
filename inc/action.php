<?php



if(WMACS_AJAX_DEBUG){

	ini_set('display_errors', 1);

	error_reporting(E_ALL);

}



// function wmacs_plugin_check_update_action(){



//     // Security



//     if(!wmacs_admin_perm() || check_ajax_referer($_REQUEST['action'])!==1 || wp_verify_nonce($_REQUEST['_wpnonce'], $_REQUEST['action'])!==1) {

//         exit;

//     }



//     // Header



//     header('Content-Type: application/json');



//     // Set options



//     update_option('wmacs_last_update_check', date('d.m.Y H:i:s'));



//     // Check update



//     if(!empty(trim($json_str = file_get_contents(base64_decode('aHR0cHM6Ly9yZXBvc2l0b3J5LndlbWFrZS5jby5pbC91cGRhdGUucGhwP3NlY3JldF9rZXk9Y1I0bzZfMXh0M2NULTE3diZtb2RlPWNoZWNrX3BsdWdpbl91cGRhdGU=').'&plugin='.WMACS_PLUGIN_SLUG.'&version='.WMACS_PLUGIN_VERSION.'&h='.urlencode($_SERVER['HTTP_HOST']))))){

//         $json_data = json_decode($json_str, true);

//         if(isset($json_data['new_version']) && !empty($json_data['new_version_url'])){

//             update_option('wmacs_new_version', $json_data['new_version']);

//             update_option('wmacs_new_version_url', $json_data['new_version_url']);

//         }

//         if(isset($json_data['l']) && !empty($json_data['l'])){

//             update_option('wmacs_l', 1);

//         }else{

//             update_option('wmacs_l', 0);

//         }

//     }



//     // Result



//     wmacs_ajax_return(array('error' => 0));



// }

// add_action('wp_ajax_wmacs_plugin_check_update', 'wmacs_plugin_check_update_action');



// function wmacs_plugin_run_update_action(){



//     // Security



//     if(!wmacs_admin_perm() || check_ajax_referer($_REQUEST['action'])!==1 || wp_verify_nonce($_REQUEST['_wpnonce'], $_REQUEST['action'])!==1) {

//         exit;

//     }



//     // Header



//     header('Content-Type: application/json');



//     // Check wp filesystem module



//     if(!function_exists('WP_Filesystem') || !function_exists('unzip_file')){

//         wmacs_ajax_return(array('error' => 1));

//     }



//     // Check update parameters



//     $new_version = get_option('wmacs_new_version');

//     $new_version_url = get_option('wmacs_new_version_url');



//     if(empty($new_version) || empty($new_version_url)){

//         wmacs_ajax_return(array('error' => 2));

//     }



//     // Download update



//     $archive = file_get_contents($new_version_url);

//     $new_version_path = WMACS_ABSPATH.'/new_version.zip';



//     if(empty(trim($archive))){

//         wmacs_ajax_return(array('error' => 3));

//     }



//     if(!file_put_contents($new_version_path, $archive) || !file_exists($new_version_path)){

//         wmacs_ajax_return(array('error' => 4));

//     }



//     // Enable maintenance mode



//     wmacs_set_maintenance_status(true);



//     // Clear plugin folder



//     $exlude_files = array(

//         'new_version.zip'

//     );



//     $all_plugin_files = wmacs_recursive_files_search(WMACS_ABSPATH, '*');



//     if(!empty($all_plugin_files)){



//         rsort($all_plugin_files);



//         // Remove files



//         foreach($all_plugin_files as $file_path){

//             if(!file_exists($file_path) || is_dir($file_path) || !empty($exlude_files) && in_array(wmacs_basename($file_path), $exlude_files)){

//                 continue;

//             }

//             unlink($file_path);

//         }



//         // Remove folders



//         foreach($all_plugin_files as $file_path){

//             if(!file_exists($file_path) || !is_dir($file_path)){

//                 continue;

//             }

//             rmdir($file_path);

//         }



//     }



//     // Unpack archive



//     WP_Filesystem();



//     if(is_wp_error(unzip_file($new_version_path, WMACS_ABSPATH))){

//         wmacs_set_maintenance_status(false);

//         wmacs_ajax_return(array('error' => 5));

//     }



//     // Remove archive



//     unlink($new_version_path);



//     // Set options



//     update_option('wmacs_new_version', '');

//     update_option('wmacs_new_version_url', '');



//     // Disable maintenance mode



//     wmacs_set_maintenance_status(false);



//     // Result



//     wmacs_ajax_return(array('error' => 0));



// }

// add_action('wp_ajax_wmacs_plugin_run_update', 'wmacs_plugin_run_update_action');



?>
