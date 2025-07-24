<?php

if (!class_exists('Wemake_ACS_GitHub_Updater')) {

    class Wemake_ACS_GitHub_Updater
    {

        private $plugin_file;
        private $plugin_slug;
        private $github_repo = 'wemake-digital-agency/wemake-acs';
        private $github_api_url = 'https://api.github.com/repos/wemake-digital-agency/wemake-acs/releases/latest';

        public function __construct($plugin_file)
        {
            $this->plugin_file = $plugin_file;
            $this->plugin_slug = plugin_basename($plugin_file);
//            error_log('[ACS Updater] p' , 0);
//            error_log(print_r($this->plugin_slug, true));

            add_filter('pre_set_site_transient_update_plugins', [$this, 'check_update']);
            add_filter('plugins_api', [$this, 'plugin_info'], 10, 3);
        }

        public function check_update($transient)
        {

            if (empty($transient->checked)) {
                return $transient;
            }

            $response = wp_remote_get($this->github_api_url, [
                'headers' => [
                    'Accept' => 'application/vnd.github.v3+json',
                    'User-Agent' => 'WordPress',
                ],
                'timeout' => 15,
            ]);

            if (is_wp_error($response)) {
//                error_log('[ACS Updater] Error fetching release info: ' . $response->get_error_message());
                return $transient;
            }

            $release = json_decode(wp_remote_retrieve_body($response));

            if (!$release || empty($release->tag_name)) {
//                error_log('[ACS Updater] Release data missing or malformed');
                return $transient;
            }

            $latest_version = ltrim($release->tag_name, 'v');
            $current_version = $this->get_plugin_version();

//            error_log('[ACS Updater]', 0);
//            error_log(print_r($latest_version, true));
//            error_log(print_r($current_version, true));

            if (version_compare($latest_version, $current_version, '>')) {
                $plugin = new stdClass();
                $plugin->slug = $this->plugin_slug;
                $plugin->new_version = $latest_version;
                $plugin->url = $release->html_url;

                // Search for the asset with the zip archive in the release
                $package_url = '';
                if (!empty($release->assets)) {
                    foreach ($release->assets as $asset) {
                        if (strpos($asset->name, '.zip') !== false) {
                            $package_url = $asset->browser_download_url;
                            break;
                        }
                    }
                }

                // fallback to zipball_url if asset not found
                if (!$package_url) {
                    $package_url = $release->zipball_url;
                }

                $plugin->package = $package_url;

                $transient->response[$this->plugin_slug] = $plugin;
            }

            return $transient;
        }

        public function plugin_info($res, $action, $args)
        {
            global $wp_version;
//            if (!isset($args->slug) || $args->slug !== dirname($this->plugin_slug)) {
//                return $res;
//            }
            if (!isset($args->slug) || $args->slug !== $this->plugin_slug) {
                return $res;
            }

            $response = wp_remote_get($this->github_api_url, [
                'headers' => [
                    'Accept' => 'application/vnd.github.v3+json',
                    'User-Agent' => 'WordPress',
                ],
                'timeout' => 15,
            ]);

            if (is_wp_error($response)) {
                return $res;
            }

            $release = json_decode(wp_remote_retrieve_body($response));

            if (!$release) {
                return $res;
            }

            // Looking for asset from zip
            $download_link = '';
            if (!empty($release->assets)) {
                foreach ($release->assets as $asset) {
                    if (strpos($asset->name, '.zip') !== false) {
                        $download_link = $asset->browser_download_url;
                        break;
                    }
                }
            }
            if (!$download_link) {
                $download_link = $release->zipball_url;
            }

            $res = new stdClass();
            $res->name = $this->get_plugin_name();
//            $res->slug = dirname($this->plugin_slug);
            $res->slug = $this->plugin_slug;
            $res->version = ltrim($release->tag_name, 'v');
//            $res->tested = '6.3'; // Change to the WP version you support
            $res->tested = $wp_version;
//            $res->author = '<a href="https://github.com/wemake-digital-agency">Wemake Team</a>';
            $res->author = '<a target="_blank" href="https://www.wemake.co.il/">Wemake Team</a>';
//            $res->homepage = $release->html_url;
            $res->download_link = $download_link;
            $res->sections = [
                'description' => $this->get_plugin_description(),
                'changelog' => isset($release->body) ? nl2br($release->body) : '',
            ];

            return $res;
        }

        private function get_plugin_version()
        {
            $plugin_data = get_plugin_data(WP_PLUGIN_DIR . '/' . $this->plugin_slug);
//            error_log(print_r($plugin_data, true));
            return $plugin_data['Version'];
        }

        private function get_plugin_name()
        {
            $plugin_data = get_plugin_data(WP_PLUGIN_DIR . '/' . $this->plugin_slug);
            return $plugin_data['Name'];
        }

        private function get_plugin_description()
        {
            $plugin_data = get_plugin_data(WP_PLUGIN_DIR . '/' . $this->plugin_slug);
            return $plugin_data['Description'];
        }
    }

    add_action('admin_init', function () {
//        error_log(print_r(wmacs_get_plugin_row_path()));
        new Wemake_ACS_GitHub_Updater(wmacs_get_plugin_row_path());
    });
}

?>
