<?php
if (!defined('ABSPATH'))
    exit();

class avsLiteAdmin {

    public static $avs_allowed_pages = '';
    public static $avs_enqueue_file = '';
    public static $avs_current_page = '';
    public static $avs_allowed_button_pages = '';
    public static $avs_add_button = '';
    public static $view = 'home';
    public static $id = '';
    public static $edit = false;

    public function __construct() {
        $this->avsGetCurrentPage();
        $this->avsEnqueueFile();
        $this->avsAddButton();
        $this->avsCheckView();
        $this->avsCheckId();
        add_action('admin_enqueue_scripts', array('avsLiteAdmin', 'avsLiteAdminEnqueues'), 20);
        add_filter('current_screen', array('avsLiteAdmin', 'avsRemoveFooterAdmin'));
        add_filter('media_buttons_context', array('avsLiteAdmin', 'avsInsertButton'), 10);
        add_action('admin_footer', array('avsLiteAdmin', 'avsLiteAdminFooterAvartan'), 10);
        add_action('admin_footer', 'avsLiteAdmin::avsUpgradeToProBox');
        add_action('admin_menu', array('avsLiteAdmin', 'avsAddMenu'), 10);
        add_action('wp_ajax_avartanslider_ajax_action', array('avsLiteAdmin', 'avsAjaxCallAction'));
        add_action('wp_ajax_avl_sbtDeactivationform', array('avsLiteAdmin', 'avsSbtDeactivationform'));
        add_action('admin_head', 'avsLiteAdmin::avsSubscribeMail');
        add_action('wp_ajax_close_tab', 'avsLiteAdmin::avsLiteClose_tab');
    }
    
    /**
     *  Cancel Popup
     *
     * @since 1.3.1
     */
    public static function avsLiteClose_tab() {
        update_option('is_user_subscribed_cancled', 'yes');
        exit();
    }

    /**
     *  Check current page view
     *
     * @since 1.3
     */
    public static function avsCheckView() {
        if (isset($_GET['view'])) {
            self::$view = trim($_GET['view']);
        }
    }
    
