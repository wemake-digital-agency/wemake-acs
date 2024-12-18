<?php



/* Update module - version: 2.01 */



// Check security



if (!defined('WMACS_ABSPATH')) exit;



// Plugin list - row actions



add_action('admin_footer', function () {



    // Check options



    if (!empty(get_option('wmacs_last_update_check'))) {

        add_option('wmacs_maintenance_on', '', '', false);

        add_option('wmacs_last_update_check', '', '', false);

        add_option('wmacs_new_version', '', '', false);

        add_option('wmacs_new_version_url', '', '', false);

        add_option('wmacs_l', '', '', false);
    }



    // Create javascript variables



    $last_update_check = get_option('wmacs_last_update_check');



    if (!empty($last_update_check) && (time() - strtotime($last_update_check)) / 60 < 5) {

        $checked = 1;
    } else {

        $checked = 0;
    }



?>

    <script>
        var wmacs_update_param = {

            "checked": <?php echo $checked; ?>,

            "action_check": "<?php wmacs_get_ajax_action_url('wmacs_plugin_check_update'); ?>",

            "action_run": "<?php wmacs_get_ajax_action_url('wmacs_plugin_run_update');  ?>",

        };
    </script>

<?php

});



add_action('after_plugin_row_' . wmacs_get_plugin_row_path(), function () {

    if (empty(get_option('wmacs_new_version_url'))) {

        return false;
    }

    $plugin_slug = preg_replace('/ /', '-', strtolower(WMACS_PLUGIN_SLUG));

?>

    <tr class="plugin-update-tr active"

        id="<?php esc_attr_e($plugin_slug); ?>-update"

        data-slug="<?php esc_attr_e($plugin_slug); ?>"

        data-plugin="<?php esc_attr_e(wmacs_get_plugin_row_path()); ?>">

        <td colspan="3" class="plugin-update colspanchange">

            <div class="update-message notice inline notice-warning notice-alt">

                <p class="notice-text update-text">

                    <?php echo sprintf(__('There is a new version of %s available.', WMACS_PLUGIN_SLUG), WMACS_PLUGIN_NAME . ' ' . esc_html(get_option('wmacs_new_version'))); ?>

                    <a href="#" class="wmacs-update-link">

                        <?php _e('update now', WMACS_PLUGIN_SLUG); ?>

                    </a>.

                </p>

                <p class="notice-text update-active-text">

                    <?php _e('Updating...', WMACS_PLUGIN_SLUG); ?>

                </p>

                <p class="notice-text update-success-text">

                    <?php _e('Updated!', WMACS_PLUGIN_SLUG); ?>

                </p>

            </div>

        </td>

    </tr>

    <script>
        jQuery(function($) {

            $(".wp-list-table tr[data-slug='<?php esc_html_e($plugin_slug); ?>']:not(.plugin-update-tr)").removeClass("active").addClass("active update");

        });
    </script>

<?php

}, 10);



?>