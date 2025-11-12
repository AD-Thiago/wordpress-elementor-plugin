<?php
/**
 * Plugin Name: Elementor Neo Plugin
 * Description: Plugin WordPress otimizado com integração avançada ao Elementor
 * Version: 1.0.0
 * Author: Thiago Cruz
 * Text Domain: elementor-neo
 * Requires PHP: 8.0
 * Requires at least: 6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

define( 'ELEMENTOR_NEO_VERSION', '1.0.0' );
define( 'ELEMENTOR_NEO_FILE', __FILE__ );
define( 'ELEMENTOR_NEO_PATH', plugin_dir_path( __FILE__ ) );
define( 'ELEMENTOR_NEO_URL', plugin_dir_url( __FILE__ ) );

/**
 * Main Plugin Class
 */
final class Elementor_Neo_Plugin {
    
    private static $_instance = null;
    
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
    public function __construct() {
        add_action( 'plugins_loaded', [ $this, 'init' ] );
    }
    
    public function init() {
        // Check if Elementor is installed and activated
        if ( ! did_action( 'elementor/loaded' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_missing_elementor' ] );
            return;
        }
        
        // Check for required Elementor version
        if ( ! version_compare( ELEMENTOR_VERSION, '3.0.0', '>=' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
            return;
        }
        
        // Register custom widgets
        add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );
        
        // Register custom categories
        add_action( 'elementor/elements/categories_registered', [ $this, 'register_categories' ] );
        
        // Enqueue scripts and styles
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
        add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'editor_scripts' ] );
    }
    
    public function admin_notice_missing_elementor() {
        $message = sprintf(
            esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'elementor-neo' ),
            '<strong>' . esc_html__( 'Elementor Neo Plugin', 'elementor-neo' ) . '</strong>',
            '<strong>' . esc_html__( 'Elementor', 'elementor-neo' ) . '</strong>'
        );
        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', wp_kses_post( $message ) );
    }
    
    public function admin_notice_minimum_elementor_version() {
        $message = sprintf(
            esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-neo' ),
            '<strong>' . esc_html__( 'Elementor Neo Plugin', 'elementor-neo' ) . '</strong>',
            '<strong>' . esc_html__( 'Elementor', 'elementor-neo' ) . '</strong>',
            '3.0.0'
        );
        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', wp_kses_post( $message ) );
    }
    
    public function register_widgets( $widgets_manager ) {
        // Include widget files
        require_once( ELEMENTOR_NEO_PATH . 'widgets/example-widget.php' );
        
        // Register widgets
        $widgets_manager->register( new \Elementor_Neo\Widgets\Example_Widget() );
    }
    
    public function register_categories( $elements_manager ) {
        $elements_manager->add_category(
            'neo-elements',
            [
                'title' => esc_html__( 'Neo Elements', 'elementor-neo' ),
                'icon' => 'fa fa-plug',
            ]
        );
    }
    
    public function enqueue_scripts() {
        wp_enqueue_style(
            'elementor-neo-styles',
            ELEMENTOR_NEO_URL . 'assets/css/style.css',
            [],
            ELEMENTOR_NEO_VERSION
        );
        
        wp_enqueue_script(
            'elementor-neo-scripts',
            ELEMENTOR_NEO_URL . 'assets/js/scripts.js',
            [ 'jquery' ],
            ELEMENTOR_NEO_VERSION,
            true
        );
    }
    
    public function editor_scripts() {
        wp_enqueue_script(
            'elementor-neo-editor',
            ELEMENTOR_NEO_URL . 'assets/js/editor.js',
            [ 'jquery' ],
            ELEMENTOR_NEO_VERSION,
            true
        );
    }
}

// Initialize plugin
Elementor_Neo_Plugin::instance();