    /**
     *  send mail on subscribe
     *
     * @since 1.3
     */
    public static function avsSubscribeMail() {
        $customer_email = get_option('admin_email');
        $current_user = wp_get_current_user();
        $f_name = $current_user->user_firstname;
        $l_name = $current_user->user_lastname;
        if (isset($_POST['sbtEmail'])) {
            $_SESSION['success_msg'] = __('Thank you for your subscription.', 'avartan-slider-lite');
            //Email To Admin
            update_option('is_user_subscribed', 'yes');
            $customer_email = trim($_POST['txtEmail']);
            $customer_name = trim($_POST['txtName']);
            $to = 'plugins@solwininfotech.com';
            $from = get_option('admin_email');

            $headers = "MIME-Version: 1.0;\r\n";
            $headers .= "From: " . strip_tags($from) . "\r\n";
            $headers .= "Content-Type: text/html; charset: utf-8;\r\n";
            $headers .= "X-Priority: 3\r\n";
            $headers .= "X-Mailer: PHP" . phpversion() . "\r\n";
            $subject = 'New user subscribed from Plugin - Avartan Slider Lite';
            $body = '';
            ob_start();
            ?>
            <div style="background: #F5F5F5; border-width: 1px; border-style: solid; padding-bottom: 20px; margin: 0px auto; width: 750px; height: auto; border-radius: 3px 3px 3px 3px; border-color: #5C5C5C;">
                <div style="border: #FFF 1px solid; background-color: #ffffff !important; margin: 20px 20px 0;
                     height: auto; -moz-border-radius: 3px; padding-top: 15px;">
                    <div style="padding: 20px 20px 20px 20px; font-family: Arial, Helvetica, sans-serif;
                         height: auto; color: #333333; font-size: 13px;">
                        <div style="width: 100%;">
                            <strong>Dear Admin (Avartan Slider Lite plugin developer)</strong>,
                            <br />
                            <br />
                            Thank you for developing useful plugin.
                            <br />
                            <br />
                            I <?php echo $customer_name; ?> want to notify you that I have installed plugin on my <a href="<?php echo home_url(); ?>">website</a>. Also I want to subscribe to your newsletter, and I do allow you to enroll me to your free newsletter subscription to get update with new products, news, offers and updates.
                            <br />
                            <br />
                            I hope this will motivate you to develop more good plugins and expecting good support form your side.
                            <br />
                            <br />
                            Following is details for newsletter subscription.
                            <br />
                            <br />
                            <div>
                                <table border='0' cellpadding='5' cellspacing='0' style="font-family: Arial, Helvetica, sans-serif; font-size: 13px;color: #333333;width: 100%;">
                                    <?php if ($customer_name != '') {
                                        ?>
                                        <tr style="border-bottom: 1px solid #eee;">
                                            <th style="padding: 8px 5px; text-align: left;width: 120px;">
                                                Name<span style="float:right">:</span>
                                            </th>
                                            <td style="padding: 8px 5px;">
                                                <?php echo $customer_name; ?>
                                            </td>
                                        </tr>
                                        <?php
                                    } else {
                                        ?>
                                        <tr style="border-bottom: 1px solid #eee;">
                                            <th style="padding: 8px 5px; text-align: left;width: 120px;">
                                                Name<span style="float:right">:</span>
                                            </th>
                                            <td style="padding: 8px 5px;">
                                                <?php echo home_url(); ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    <tr style="border-bottom: 1px solid #eee;">
                                        <th style="padding: 8px 5px; text-align: left;width: 120px;">
                                            Email<span style="float:right">:</span>
                                        </th>
                                        <td style="padding: 8px 5px;">
                                            <?php echo $customer_email; ?>
                                        </td>
                                    </tr>
                                    <tr style="border-bottom: 1px solid #eee;">
                                        <th style="padding: 8px 5px; text-align: left;width: 120px;">
                                            Website<span style="float:right">:</span>
                                        </th>
                                        <td style="padding: 8px 5px;">
                                            <?php echo home_url(); ?>
                                        </td>
                                    </tr>
                                    <tr style="border-bottom: 1px solid #eee;">
                                        <th style="padding: 8px 5px; text-align: left; width: 120px;">
                                            Date<span style="float:right">:</span>
                                        </th>
                                        <td style="padding: 8px 5px;">
                                            <?php echo date('d-M-Y  h:i  A'); ?>
                                        </td>
                                    </tr>
                                    <tr style="border-bottom: 1px solid #eee;">
                                        <th style="padding: 8px 5px; text-align: left; width: 120px;">
                                            Plugin<span style="float:right">:</span>
                                        </th>
                                        <td style="padding: 8px 5px;">
                                            <?php echo 'Avartan Slider Lite'; ?>
                                        </td>
                                    </tr>
                                </table>
                                <br /><br />
                                Again Thanks you
                                <br />
                                <br />
                                Regards
                                <br />
                                <?php echo $customer_name; ?>
                                <br />
                                <?php echo home_url(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $body = ob_get_clean();
            wp_mail($to, $subject, $body, $headers);
        }
        if (get_option('is_user_subscribed') != 'yes' && get_option('is_user_subscribed_cancled') != 'yes') {
            ?>
            <div id="subscribe_widget_avl" style="display:none;">
                <div class="subscribe_widget">
                    <h3>Notify to Avartan Slider plugin developer and subscribe.</h3>
                    <form class='sub_form' name="frmSubscribe" method="post" action="<?php echo admin_url() . 'admin.php?page=avartanslider'; ?>">
                        <div class="sub_row"><label>Your Name: </label><input placeholder="Your Name" name="txtName" type="text" value="<?php echo $f_name . ' ' . $l_name; ?>" /></div>
                        <div class="sub_row"><label>Email Address: </label><input placeholder="Email Address" required name="txtEmail" type="email" value="<?php echo $customer_email; ?>" /></div>
                        <input class="button button-primary" type="submit" name="sbtEmail" value="Notify & Subscribe" />
                    </form>
                </div>
            </div>
            <?php
        }
        if (isset($_GET['page'])) {
            if (get_option('is_user_subscribed') != 'yes' && get_option('is_user_subscribed_cancled') != 'yes' && $_GET['page'] == 'avartanslider') {
                ?>
                <a style="display:none" href="#TB_inline?max-width=400&height=210&inlineId=subscribe_widget_avl" class="thickbox" id="subscribe_thickbox"></a>
                <?php
            }
        }
        ?>
        <div id="sol_deactivation_widget_cover_avl" style="display:none;">
            <div class="sol_deactivation_widget">
                <h3><?php _e('If you have a moment, please let us know why you are deactivating.', 'avartan-slider-lite'); ?></h3>
                <form id="frmDeactivationavl" name="frmDeactivation" method="post" action="">
                    <ul class="sol_deactivation_reasons_ul">
        <?php $i = 1; ?>
                        <li>
                            <input class="sol_deactivation_reasons" checked name="sol_deactivation_reasons_avl" type="radio" value="<?php echo $i; ?>" id="avl_reason_<?php echo $i; ?>">
                            <label for="avl_reason_<?php echo $i; ?>"><?php _e('I am going to upgrade to PRO version', 'avartan-slider-lite'); ?></label>
                        </li>
        <?php $i++; ?>
                        <li>
                            <input class="sol_deactivation_reasons" name="sol_deactivation_reasons_avl" type="radio" value="<?php echo $i; ?>" id="avl_reason_<?php echo $i; ?>">
                            <label for="avl_reason_<?php echo $i; ?>"><?php _e('The plugin suddenly stopped working', 'avartan-slider-lite'); ?></label>
                        </li>
        <?php $i++; ?>
                        <li>
                            <input class="sol_deactivation_reasons" name="sol_deactivation_reasons_avl" type="radio" value="<?php echo $i; ?>" id="avl_reason_<?php echo $i; ?>">
                            <label for="avl_reason_<?php echo $i; ?>"><?php _e('The plugin was not working', 'avartan-slider-lite'); ?></label>
                        </li>
        <?php $i++; ?>
                        <li>
                            <input class="sol_deactivation_reasons" name="sol_deactivation_reasons_avl" type="radio" value="<?php echo $i; ?>" id="avl_reason_<?php echo $i; ?>">
                            <label for="avl_reason_<?php echo $i; ?>"><?php _e('I have configured plugin but not working with my theme', 'avartan-slider-lite'); ?></label>
                        </li>
        <?php $i++; ?>
                        <li>
                            <input class="sol_deactivation_reasons" name="sol_deactivation_reasons_avl" type="radio" value="<?php echo $i; ?>" id="avl_reason_<?php echo $i; ?>">
                            <label for="avl_reason_<?php echo $i; ?>"><?php _e('Installed & configured well but disturbed my theme', 'avartan-slider-lite'); ?></label>
                        </li>
        <?php $i++; ?>
                        <li>
                            <input class="sol_deactivation_reasons" name="sol_deactivation_reasons_avl" type="radio" value="<?php echo $i; ?>" id="avl_reason_<?php echo $i; ?>">
                            <label for="avl_reason_<?php echo $i; ?>"><?php _e("I have other slider which are better than your plugin", 'avartan-slider-lite'); ?></label>
                        </li>
        <?php $i++; ?>
                        <li>
                            <input class="sol_deactivation_reasons" name="sol_deactivation_reasons_avl" type="radio" value="<?php echo $i; ?>" id="avl_reason_<?php echo $i; ?>">
                            <label for="avl_reason_<?php echo $i; ?>"><?php _e('The plugin broke my site completely', 'avartan-slider-lite'); ?></label>
                        </li>
        <?php $i++; ?>
                        <li>
                            <input class="sol_deactivation_reasons" name="sol_deactivation_reasons_avl" type="radio" value="<?php echo $i; ?>" id="avl_reason_<?php echo $i; ?>">
                            <label for="avl_reason_<?php echo $i; ?>"><?php _e('Install plugin for review purpose', 'avartan-slider-lite'); ?></label>
                        </li>
        <?php $i++; ?>
                        <li>
                            <input class="sol_deactivation_reasons" name="sol_deactivation_reasons_avl" type="radio" value="<?php echo $i; ?>" id="avl_reason_<?php echo $i; ?>">
                            <label for="avl_reason_<?php echo $i; ?>"><?php _e('No any reason', 'avartan-slider-lite'); ?></label>
                        </li>
        <?php $i++; ?>
                        <li>
                            <input class="sol_deactivation_reasons" name="sol_deactivation_reasons_avl" type="radio" value="<?php echo $i; ?>" id="avl_reason_<?php echo $i; ?>">
                            <label for="avl_reason_<?php echo $i; ?>"><?php _e('Other', 'avartan-slider-lite'); ?></label><br/>
                            <input style="display:none;width: 90%" value="" type="text" name="sol_deactivation_reason_other_avl" class="sol_deactivation_reason_other_avl" />
                        </li>
                    </ul>
                    <input type="submit" name="sbtDeactivationForm" id="sbtDeactivationFormavl" class="button button-secondary" value="submit & deactivate" />
                    <input type="submit" name="sbtDeactivationFormClose" id="sbtDeactivationFormCloseavl" class="button button-primary" value="cancel" />
                </form>
            </div>
        </div>
        <a style="display:none" href="#TB_inline?height=500&inlineId=sol_deactivation_widget_cover_avl" class="thickbox" id="deactivation_thickbox_avl"></a>
        <?php
    }

    /**
     * Check current page mode Add/Edit
     *
     * @since 1.3
     */
    public static function avsCheckId() {
        if (isset($_GET['id'])) {
            self::$id = trim($_GET['id']);
            self::$edit = true;
        }
    }

    /**
     * Add capability
     *
     * @since 1.3
     */
    public static function avsGetCapability() {
        $manage_options_cap = apply_filters('avs_manage_options_capability', 'manage_options');
        return $manage_options_cap;
    }

    /**
     * Add menus
     *
     * @since 1.3
     */
    public static function avsAddMenu() {
        $role = get_role('administrator');
        $role->add_cap('avartan_slider_access');
        $avs_cap = self::avsGetCapability();
        add_menu_page('Avartan Slider', 'Avartan Slider', $avs_cap, 'avartanslider', 'avsLiteAdmin::avsDisplayPage', AVARTAN_LITE_PLUGIN_URL . '/manage/assets/images/avartan.png');
        add_submenu_page('avartanslider', __('Create New Slider', 'avartan-slider-lite'), __('Create New Slider', 'avartan-slider-lite'), 'manage_options', 'admin.php?page=avartanslider&view=slider&slider_type=standard-slider');
        add_submenu_page('avartanslider', __('Upgrade to PRO', 'avartan-slider-lite'), __('Upgrade to PRO', 'avartan-slider-lite'), 'manage_options', 'avs_upgrade_to_pro', 'avsLiteAdmin::avsUpgradeToPro');
    }

    /**
     * for upgrade to pro
     *
     * @since 1.3
     */
    public static function avsUpgradeToPro() {
        include_once AVARTAN_LITE_PLUGIN_DIR . 'includes/config/upgrade-to-pro.php';
    }

    /**
     *  Display main page of avartan
     *
     * @since 1.3
     */
    public static function avsDisplayPage() {
        global $wpdb;
        ?>
        <div class="wrap as-admin">
            <div class="as-slider-wrapper">
                <noscript class="as-no-js">
                <div class="as-message as-message-error" style="display: block;"><?php _e('JavaScript must be enabled to view this page correctly.', 'avartan-slider-lite'); ?></div>
                </noscript>
                <h1 class="as-logo" title="<?php esc_attr_e('Avartan Slider', 'avartan-slider-lite'); ?>">
                    <a href="?page=avartanslider" title="<?php esc_attr_e('Avartan Slider', 'avartan-slider-lite'); ?>">
                        <img src="<?php echo AVARTAN_LITE_PLUGIN_URL . '/manage/assets/images/logo.png' ?>" alt="<?php esc_attr_e('Avartan Slider', 'avartan-slider-lite'); ?>" />
                    </a>
                </h1>
                <div class="as-plugin-asides">

                    <div class="as-plugin-aside pro_extentions">
                        <h3><?php _e('Avartan Slider Pro Features', 'avartan-slider-lite'); ?></h3>
                        <ul>
                            <li><?php _e('7 Type of Element Support', 'avartan-slider-lite'); ?></li>
                            <li><?php _e('One click Import/Export Slider/Single Slide', 'avartan-slider-lite'); ?></li>
                            <li><?php _e('Duplicate Slide/Slides', 'avartan-slider-lite'); ?></li>
                            <li>
                                <a href="https://avartanslider.com/wordpress/features/" target="_blank"><?php _e('and much more!', 'avartan-slider-lite'); ?></a>
                            </li>
                        </ul>
                        <p><a href="https://codecanyon.net/item/avartan-slider-responsive-wordpress-slider-plugin/19973800?ref=solwin" target="_blank" class="as-plugin-buy-now"><?php _e('Upgrade to PRO!', 'avartan-slider-lite'); ?></a></p>
                    </div>

                    <div class="as-plugin-aside get_help">
                        <h3><?php _e('Get Help', 'avartan-slider-lite'); ?></h3>
                        <ul>
                            <li>
                                <a href="http://avartanslider.com/demo" target="_blank"><?php _e('View Live Demo', 'avartan-slider-lite'); ?></a>
                            </li>
                            <li>
                                <a href="https://avartanslider.com/wordpress-documentation/" target="_blank"><?php _e('Read the documentation', 'avartan-slider-lite'); ?></a>
                            </li>
                            <li>
                                <a href="http://support.solwininfotech.com/" target="_blank"><?php _e('24/7 Free Support', 'avartan-slider-lite'); ?></a>
                            </li>
                            <li>
                                <a href="https://avartanslider.com/pro-vs-lite/" target="_blank"><?php _e('Lite & Pro Comparison', 'avartan-slider-lite'); ?></a>
                            </li>
                            <li>
                                <a href="https://avartanslider.com/faq/" target="_blank"><?php _e('FAQ', 'avartan-slider-lite'); ?></a>
                            </li>
                            <li>
                                <?php _e('Facing any issue?', 'avartan-slider-lite'); ?>&nbsp;<a href="https://avartanslider.com/contact-us/" target="_blank"><u><?php _e('Contact Us', 'avartan-slider-lite'); ?></u></a>
                            </li>
                        </ul>
                    </div>

                    <div class="as-plugin-aside pull-right support_themes">
                        <h3><?php _e('Looking for an Avartan themes?', 'avartan-slider-lite'); ?></h3>
                        <ul>
                            <li><a href="http://demo.solwininfotech.com/wordpress/foodfork/" target="_blank"><?php _e('FoodFork', 'avartan-slider-lite'); ?></a></li>
                            <li><a href="http://demo.solwininfotech.com/wordpress/realestaty/" target="_blank"><?php _e('RealEstaty', 'avartan-slider-lite'); ?></a></li>
                            <li><a href="http://demo.solwininfotech.com/wordpress/veriyas-pro/" target="_blank"><?php _e('Veriyas PRO', 'avartan-slider-lite'); ?></a></li>
                            <li><a href="http://demo.solwininfotech.com/wordpress/myappix/" target="_blank"><?php _e('MyAppix', 'avartan-slider-lite'); ?></a></li>
                            <li><a href="http://demo.solwininfotech.com/wordpress/biznetic/" target="_blank"><?php _e('Biznetic', 'avartan-slider-lite'); ?></a></li>
                            <li><a href="http://demo.solwininfotech.com/wordpress/jewelux/" target="_blank"><?php _e('JewelUX', 'avartan-slider-lite'); ?></a></li>
                        </ul>
                    </div>
                </div>
                <div class="as-wrapper">
                    <?php
                    //Choose the page for display based on call
                    switch (self::$view) {
                        case 'home':
                            require_once AVARTAN_LITE_PLUGIN_DIR . '/includes/slider.php';
                            $sliders_obj = new avsLiteSlider();
                            $sliders = $sliders_obj->getAllSlider();
                            $default_template = $sliders_obj->defaultTemplateArray();
                            require_once AVARTAN_LITE_PLUGIN_DIR . '/manage/views/home.php';
                            break;
                        case 'slider':
                            require_once AVARTAN_LITE_PLUGIN_DIR . '/includes/slider.php';
                            $sliders_obj = new avsLiteSlider();
                            $sliders = $sliders_obj->getAllSlider();
                            require_once AVARTAN_LITE_PLUGIN_DIR . '/manage/views/slider.php';
                            break;
                        case 'slide':
                            require_once AVARTAN_LITE_PLUGIN_DIR . '/includes/slider.php';
                            $sliders_obj = new avsLiteSlider();
                            $sliders = $sliders_obj->getAllSlider();
                            require_once AVARTAN_LITE_PLUGIN_DIR . '/includes/slide.php';
                            require_once AVARTAN_LITE_PLUGIN_DIR . '/manage/views/slide.php';

                            break;
                    }
                    ?>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
            </div>

            <!-- Loader Section -->
            <div class="as-admin-preloader"></div>
        </div>
        <?php
    }

    /**
     * Enqueue admin panel js and css
     *
     * @since 1.3
     */
    public static function avsLiteAdminEnqueues($hook_suffix) {
        
        wp_enqueue_style('avs-dashboard-css', AVARTAN_LITE_PLUGIN_URL . '/manage/assets/css/dashboard.css');
        if (self::$avs_enqueue_file == 'yes' || $hook_suffix == 'plugins.php') {
            require_once AVARTAN_LITE_PLUGIN_DIR . '/includes/slider.php';
            require_once AVARTAN_LITE_PLUGIN_DIR . '/includes/slide.php';
            ?>
            <script type="text/javascript">
                var avartanslider_is_wordpress_admin = true;
            </script>
            <?php
            wp_enqueue_style('wp-jquery-ui-dialog');
            wp_enqueue_style('avs-manage', AVARTAN_LITE_PLUGIN_URL . '/manage/assets/css/manage.css');
            wp_enqueue_style('avs-manage-tools', AVARTAN_LITE_PLUGIN_URL . '/manage/assets/css/manage-tools.min.css');
            wp_dequeue_style('woocommerce_admin_styles');
            wp_enqueue_style('wp-color-picker');

            wp_enqueue_script('jquery');
            wp_enqueue_style('wp-jquery-ui-dialog');
            wp_enqueue_script('jquery-ui-draggable');
            wp_enqueue_script('jquery-ui-tabs');
            wp_enqueue_script('jquery-ui-sortable');
            wp_enqueue_script('jquery-ui-dialog');
            wp_enqueue_media();

            wp_register_script('avs-manage', AVARTAN_LITE_PLUGIN_URL . '/manage/assets/js/manage.js', array('jquery-ui-tabs', 'jquery-ui-sortable', 'jquery-ui-draggable', 'wp-color-picker', 'jquery-ui-dialog','avs-manage-tools'));
            self::avsLocalization();

            wp_enqueue_script('avs-min-js', AVARTAN_LITE_PLUGIN_URL . '/views/assets/js/avartanslider.min.js', array('jquery'));
            $loader = new avsLiteSlider();
            $getSliderSettingAry = $loader->getSliderSettingAry();
            $loader_array = $getSliderSettingAry['loaders'];
            wp_localize_script('avs-min-js', 'avs_loader_array', $loader_array);
            wp_enqueue_style('avs-avartan', AVARTAN_LITE_PLUGIN_URL . '/views/assets/css/avartanslider.min.css');
            wp_enqueue_style('avs-basic-tools-css', AVARTAN_LITE_PLUGIN_URL . '/views/assets/css/basic-tools-min.css');

            wp_enqueue_script('avs-manage-tools', AVARTAN_LITE_PLUGIN_URL . '/manage/assets/js/manage-tools.min.js', array('jquery-ui-tabs', 'jquery-ui-sortable', 'jquery-ui-draggable'));
            wp_dequeue_script('woocommerce_settings');
            wp_enqueue_script('avs-manage');
            
            //code for subscribe popup
            $plugin_data = get_plugin_data(AVARTAN_LITE_PLUGIN_DIR . '/avartanslider.php', $markup = true, $translate = true);
            $current_version = $plugin_data['Version'];
            $old_version = get_option('avl_version');
            if ($old_version != $current_version) {
                update_option('is_user_subscribed_cancled', '');
                update_option('avl_version', $current_version);
            }
            if (get_option('is_user_subscribed') != 'yes' && get_option('is_user_subscribed_cancled') != 'yes') {
                wp_enqueue_script('thickbox');
                wp_enqueue_style('thickbox');
            }        
        }
    }

    /**
     * Get current page
     *
     * @since 1.3
     */
    public static function avsGetCurrentPage() {
        if (isset($_GET['page'])) {
            $trimed_page = trim($_GET['page']);
            if (!empty($trimed_page)) {
                self::$avs_current_page = trim($_GET['page']);
            }
        }
    }

    /**
     * Provide pages where css and js include
     *
     * @since 1.3
     */
    public static function avsEnqueueFile() {
        self::$avs_allowed_pages = apply_filters('avs_allowed_pages', array('avartanslider','avs_upgrade_to_pro'));
        if (in_array(self::$avs_current_page, self::$avs_allowed_pages)) {
            self::$avs_enqueue_file = 'yes';
        }
    }

    /**
     * add button for allowed pages
     *
     * @since 1.3
     */
    public static function avsAddButton() {
        self::$avs_allowed_pages = apply_filters('avs_allowed_pages', array('avartanslider','avs_upgrade_to_pro'));
        if (in_array(self::$avs_current_page, self::$avs_allowed_pages)) {
            self::$avs_enqueue_file = 'yes';
        }
    }

    /**
     * Remove extra footer strip and add only avartan footer
     *
     * @since 1.3
     */
    public static function avsRemoveFooterAdmin() {
        if (in_array(self::$avs_current_page, self::$avs_allowed_pages)) {
            add_filter('admin_footer_text', array('avsLiteAdmin', 'avsAddFooterText'));
        }
    }

    /**
     * Add review text for footer strip
     *
     * @since 1.3
     */
    public static function avsAddFooterText() {
        ob_start();
        ?>
        <p id="footer-left" class="alignleft">
            <?php _e('If you like ', 'avartan-slider-lite') ?>
            <a href="https://wordpress.org/plugins/avartan-slider-lite/" target="_blank"><strong><?php _e('Avartan Slider', 'avartan-slider-lite') ?></strong> </a>
            <?php _e('plugin. please leave us a', 'avartan-slider-lite') ?> 
            <a class="as-review-link" data-rated="Thanks :)" target="_blank" href="https://wordpress.org/support/plugin/avartan-slider-lite/reviews?filter=5#new-post">&#x2605;&#x2605;&#x2605;&#x2605;&#x2605;</a> 
            <?php _e('rating. A heartly thank you from Solwin Infotech in advance!', 'avartan-slider-lite') ?>
        </p>
        <?php
        return ob_get_clean();
    }

    /**
     * Insert button in post and page editor
     *
     * @since 1.3
     */
    public static function avsInsertButton($context) {
        global $pagenow;
        if (in_array($pagenow, array('post.php', 'page.php', 'post-new.php', 'post-edit.php'))) {
            $context .= '<a href="#TB_inline?width=500&height=100&inlineId=choose-avartan-slider" class="thickbox button" title="' .
                    __("Select Avartan Slider to insert into post/page", 'avartan-slider-lite') .
                    '"><span class="wp-media-buttons-icon" style="background: url(' . AVARTAN_LITE_PLUGIN_URL .
                    '/manage/assets/images/avartan.png); background-repeat: no-repeat; background-position: left bottom;"></span> ' .
                    __("Add Avartan Slider", 'avartan-slider-lite') . '</a>';
        }

        return $context;
    }

    /**
     * Click js for avartan button on page and post
     *
     * @since 1.3
     */
    public static function avsLiteAdminFooterAvartan() {

        global $pagenow;

        // Only run in post/page creation and edit screens
        if (in_array($pagenow, array('post.php', 'page.php', 'post-new.php', 'post-edit.php'))) {
            global $wpdb;
            //Get the slider information
            $sliders = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'avartan_sliders');
            ?>

            <script type="text/javascript">
                jQuery(document).ready(function () {
                    jQuery('#insertAvartanSlider').on('click', function () {
                        var id = jQuery('#avartanslider-select option:selected').val();
                        window.send_to_editor('[avartanslider alias="' + id + '"]');
                        tb_remove();
                    });
                });
            </script>

            <div id="choose-avartan-slider" style="display: none;">
                <div class="wrap as-avartan-admin">
                    <?php
                    if (count($sliders)) {
                        echo "<h3 style='margin-bottom: 20px;'>" . __("Insert Avartan Slider", 'avartan-slider-lite') . "</h3>";
                        echo "<select id='avartanslider-select'>";
                        echo "<option disabled=disabled>" . __("Choose Avartan Slider", 'avartan-slider-lite') . "</option>";
                        foreach ($sliders as $slider) {
                            echo "<option value='{$slider->alias}'> {$slider->name} </option>";
                        }
                        echo "</select>";
                        echo "<button class='button primary' id='insertAvartanSlider'>" . __("Insert Avartan Slider", 'avartan-slider-lite') . "</button>";
                    } else {
                        _e("No sliders found", 'avartan-slider-lite');
                    }
                    ?>
                </div>
            </div>
            <?php
        }
    }

    /**
     * Display popup when click on pro features
     *
     * @since 1.3
     */
    public static function avsUpgradeToProBox(){
        ?>
        <div id="as_upgrade_to_pro_dialog" style="display: none">
            <img src="<?php echo AVARTAN_LITE_PLUGIN_URL; ?>/manage/assets/images/avs-upgrade-to-pro.png" alt="<?php _e('Upgrade to PRO!','avartan-slider-lite'); ?>"/>
            <div class="as-btn-wrap">
                <a class="upgrade" href="https://codecanyon.net/item/avartan-slider-responsive-wordpress-slider-plugin/19973800?ref=solwin" target="_blank"><?php _e('UPGRADE TO PRO','avartan-slider-lite'); ?></a>
                <a class="live-demo" href="https://avartanslider.com/" target="_blank"><?php _e('LIVE DEMO','avartan-slider-lite'); ?></a>
            </div>
        </div><?php
    }
    
    /**
     * Set localization which will be used in js file
     *
     * @since 1.3
     */
    public static function avsLocalization() {
        $nonce = wp_create_nonce("avs_nonce");
        // Here the translations for the admin.js file
        $avartanslider_translations = array(
            'slide' => __('Slide', 'avartan-slider-lite'),
            'show_hide_ele_title' => __('Show/Hide Element', 'avartan-slider-lite'),
            'text_element_default_video' => __('Video Element', 'avartan-slider-lite'),
            'text_element_default_image' => __('Image Element', 'avartan-slider-lite'),
            'slider_name' => __('Slider name can not be empty.', 'avartan-slider-lite'),
            'slider_generate' => __('Slider has been generated successfully.', 'avartan-slider-lite'),
            'slider_save' => __('Slider has been saved successfully.', 'avartan-slider-lite'),
            'slider_error' => __('Something went wrong during save slider!', 'avartan-slider-lite'),
            'slider_already_find' => __('Some other slider with alias', 'avartan-slider-lite'),
            'slider_exists' => __('already exists.', 'avartan-slider-lite'),
            'slider_delete' => __('Slider has been deleted successfully.', 'avartan-slider-lite'),
            'slider_delete_error' => __('Something went wrong during delete slider!', 'avartan-slider-lite'),
            'slide_save' => __('Slide has been saved successfully.', 'avartan-slider-lite'),
            'slide_error' => __('Something went wrong during save slide!', 'avartan-slider-lite'),
            'slide_delete' => __('Slide has been deleted successfully.', 'avartan-slider-lite'),
            'slide_delete_error' => __('Something went wrong during delete slide!', 'avartan-slider-lite'),
            'slide_update_position_error' => __('Something went wrong during update slides position!', 'avartan-slider-lite'),
            'slide_delete_confirm' => __('The slide will be deleted. Are you sure?', 'avartan-slider-lite'),
            'slide_delete_just_one' => __('You can not delete this. You must have at least one slide.', 'avartan-slider-lite'),
            'slider_delete_confirm' => __('The slider will be deleted. Are you sure?', 'avartan-slider-lite'),
            'text_element_default_html' => __('Text element', 'avartan-slider-lite'),
            'element_no_found_txt' => __('No element found.', 'avartan-slider-lite'),
            'youtube_video_title' => __('Youtube Video', 'avartan-slider-lite'),
            'video_not_found' => __('Video does not exists.', 'avartan-slider-lite'),
            'html5_video_title' => __('Html5 Video', 'avartan-slider-lite'),
            'something_went_wrong_error' => __('Something went wrong.', 'avartan-slider-lite'),
            'ele_del_confirm' => __('Element will be deleted. Are you sure?', 'avartan-slider-lite'),
            'video_bg_poster' => __('You must have to set video poster image.', 'avartan-slider-lite'),
            'default_nonce' => $nonce,
            'AvartanPluginUrl' => plugins_url() . '/avartan-slider-lite',
            'copied' => __('Copied', 'avartan-slider-lite'),
            'copy_for_support' => __('Copy for Support', 'avartan-slider-lite'),
            'delete_slider' => __('Delete Slider', 'avartan-slider-lite'),
            'cancel' => __('Cancel', 'avartan-slider-lite'),
            'please_select_slider' => __('Please select slider.', 'avartan-slider-lite'),
            'close' => __('Close', 'avartan-slider-lite'),
            'ok' => __('Ok', 'avartan-slider-lite'),
            'delete_slide' => __('Delete Slide', 'avartan-slider-lite'),
            'remove' => __('Remove', 'avartan-slider-lite'),
            'font_family' => __('Font Family', 'avartan-slider-lite'),
            'html5_video' => __('HTML5 Video', 'avartan-slider-lite'),
            'upload_image' => __('Upload Image', 'avartan-slider-lite'),
            'leave_not_saved' => __('By leaving now, all changes since the last saving will be lost. Really leave now?', 'avartan-slider-lite'),
            'current_version' => avsLiteFront::avsPluginGetVersion()
        );
        wp_localize_script('avs-manage', 'avs_translations', $avartanslider_translations);
        $default_element_value = array(
            'layer_value' => array(
                'x_position' => 100,
                'y_position' => 100,
                'x_aix' => 100,
                'y_aix' => 100,
                'width' => 'auto',
                'height' => 'auto',
                'animation_delay' => 300,
                'animation_time' => 0,
                'animation_in' => 'fade',
                'animation_out' => 'fade',
                'animation_startspeed' => 300,
                'animation_endspeed' => 300,
                'attribute_title' => '',
                'attribute_alt' => '',
                'attribute_id' => '',
                'attribute_class' => '',
                'attribute_rel' => '',
                'attribute_link_type' => 'nolink',
                'attribute_link_url' => '',
                'attribute_link_target' => 'new_tab',
                'advance_style' => '',
                'text' => '',
                'type' => '',
                'image_src' => '',
                'video_type' => 'youtube',
                'video_id' => '',
                'youtube_url' => '',
                'vimeo_url' => '',
                'html5_mp4_url' => '',
                'html5_webm_url' => '',
                'html5_ogv_url' => '',
                'video_fullscreen' => 0,
                'editor_video_image' => '',
                'current_version' => avsLiteFront::avsPluginGetVersion(),
                'z_index' => 1
            )
        );
        wp_localize_script('avs-manage', 'avs_default_layer_value', $default_element_value);
    }

    /**
     * Add ajax back end callback, on some action to some function.
     *
     * @since 1.3
     */
    public static function avsAjaxCallAction() {

        global $wpdb;

        $user_action = AvartanSliderLiteFunctions::asGetPostVar("user_action");
        $options = AvartanSliderLiteFunctions::asGetPostVar("data");
        $nonce = AvartanSliderLiteFunctions::asGetPostVar("nonce");
        $slider_table_name = $wpdb->prefix . 'avartan_sliders';
        $slides_table_name = $wpdb->prefix . 'avartan_slides';
        $output = true;
        $as_DBObj = new AvartanSliderLiteCore();
        $as_SCObj = new AvartansliderLiteShortcode();

        try {
            //verify the nonce
            $isVerified = wp_verify_nonce($nonce, "avs_nonce");

            if ($isVerified == false) {

                AvartanSliderLiteFunctions::asAjaxResError(__('Error occure during nonce varification', 'avartan-slider-lite'));
            } else {

                switch ($user_action) {
                    case 'avartanslider_addSlider':

                        foreach ($options as $option) {

                            //Get slider information which are already exists
                            $select = "*";
                            $where = "alias = '" . trim($option['alias']) . "'";
                            $order_by = "";
                            $group_by = "";
                            $extra = "";
                            $format = ARRAY_A;
                            $slider_detail = $as_DBObj->fetch($select, $slider_table_name, $where, $order_by, $group_by, $extra, $format);

                            if ($slider_detail) {

                                $rowcount = $wpdb->num_rows;

                                //Check slider already exists
                                if ($rowcount > 0) {
                                    AvartanSliderLiteFunctions::asAjaxResError(__('This slider name is already exist', 'avartan-slider-lite'));
                                }
                            } else {
                                //insert slider
                                $slider_option = json_decode(stripslashes($option['slider_option']));
                                $slider_option = maybe_serialize($slider_option);

                                $slider_arr = array(
                                    'name' => sanitize_text_field($option['name']),
                                    'alias' => $option['alias'],
                                    'slider_option' => $slider_option,
                                );
                                $output = $as_DBObj->insert($slider_table_name, $slider_arr);

                                if ($output === false) {
                                    AvartanSliderLiteFunctions::asAjaxResError(__('Error occure during create slider', 'avartan-slider-lite'));
                                } else {
                                    $slider_id = $wpdb->insert_id;
                                    $slide_params = new stdClass;
                                    $slide_params->slide_name = __('Slide', 'avartan-slider-lite');
                                    $slide_params->background = new stdClass;
                                    $slide_params->background->type = 'image';
                                    $slide_arr = array(
                                        'slider_parent' => $slider_id,
                                        'params' => maybe_serialize($slide_params),
                                        'position' => 1,
                                        'layers' => ''
                                    );
                                    $output = $as_DBObj->insert($slides_table_name, $slide_arr);
                                    $slide_id = $wpdb->insert_id;

                                    AvartanSliderLiteFunctions::asAjaxResSuccessRedirect(__("Slider has been generated successfully.", 'avartan-slider-lite'), 'add_slider', AvartanSliderLiteFunctions::asGetViewRedirectUrl('slide', 'id=' . esc_attr($slide_id))); //redirect to slide now
                                }
                            }
                        }

                        break;
                    case 'avartanslider_editSlider':

                        foreach ($options as $option) {

                            $select = "*";
                            $where = "alias = '" . trim($option['alias']) . "' AND id <> " . $option['id'];
                            $order_by = "";
                            $group_by = "";
                            $extra = "";
                            $format = ARRAY_A;
                            $slider_detail = $as_DBObj->fetch($select, $slider_table_name, $where, $order_by, $group_by, $extra, $format);

                            if ($slider_detail) {
                                $rowcount = $wpdb->num_rows;

                                //check slider already exists
                                if ($rowcount > 0) {
                                    AvartanSliderLiteFunctions::asAjaxResError(__('This slider name is already exist', 'avartan-slider-lite'));
                                }
                            } else {
                                //update slider
                                $slider_option = json_decode(stripslashes($option['slider_option']));
                                $slider_option = maybe_serialize($slider_option);

                                $slider_arr = array(
                                    'name' => sanitize_text_field($option['name']),
                                    'alias' => $option['alias'],
                                    'slider_option' => $slider_option,
                                );

                                $where = array('id' => $option['id']);

                                $output = $as_DBObj->update($slider_table_name, $slider_arr, $where);

                                if ($output === false) {
                                    AvartanSliderLiteFunctions::asAjaxResError(__('Error occure during edit slider', 'avartan-slider-lite'));
                                } else {
                                    AvartanSliderLiteFunctions::asAjaxResSuccess(__("Slider has been saved successfully.", 'avartan-slider-lite'), 'edit_slider');
                                }
                            }
                        }

                        break;

                    case 'delete_slider':

                        require_once AVARTAN_LITE_PLUGIN_DIR . '/includes/slider.php';
                        $slider_id = isset($options[0]['slider_id']) ? $options[0]['slider_id'] : '';

                        if ($slider_id == '')
                            return;
                        $sliders_obj_delete = new avsLiteSlider();
                        $output = $sliders_obj_delete->deleteSlider($slider_id);
                        if ($output === false) {
                            AvartanSliderLiteFunctions::asAjaxResError(__('Error occure during deleting slider.', 'avartan-slider-lite'));
                        } else {
                            AvartanSliderLiteFunctions::asAjaxResSuccessRedirect(__("Slider has been deleted successfully.", 'avartan-slider-lite'), '', AvartanSliderLiteFunctions::asGetViewRedirectUrl()); //redirect to slide now
                        }
                        break;

                    case 'as_saveSlide':
                        if (isset($options[0])) {
                            $slider_id = $options[0]['slider_id'];
                            $slide_id = $options[0]['slide_id'];

                            $slide_option = json_decode(stripslashes($options[0]['slide_option']));
                            if ($slide_option->custom_css != '') {
                                $custom_css = wp_json_encode(stripslashes($slide_option->custom_css));
                                $custom_css = substr($custom_css, 1, -1);
                                $slide_option->custom_css = $custom_css;
                            }
                            $params = maybe_serialize($slide_option);
                            $position = $options[0]['position'];
                            $slider_elements = json_decode(stripslashes($options[0]['layers']));
                            $layers = maybe_serialize($slider_elements);
                            $slider_arr = array(
                                'slider_parent' => $slider_id,
                                'position' => $position,
                                'params' => $params,
                                'layers' => $layers
                            );
                            $where = array('id' => $slide_id);
                            $output = $as_DBObj->update($slides_table_name, $slider_arr, $where);
                            if ($output === false) {
                                AvartanSliderLiteFunctions::asAjaxResError(__('Error occure during edit slide.', 'avartan-slider-lite'));
                            } else {
                                AvartanSliderLiteFunctions::asAjaxResSuccess(__("Slide has been saved successfully.", 'avartan-slider-lite'), 'edit_slider');
                            }
                        }
                        break;

                    case 'add_slide_from_slideview' :
                        $slider_id = isset($options[0]['slider_id']) ? $options[0]['slider_id'] : '';
                        $where_count = 'slider_parent =' . $slider_id;
                        $totalSlides = $as_DBObj->countTotalData($slides_table_name, $where_count);
                        $totalSlides = $totalSlides + 1;
                        //insert slider
                        $slide_params = new stdClass;
                        $back = new stdClass;
                        $back->type = 'image';
                        $slide_params->slide_name = __('Slide', 'avartan-slider-lite');
                        $slide_params->background = new stdClass;
                        $slide_params->background->type = 'image';
                        $slider_arr = array(
                            'slider_parent' => $slider_id,
                            'params' => maybe_serialize($slide_params),
                            'position' => $totalSlides,
                            'layers' => ''
                        );
                        $output = $as_DBObj->insert($slides_table_name, $slider_arr);

                        if ($output === false) {
                            AvartanSliderLiteFunctions::asAjaxResError(__('Error occure during creating slide.', 'avartan-slider-lite'));
                        } else {
                            AvartanSliderLiteFunctions::asAjaxResSuccessRedirect(__("Slide created successfully", 'avartan-slider-lite'), '', AvartanSliderLiteFunctions::asGetViewRedirectUrl('slide', 'id=' . esc_attr($wpdb->insert_id))); //redirect to slide now
                        }
                        break;

                    case 'delete_slide' :
                        $slider_id = isset($options[0]['slider_id']) ? $options[0]['slider_id'] : '';
                        $slide_id = isset($options[0]['slide_id']) ? $options[0]['slide_id'] : '';
                        $current_slide = isset($options[0]['current_slide']) ? $options[0]['current_slide'] : '';
                        if ($slider_id == '' || $slide_id == '') {
                            AvartanSliderLiteFunctions::asAjaxResError(__('Error occure during deleting slide.', 'avartan-slider-lite'));
                        }
                        $where_count = 'slider_parent =' . $slider_id;
                        $count = $as_DBObj->countTotalData($slides_table_name, $where_count);
                        if ($count > 1) {
                            $where_delete = 'id =' . $slide_id;
                            $output = $as_DBObj->delete($slides_table_name, $where_delete);
                            if ($current_slide == 'yes') {
                                $current_first = $as_DBObj->fetchSingle('id', $slides_table_name, $where_count);
                                $first_slide = $current_first->id;
                                AvartanSliderLiteFunctions::asAjaxResSuccessRedirect(__("Slide deleted successfully", 'avartan-slider-lite'), '', AvartanSliderLiteFunctions::asGetViewRedirectUrl('slide', 'id=' . esc_attr($first_slide)));
                            } else {
                                AvartanSliderLiteFunctions::asAjaxResSuccess(__("Slide deleted successfully.", 'avartan-slider-lite'), 'delete_slide');
                            }
                        } else {
                            AvartanSliderLiteFunctions::asAjaxResError(__('Atleast one slide require.', 'avartan-slider-lite'));
                        }

                        break;

                    

                    case 'update_slide_position':
                        if (count($options) > 0) {
                            foreach ($options as $pos_option) {
                                if (isset($pos_option['slide_position'])) {
                                    $slider_arr = array(
                                        'position' => $pos_option['slide_position']
                                    );
                                    $where = array('id' => $pos_option['slide_id']);
                                    $output = $as_DBObj->update($slides_table_name, $slider_arr, $where);
                                    if ($output === false) {
                                        $output = false;
                                    } else {
                                        $output = true;
                                    }
                                }
                            }
                        }
                        break;

                    case 'preview_slide':
                        $output = '';
                        $options = isset($options[0]) ? $options[0] : array();
                        $slider_id = $options['slider_id'];
                        $select = '*';
                        $from = avsLiteGlobals::$avs_slider_tbl;
                        $where = 'id = \'' . $slider_id . '\'';
                        $as_DBObj = new AvartanSliderLiteCore();
                        $slider = $as_DBObj->getRow($select, $from, $where);

                        if (!$slider) {
                            $output .= __('The slider has not been found', 'avartan-slider-lite');
                        } else {

                            $slider_option = AvartanSliderLiteFunctions::getVal($slider, 'slider_option', array());
                            $slider_option = maybe_unserialize($slider_option);

                            $slider_type = 'standard-slider';

                            $layers = '';

                            //Make HTML for Preview Slide
                            $containerStyle = '';
                            $slider_width = AvartanSliderLiteFunctions::getVal($slider_option, 'start_width', '1280');
                            $slider_height = AvartanSliderLiteFunctions::getVal($slider_option, 'start_height', '650');
                            $containerStyle .= "height:" . $slider_height . "px;";
                            $output .= '<div id="avartanslider-' . $slider_id . '_wrapper" class="avartanslider_wrapper" style="' . $containerStyle . '">';
                            $output .= '<div style="display: none;' . $containerStyle . '" class="avartanslider-slider avartanslider-slider-' . AvartanSliderLiteFunctions::getVal($slider_option, 'layout', '') . '" id="avartanslider-' . $slider_id . '">' . "\n";
                            $output .= '<ul style="display:none;">' . "\n";

                            switch ($slider_type) {
                                case "standard-slider" :
                                    //Get slide setting and set the property
                                    $params = json_decode(stripslashes($options['slide_option']));
                                    $params = maybe_unserialize(maybe_serialize($params));
                                    $params->slide_id = $options['slide_id'].'A';
                                    $params->slider_id = $slider_id;
                                    $elements = array();
                                    //Get Elements of particular slide
                                    if (isset($options['layers'])) {
                                        $layers = json_decode(stripslashes($options['layers']));
                                        $elements = maybe_unserialize(maybe_serialize($layers));
                                    }

                                    $output .= $as_SCObj->avsSlideDetail($params, $elements, true);

                                    break;
                            }
                            $output .= '</ul>' . "\n";

                            $output .= '</div>' . "\n";
                            //Get Responsiveness
                            $mobile_custom_size = 0;        
                            $grid_width = AvartanSliderLiteFunctions::getVal($slider_option,'start_width','1280');

                            $grid_height = AvartanSliderLiteFunctions::getVal($slider_option,'start_height','650');

                            $grid_size = array(
                                'width' => $grid_width,
                                'height' => $grid_height
                            );
                            $output .= '<script type="text/javascript">' . "\n";
                            $output .= '(function($) {' . "\n";
                            $output .= '$(document).ready(function() {' . "\n";
                            $output .= '$("#avartanslider-' . $slider_id . '").avartanSlider({' . "\n";
                            $output .= 'layout: \'' . AvartanSliderLiteFunctions::getVal($slider_option, 'layout', 'fixed') . '\',' . "\n";
                            $output .= 'startWidth: ' . $grid_width . ',' . "\n";
                            $output .= 'startHeight: ' . $grid_height . ',' . "\n";
                            $output .= 'sliderBgColor: \'transparent\',' . "\n";
                            $output .= 'automaticSlide: true,' . "\n";
                            $output .= 'enableSwipe: true,' . "\n";
                            $output .= 'preview: true,' . "\n";
                            $output .= 'showShadowBar: false,' . "\n";
                            $output .= 'shadowClass: \'' . AvartanSliderLiteFunctions::getVal($slider_option, 'shadow_class', '') . '\',' . "\n";
                            $output .= 'pauseOnHover: true,' . "\n";
                            $output .= 'navigation : {' . "\n";
                            $output .= 'arrows: {' . "\n";
                            $output .= 'enable:false,' . "\n";
                            $output .= ' },' . "\n";
                            $output .= 'bullets: {' . "\n";
                            $output .= 'enable:false,' . "\n";
                            $output .= ' }' . "\n";
                            $output .= '}' . ',' . "\n";
                            $output .= '});' . "\n";
                            $output .= '});' . "\n";
                            $output .= '})(jQuery);' . "\n";
                            $output .= '</script>' . "\n";
                            $output .= '</div>' . "\n";
                        }
                        AvartanSliderLiteFunctions::asAjaxResData('preview_output', $output);
                        exit();
                        break;

                    default:

                        AvartanSliderLiteFunctions::throwError(__("wrong ajax action:", 'avartan-slider-lite') . ' ' . esc_attr($user_action));

                        break;
                }
            }
        } catch (Exception $e) {

            $message = $e->getMessage();
            echo $message;
            exit();
        }

        exit();
    }
    
    /**
     * Add ajax back end callback on deactivation reason submission
     *
     * @since 1.3
     */
    public static function avsSbtDeactivationform() {
        //Email To Admin
        $to = 'pluginsd@solwininfotech.com';
        $from = get_option('admin_email');
        $reason_id = $_POST['deactivation_option'];
        $reason_text = $_POST['deactivation_option_text'];
        if ($reason_id == 10) {
            $reason_text = $_POST['deactivation_option_other'];
        }
        $headers = "MIME-Version: 1.0;\r\n";
        $headers .= "From: " . strip_tags($from) . "\r\n";
        $headers .= "Content-Type: text/html; charset: utf-8;\r\n";
        $headers .= "X-Priority: 3\r\n";
        $headers .= "X-Mailer: PHP" . phpversion() . "\r\n";
        $subject = 'User has deactivated Plugin - Avartan Slider Lite';
        $body = '';
        ob_start();
        ?>
        <div style="background: #F5F5F5; border-width: 1px; border-style: solid; padding-bottom: 20px; margin: 0px auto; width: 750px; height: auto; border-radius: 3px 3px 3px 3px; border-color: #5C5C5C;">
            <div style="border: #FFF 1px solid; background-color: #ffffff !important; margin: 20px 20px 0;
                 height: auto; -moz-border-radius: 3px; padding-top: 15px;">
                <div style="padding: 20px 20px 20px 20px; font-family: Arial, Helvetica, sans-serif;
                     height: auto; color: #333333; font-size: 13px;">
                    <div style="width: 100%;">
                        <strong>Dear Admin (Avartan slider plugin developer)</strong>,
                        <br />
                        <br />
                        Thank you for developing useful plugin.
                        <br />
                        <br />
                        I have deactivated plugin because of following reason.
                        <br />
                        <br />
                        <div>
                            <table border='0' cellpadding='5' cellspacing='0' style="font-family: Arial, Helvetica, sans-serif; font-size: 13px;color: #333333;width: 100%;">
                                <tr style="border-bottom: 1px solid #eee;">
                                    <th style="padding: 8px 5px; text-align: left; width: 120px;">
                                        Reason ID<span style="float:right">:</span>
                                    </th>
                                    <td style="padding: 8px 5px;">
        <?php echo $reason_id; ?>
                                    </td>
                                </tr>
                                <tr style="border-bottom: 1px solid #eee;">
                                    <th style="padding: 8px 5px; text-align: left; width: 120px;">
                                        Reason<span style="float:right">:</span>
                                    </th>
                                    <td style="padding: 8px 5px;">
        <?php echo $reason_text; ?>
                                    </td>
                                </tr>
                                <tr style="border-bottom: 1px solid #eee;">
                                    <th style="padding: 8px 5px; text-align: left;width: 120px;">
                                        Website<span style="float:right">:</span>
                                    </th>
                                    <td style="padding: 8px 5px;">
        <?php echo home_url(); ?>
                                    </td>
                                </tr>
                                <tr style="border-bottom: 1px solid #eee;">
                                    <th style="padding: 8px 5px; text-align: left;width: 120px;">
                                        Email<span style="float:right">:</span>
                                    </th>
                                    <td style="padding: 8px 5px;">
        <?php echo $from; ?>
                                    </td>
                                </tr>
                                <tr style="border-bottom: 1px solid #eee;">
                                    <th style="padding: 8px 5px; text-align: left; width: 120px;">
                                        Date<span style="float:right">:</span>
                                    </th>
                                    <td style="padding: 8px 5px;">
        <?php echo date('d-M-Y  h:i  A'); ?>
                                    </td>
                                </tr>
                                <tr style="border-bottom: 1px solid #eee;">
                                    <th style="padding: 8px 5px; text-align: left; width: 120px;">
                                        Plugin<span style="float:right">:</span>
                                    </th>
                                    <td style="padding: 8px 5px;">
        <?php echo 'Avartan Slider'; ?>
                                    </td>
                                </tr>
                            </table>
                            <br /><br />
                            Again Thanks you
                            <br />
                            <br />
                            Regards
                            <br />
        <?php echo home_url(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $body = ob_get_clean();
        wp_mail($to, $subject, $body, $headers);
        exit();
    }

}

new avsLiteAdmin();
?>