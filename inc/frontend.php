<?php



if(get_option('wmacs_l')) return false;



// Maintenance mode



add_action('template_redirect', function(){

    if(wmacs_get_maintenance_status()){

        die('<h1 align="center">'.__('Briefly unavailable for scheduled maintenance. Check back in a minute.', WMACS_PLUGIN_SLUG).'</h1>');

    }

});



add_action('wp_enqueue_scripts', function(){



    wp_enqueue_style('wmacs-style',     WMACS_URI.'/assets/css/wemake-acs.css', array(), WMACS_PLUGIN_VERSION, 'all');

    wp_enqueue_script('wmacs-js',       WMACS_URI.'/assets/js/wemake-acs.js', array(), null, true);



    if(!wp_script_is('jquery', 'done')){

        wp_enqueue_script('jquery',     WMACS_URI.'/lib/js/jquery-3.4.1.min.js', array(), null, false);

    }



}, 20);



function wmacs_frontend(){



    // Load textdomain



    wmacs_load_textdomain();



    // Classes



    $default_options_set = get_option('wmacs_set_default_options');

    $classes = array('show-on-load-1s');



    if(empty($default_options_set) || !empty(get_option('wmacs_show_for_pc'))){

        $classes[] = 'show-for-pc';

    }



    if(empty($default_options_set) || !empty(get_option('wmacs_show_for_mob'))){

        $classes[] = 'show-for-mob';

    }



    $position_pc = get_option('wmacs_position_pc');

    $position_mob = get_option('wmacs_position_mob');

    $classes[] = '-pos-pc-' . (!empty($position_pc) ? $position_pc : 'top');

    $classes[] = '-pos-mob-' . (!empty($position_mob) ? $position_mob : 'top');



    ?>

    <div id="wemake-plg-acs-frontend" class="<?php echo implode(' ', $classes); ?>">



        <div class="wm-plg-acs-button"><span class="wm-i-v4 icon-vector4"></span></div>

        <div class="wm-plg-acs-overlay">
            <div class="wm-plg-acs-title-block">
                <div class="wm-plg-acs-title">

                    <?php _e('Accessibility tools', WMACS_PLUGIN_SLUG); ?>

                </div>
                <span class="wm-i-v1 icon-vector1"></span>
            </div>
            <ul class="wm-plg-acs-items">

                <?php if(empty($default_options_set) || !empty(get_option('wmacs_increase_text'))){ ?>

                    <li class="wm-plg-acs-item">

                        <a href="#" class="wm-plg-acs-link-item" data-action="zoomIn">

                            <span class="wm-i-v12 icon-vector12 icon-vector"></span>

                            <?php _e('Increase text', WMACS_PLUGIN_SLUG); ?>

                        </a>

                    </li>

                <?php } ?>

                <?php if(empty($default_options_set) || !empty(get_option('wmacs_decrease_text'))){ ?>

                    <li class="wm-plg-acs-item">

                        <a href="#" class="wm-plg-acs-link-item" data-action="zoomOut">

                            <span class="wm-i-v13 icon-vector13 icon-vector"></span>

                            <?php _e('Decrease text', WMACS_PLUGIN_SLUG); ?>

                        </a>

                    </li>

                <?php } ?>

                <?php if(empty($default_options_set) || !empty(get_option('wmacs_grayscale'))){ ?>

                    <li class="wm-plg-acs-item">

                        <a href="#" class="wm-plg-acs-link-item" data-action="grayscale">

                            <span class="wm-i-v9 icon-vector9">
                                <span class="path1">
                                </span><span class="path2"></span>
                            </span>

                            <?php _e('Grayscale', WMACS_PLUGIN_SLUG); ?>

                        </a>

                    </li>

                <?php } ?>

                <?php if(empty($default_options_set) || !empty(get_option('wmacs_high_contrast'))){ ?>

                    <li class="wm-plg-acs-item">

                        <a href="#" class="wm-plg-acs-link-item" data-action="contrast">

                            <span class="wm-i-v2 icon-vector2 icon-vector"></span>

                            <?php _e('High contrast', WMACS_PLUGIN_SLUG); ?>

                        </a>

                    </li>

                <?php } ?>

                <?php if(empty($default_options_set) || !empty(get_option('wmacs_highlight_links'))){ ?>

                    <li class="wm-plg-acs-item">

                        <a href="#" class="wm-plg-acs-link-item" data-action="links">

                            <span class="wm-i-v10 icon-vector10 icon-vector"></span>

                            <?php _e('Highlight links', WMACS_PLUGIN_SLUG); ?>

                        </a>

                    </li>

                <?php } ?>

                <?php if(empty($default_options_set) || !empty(get_option('wmacs_enable_readability'))){ ?>

                    <li class="wm-plg-acs-item">

                        <a href="#" class="wm-plg-acs-link-item" data-action="fonts">

                            <span class="wm-i-v5 icon-vector5 icon-vector"></span>

                            <?php _e('Enable readability', WMACS_PLUGIN_SLUG); ?>

                        </a>

                    </li>

                <?php } ?>

                <?php if(empty($default_options_set) || !empty(get_option('wmacs_white_cursor'))){ ?>

                    <li class="wm-plg-acs-item">

                        <a href="#" class="wm-plg-acs-link-item" data-action="cursor-w">

                            <span class="wm-i-v6 icon-vector6 icon-vector"></span>

                            <?php _e('White cursor', WMACS_PLUGIN_SLUG); ?>

                        </a>

                    </li>

                <?php } ?>

                <?php if(empty($default_options_set) || !empty(get_option('wmacs_black_cursor'))){ ?>

                    <li class="wm-plg-acs-item">

                        <a href="#" class="wm-plg-acs-link-item" data-action="cursor-b">

                            <span class="wm-i-v7 icon-vector7 icon-vector"></span>

                            <?php _e('Black cursor', WMACS_PLUGIN_SLUG); ?>

                        </a>

                    </li>

                <?php } ?>

                <?php if(empty($default_options_set) || !empty(get_option('wmacs_reverse_contrast'))){ ?>

                    <li class="wm-plg-acs-item">

                        <a href="#" class="wm-plg-acs-link-item" data-action="contrast-negative">

                            <span class="wm-i-v8 icon-vector8 icon-vector"></span>

                            <?php _e('Reverse contrast', WMACS_PLUGIN_SLUG); ?>

                        </a>

                    </li>

                <?php } ?>

                <?php if(empty($default_options_set) || !empty(get_option('wmacs_light_background'))){ ?>

                    <li class="wm-plg-acs-item">

                        <a href="#" class="wm-plg-acs-link-item" data-action="contrast-light">
 
                            <span class="wm-i-v3 icon-vector3 icon-vector"></span>

                            <?php _e('Light background', WMACS_PLUGIN_SLUG); ?>

                        </a>

                    </li>

                <?php } ?>

                

                

                

                <li class="wm-plg-acs-item">

                    <a href="#" class="wm-plg-acs-link-item" data-action="clear">

                        <?php _e('Reset', WMACS_PLUGIN_SLUG); ?>

                        <span class="wm-i-v11 icon-vector11"></span>

                    </a>

                </li>

            </ul>

        </div>

        <div class="wm-plg-acs-wemake-powered-wrapper">
            <a href="https://www.wemake.co.il/" target="_blank" class="wm-plg-acs-powered" alt="wemake digital" title="wemake digital">
                <svg xmlns="http://www.w3.org/2000/svg" width="94" height="14" viewBox="0 0 76 11" fill="none">
                <circle cx="74.3826" cy="6.61205" r="1.59594" fill="#116FFF"/>
                <path d="M36.8838 5.47368C36.8838 3.86265 38.1406 2.5144 39.7859 2.5144C41.2599 2.5144 42.6767 3.58843 42.7338 5.35942C42.7338 5.55366 42.7224 5.72505 42.6995 5.87358H38.0835C38.1749 6.71909 38.8604 7.32466 39.7859 7.32466C40.4144 7.32466 40.86 7.07329 41.157 6.75337L42.4938 6.76479C42.0025 7.74741 40.9742 8.41011 39.8202 8.41011C38.1749 8.41011 36.8838 7.09614 36.8838 5.47368ZM38.0835 4.95952H41.5341C41.3284 4.18257 40.6429 3.59985 39.8202 3.59985C38.929 3.59985 38.2892 4.18257 38.0835 4.95952Z" fill="#2F2F2F"/>
                <path d="M32.1206 8.31882V0.547607H33.2403V4.77682L35.4684 2.60593H36.8966L34.7028 4.78825L37.2736 8.31882H36.0282L33.9373 5.49665L33.2403 6.17077V8.31882H32.1206Z" fill="#2F2F2F"/>
                <path d="M28.3839 8.41011C26.7614 8.41011 25.436 7.09614 25.436 5.46226C25.436 3.82837 26.7614 2.5144 28.3839 2.5144C30.0063 2.5144 31.3203 3.82837 31.3203 5.46226V8.3187H30.2006V7.41606C29.9264 7.97593 29.1951 8.41011 28.3839 8.41011ZM28.3953 7.32466C29.4351 7.32466 30.212 6.502 30.212 5.46226C30.212 4.42251 29.4465 3.59985 28.3953 3.59985C27.3441 3.59985 26.5558 4.42251 26.5558 5.46226C26.5558 6.502 27.3556 7.32466 28.3953 7.32466Z" fill="#2F2F2F"/>
                <path d="M22.3272 2.5144C23.7555 2.5144 24.8066 3.39419 24.8066 5.31372V8.3187H23.6869V5.31372C23.6869 4.14829 23.1956 3.59985 22.3272 3.59985C21.4703 3.59985 20.9676 4.14829 20.9676 5.31372V8.3187H19.8479V5.31372C19.8479 4.14829 19.3565 3.59985 18.4882 3.59985C17.6312 3.59985 17.1285 4.14829 17.1285 5.31372V8.3187H16.0088V5.31372C16.0088 3.39419 17.06 2.5144 18.4882 2.5144C19.3108 2.5144 20.0307 2.85718 20.4077 3.577C20.7848 2.85718 21.5046 2.5144 22.3272 2.5144Z" fill="#2F2F2F"/>
                <path d="M9.53564 5.47368C9.53564 3.86265 10.7925 2.5144 12.4378 2.5144C13.9117 2.5144 15.3285 3.58843 15.3856 5.35942C15.3856 5.55366 15.3742 5.72505 15.3514 5.87358H10.7354C10.8268 6.71909 11.5123 7.32466 12.4378 7.32466C13.0662 7.32466 13.5118 7.07329 13.8089 6.75337L15.1457 6.76479C14.6544 7.74741 13.6261 8.41011 12.4721 8.41011C10.8268 8.41011 9.53564 7.09614 9.53564 5.47368ZM10.7354 4.95952H14.1859C13.9803 4.18257 13.2947 3.59985 12.4721 3.59985C11.5809 3.59985 10.941 4.18257 10.7354 4.95952Z" fill="#116FFF"/>
                <path d="M8.33057 2.60596H9.47314L7.58789 8.31885H6.46816L5.18848 4.3084L3.90879 8.31885H2.78906L0.903809 2.60596H2.04639L3.34893 6.84492L4.62861 2.60596H5.74834L7.02803 6.84492L8.33057 2.60596Z" fill="#116FFF"/>
                <path d="M71.0447 8.29489H70.3364V0.547607H71.0447V8.29489Z" fill="#2F2F2F"/>
                <path d="M66.7163 8.38346C65.1447 8.38346 63.8608 7.11069 63.8608 5.52803C63.8608 3.94537 65.1447 2.67261 66.7163 2.67261C68.2879 2.67261 69.5606 3.94537 69.5606 5.52803V8.29492H68.8523V7.11069C68.4871 7.84115 67.657 8.38346 66.7163 8.38346ZM66.7273 7.70834C67.9226 7.70834 68.8634 6.74546 68.8634 5.52803C68.8634 4.3106 67.9448 3.34773 66.7273 3.34773C65.5099 3.34773 64.5692 4.3106 64.5692 5.52803C64.5692 6.74546 65.532 7.70834 66.7273 7.70834Z" fill="#2F2F2F"/>
                <path d="M63.6892 3.43624H62.2947V5.66082C62.2947 6.88931 62.826 7.5091 63.6892 7.64191V8.32809C62.4497 8.20635 61.5864 7.37629 61.5864 5.68295V3.43624H60.7563V2.76112H61.5864V1.01245H62.2947V2.76112H63.6892V3.43624Z" fill="#2F2F2F"/>
                <path d="M60.0251 1.79833C59.7705 1.79833 59.5713 1.61018 59.5713 1.34456C59.5713 1.09 59.7705 0.901855 60.0251 0.901855C60.2796 0.901855 60.4788 1.09 60.4788 1.34456C60.4788 1.61018 60.2796 1.79833 60.0251 1.79833ZM59.6709 8.29497V2.7612H60.3792V8.29497H59.6709Z" fill="#2F2F2F"/>
                <path d="M56.0488 10.5084C54.8867 10.5084 53.8795 9.81117 53.4368 8.79296H54.2669C54.6432 9.42381 55.2851 9.83331 56.0599 9.83331C57.2219 9.83331 58.1848 8.9479 58.1848 7.78581V7.25457C57.7311 7.94076 56.9453 8.38346 56.0488 8.38346C54.4772 8.38346 53.1934 7.11069 53.1934 5.52803C53.1934 3.94537 54.4772 2.67261 56.0488 2.67261C57.6314 2.67261 58.9042 3.94537 58.9042 5.52803V7.653C58.9042 9.23566 57.6314 10.5084 56.0488 10.5084ZM56.0599 7.70834C57.2551 7.70834 58.1959 6.74546 58.1959 5.52803C58.1959 4.3106 57.2773 3.34773 56.0599 3.34773C54.8424 3.34773 53.9017 4.3106 53.9017 5.52803C53.9017 6.74546 54.8646 7.70834 56.0599 7.70834Z" fill="#2F2F2F"/>
                <path d="M52.1354 1.79833C51.8809 1.79833 51.6816 1.61018 51.6816 1.34456C51.6816 1.09 51.8809 0.901855 52.1354 0.901855C52.39 0.901855 52.5892 1.09 52.5892 1.34456C52.5892 1.61018 52.39 1.79833 52.1354 1.79833ZM51.7812 8.29497V2.7612H52.4896V8.29497H51.7812Z" fill="#2F2F2F"/>
                <path d="M50.7979 5.528C50.7979 7.11066 49.5252 8.38343 47.9536 8.38343C46.382 8.38343 45.0981 7.11066 45.0981 5.528C45.0981 3.94534 46.382 2.67258 47.9536 2.67258C48.8722 2.67258 49.6469 3.15955 50.0896 3.8568V0.547607H50.7979V5.528ZM47.9536 3.3477C46.7583 3.3477 45.8065 4.31057 45.8065 5.528C45.8065 6.74543 46.7361 7.70831 47.9536 7.70831C49.1821 7.70831 50.1007 6.74543 50.1007 5.528C50.1007 4.31057 49.1599 3.3477 47.9536 3.3477Z" fill="#2F2F2F"/>
                </svg>
            </a>
            - Powered by
        </div>



    </div>

    <?php

}

