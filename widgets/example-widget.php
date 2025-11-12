<?php
namespace Elementor_Neo\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Example Widget
 * 
 * Elementor widget optimized with best practices
 */
class Example_Widget extends Widget_Base {

    /**
     * Get widget name
     */
    public function get_name() {
        return 'neo_example_widget';
    }

    /**
     * Get widget title
     */
    public function get_title() {
        return esc_html__( 'Neo Example', 'elementor-neo' );
    }

    /**
     * Get widget icon
     */
    public function get_icon() {
        return 'eicon-code';
    }

    /**
     * Get widget categories
     */
    public function get_categories() {
        return [ 'neo-elements' ];
    }

    /**
     * Get widget keywords
     */
    public function get_keywords() {
        return [ 'neo', 'example', 'custom' ];
    }

    /**
     * Register widget controls
     */
    protected function register_controls() {

        // Content Section
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Content', 'elementor-neo' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => esc_html__( 'Title', 'elementor-neo' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Example Title', 'elementor-neo' ),
                'placeholder' => esc_html__( 'Enter your title', 'elementor-neo' ),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'description',
            [
                'label' => esc_html__( 'Description', 'elementor-neo' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__( 'Example description text', 'elementor-neo' ),
                'placeholder' => esc_html__( 'Enter your description', 'elementor-neo' ),
                'rows' => 5,
            ]
        );

        $this->end_controls_section();

        // Style Section
        $this->start_controls_section(
            'style_section',
            [
                'label' => esc_html__( 'Style', 'elementor-neo' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Title Color', 'elementor-neo' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .neo-widget-title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .neo-widget-title',
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render widget output on the frontend
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="neo-example-widget">
            <h2 class="neo-widget-title"><?php echo esc_html( $settings['title'] ); ?></h2>
            <div class="neo-widget-description">
                <?php echo wp_kses_post( $settings['description'] ); ?>
            </div>
        </div>
        <?php
    }

    /**
     * Render widget output in the editor
     */
    protected function content_template() {
        ?>
        <div class="neo-example-widget">
            <h2 class="neo-widget-title">{{{ settings.title }}}</h2>
            <div class="neo-widget-description">
                {{{ settings.description }}}
            </div>
        </div>
        <?php
    }
}
