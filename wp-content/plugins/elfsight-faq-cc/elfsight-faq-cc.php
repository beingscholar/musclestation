<?php
/*
Plugin Name: Elfsight FAQ CC
Description: Anticipate your clients’ questions and eliminate their doubts with easy-to-use FAQ
Plugin URI: https://elfsight.com/accordion-faq-widget/wordpress/?utm_source=markets&utm_medium=codecanyon&utm_campaign=faq&utm_content=plugin-site
Version: 1.3.0
Author: Elfsight
Author URI: https://elfsight.com/?utm_source=markets&utm_medium=codecanyon&utm_campaign=faq&utm_content=plugins-list
*/

if (!defined('ABSPATH')) exit;


require_once('core/elfsight-plugin.php');

$elfsight_faq_config_path = plugin_dir_path(__FILE__) . 'config.json';
$elfsight_faq_config = json_decode(file_get_contents($elfsight_faq_config_path), true);

new ElfsightFaqPlugin(array(
        'name' => esc_html__('FAQ'),
        'description' => esc_html__('Anticipate your clients’ questions and eliminate their doubts with easy-to-use FAQ'),
        'slug' => 'elfsight-faq',
        'version' => '1.3.0',
        'text_domain' => 'elfsight-faq',
        'editor_settings' => $elfsight_faq_config['settings'],
        'editor_preferences' => $elfsight_faq_config['preferences'],

        'plugin_name' => esc_html__('Elfsight FAQ'),
        'plugin_file' => __FILE__,
        'plugin_slug' => plugin_basename(__FILE__),

        'vc_icon' => plugins_url('assets/img/vc-icon.png', __FILE__),
        'menu_icon' => plugins_url('assets/img/menu-icon.png', __FILE__),

        'update_url' => esc_url('https://a.elfsight.com/updates/v1/'),
        'product_url' => esc_url('https://codecanyon.net/item/accordion-faq-plugin-for-wordpress/21844250?ref=Elfsight'),
        'helpscout_plugin_id' => 110707
    )
);

?>