add_action('wp_footer', 'wmacs_frontend', -999);



// Custom style



function wmacs_wp_head_custom_style(){

    $font_url = WMACS_URI.'/assets/fonts/acs-icons.';

    ?>

    <style>

        @font-face{

            font-family:"acs-icons";

            src:url("<?php echo $font_url; ?>eot?xrri2i");

            src:url("<?php echo $font_url; ?>eot?xrri2i#iefix") format("embedded-opentype"),

            url("<?php echo $font_url; ?>ttf?xrri2i") format("truetype"),

            url("<?php echo $font_url; ?>woff?xrri2i") format("woff"),

            url("<?php echo $font_url; ?>svg?xrri2i#icon") format("svg");

            font-weight:normal;

            font-style:normal;

        }

        <?php if(!empty(get_option('wmacs_set_default_options'))){ ?>

            html #wemake-plg-acs-frontend{ background: <?php esc_html_e(get_option('wmacs_popup_color')); ?>; }

            html .wm-plg-acs-button{ background: <?php esc_html_e(get_option('wmacs_button_color')); ?>; color: <?php echo get_option('wmacs_icon_color'); ?>; }

            html .wm-plg-acs-title, html .wm-plg-acs-wemake-powered-wrapper{ color: <?php esc_html_e(get_option('wmacs_text_color')); ?>; }

            html .wm-plg-acs-link-item, html .wm-plg-acs-powered{ color: <?php esc_html_e(get_option('wmacs_link_color')); ?>; }

            html .wm-plg-acs-link-item:hover, html .wm-plg-acs-powered:hover{ color: <?php esc_html_e(get_option('wmacs_link_color')); ?>; }

        <?php } ?>

    </style>

    <?php

}

add_action('wp_head', 'wmacs_wp_head_custom_style', 99);



?>
