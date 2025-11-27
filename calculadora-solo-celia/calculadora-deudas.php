<?php
/**
 * Plugin Name: Calculadora de Deudas (Celia)
 * Description: Calculadora de Deudas para Debalia (Debify). Creado por y para recoger info de leads y enviarla automáticamente a Hubspot.
 * Version: 1.0
 * Author: <a href="https://www.gsobregrau.com">Gerard Sobregrau</a>    
 */

function cc_enqueue_assets() {
    wp_enqueue_style('cc-styles', plugin_dir_url(__FILE__) . 'css/styles.css');
    wp_enqueue_script('cc-scripts', plugin_dir_url(__FILE__) . 'js/scripts.js', array(), false, true);
}
add_action('wp_enqueue_scripts', 'cc_enqueue_assets');

function cc_formulario_shortcode() {
    ob_start();
    include plugin_dir_path(__FILE__) . 'includes/formulario.php';
    return ob_get_clean();
}
// Register shortcode -> [calculadora-celia]
add_shortcode('calculadora-celia', 'cc_formulario_shortcode');
