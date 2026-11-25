<?php

/*

Plugin Name: Wemake ACS

Description: Wemake Accessibility plugin

Plugin URI: https://www.wemake.co.il/

Version: 1.63.1

Author: Wemake Team

Author URI: https://www.wemake.co.il/

License: GPL2

Update URI: https://repository.wemake.co.il/wemake-acs

*/

/*

Copyright 2025  wemake Team



This program is free software; you can redistribute it and/or modify

it under the terms of the GNU General Public License, version 2, as

published by the Free Software Foundation.



This program is distributed in the hope that it will be useful,

but WITHOUT ANY WARRANTY; without even the implied warranty of

MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the

GNU General Public License for more details.



You should have received a copy of the GNU General Public License

along with this program; if not, write to the Free Software

Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/



// Constants



define("WMACS_PLUGIN_NAME", 'Wemake Accessibility');

define("WMACS_PLUGIN_SLUG", 'wemake-acs');

define("WMACS_PLUGIN_VERSION", '1.63.1');

define("WMACS_ABSPATH", dirname(__FILE__));

define("WMACS_URI", plugins_url() . '/' . WMACS_PLUGIN_SLUG);



// PHP version



if (version_compare(phpversion(), '5.6.40', '<')) {

    add_action('admin_notices', function () {

        $message = 'Your server is running PHP version ' . phpversion() . ' but ' . WMACS_PLUGIN_NAME . ' requires at least 5.6.40. The plugin does not work.';

        printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr('notice notice-error'), esc_html($message));
    });

    return false;
}



// Functions



require_once(WMACS_ABSPATH . '/inc/functions.php');



// Updates through the Wemake update server (repository.wemake.co.il)



require_once(WMACS_ABSPATH . '/inc/class-wemake-update-client.php');

new Wemake_Update_Client_1_0(__FILE__, WMACS_PLUGIN_SLUG, WMACS_PLUGIN_VERSION);



// Languages



add_action('init', function () {

    wmacs_load_textdomain();
});



// Run controllers



add_action("wp_loaded", function () {

    if (is_admin() || is_multisite() && is_network_admin()) {

        require_once(WMACS_ABSPATH . '/inc/admin.php');
    } else {

        require_once(WMACS_ABSPATH . '/inc/frontend.php');
    }
}, 20);
