<?php



if (!defined('WMACS_ABSPATH')) exit;



function wmacs_load_textdomain()
{



    if (!is_textdomain_loaded(WMACS_PLUGIN_SLUG)) {

        if ((is_admin() || is_multisite() && is_network_admin()) && function_exists('get_user_locale')) {

            $locale = get_user_locale();
        } elseif (function_exists('get_locale')) {

            $locale = get_locale();
        } else {

            $locale = 'en_US';
        }

        load_textdomain(WMACS_PLUGIN_SLUG, WMACS_ABSPATH . '/languages/' . $locale . '.mo');
    }
}



function wmacs_developer_mode()
{

    if ($_SERVER['REMOTE_ADDR'] == '92.253.250.29') return true;

    return false;
}



function wmacs_admin_perm()
{

    if (current_user_can('administrator')) {

        return true;
    }

    return false;
}



function wmacs_ajax_return($data)
{

    echo json_encode($data);

    exit;
}



function wmacs_get_ajax_action_url($action, $parameters = array(), $echo = true)
{



    $action_url = admin_url('/admin-ajax.php?action=' . $action . '&_wpnonce=' . wp_create_nonce($action));



    if (count($parameters)) {

        foreach ($parameters as $par_k => $par) {

            $action_url .= '&' . $par_k . '=' . $par;
        }
    }



    if ($echo) {

        echo $action_url;
    } else {

        return $action_url;
    }
}



function wmacs_recursive_files_search($dir_path, $filter = '*.*', $data = array())
{



    // Find folders



    if (count($folders = glob($dir_path . '/*', GLOB_ONLYDIR))) {

        foreach ($folders as $folder) {

            $data = wmacs_recursive_files_search($folder, $filter, $data);
        }
    }



    // Find files



    if (count($files = glob($dir_path . '/' . $filter))) {

        foreach ($files as $file) {

            $data[] = $file;
        }
    }



    return $data;
}



function wmacs_get_maintenance_status()
{

    return get_option('wmacs_maintenance_on');
}



function wmacs_set_maintenance_status($status)
{

    update_option('wmacs_maintenance_on', $status ? 1 : 0);
}



function wmacs_basename($file_path)
{

    return preg_replace('/(.*)\//', '', $file_path);
}



function wmacs_get_plugin_row_path()
{

    return WMACS_PLUGIN_SLUG . '/' . preg_replace('/\-/', '_', WMACS_PLUGIN_SLUG) . '.php';
}
