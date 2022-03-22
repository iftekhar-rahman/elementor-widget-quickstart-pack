<?php
namespace RRF_Commerce_Addon;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor oEmbed Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class RRFCommerce_Slides extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve oEmbed widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'slides';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve oEmbed widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'RRF Commerce Slides', 'rrf-commerce-addon' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve oEmbed widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-code';
	}


	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the oEmbed widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'basic', 'rrfcommerce' ];
	}

	// Load CSS
	public function get_style_depends() {

		wp_register_style( 'slick-main-css', plugins_url( '../assets/css/slick.css', __FILE__ ));
		wp_register_style( 'slick-theme-css', plugins_url( '../assets/css/slick-theme.css', __FILE__ ));
		wp_register_style( 'slide-css', plugins_url( '../assets/css/slides.css', __FILE__ ) );

		return [
			'slick-main-css',
			'slick-theme-css',
			'slide-css',
		];

	}

	// Load JS
	public function get_script_depends() {

		wp_register_script( 'slick-js', plugins_url( '../assets/js/slick.min.js', __FILE__ ), [ 'jquery' ] );

		return [
			'slick-js',
		];

	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the oEmbed widget belongs to.
	 */
	// public function get_keywords() {
	// 	return [ 'oembed', 'url', 'link' ];
	// }

	/**
	 * Register oEmbed widget controls.
	 *
	 * Add input fields to allow the user to customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'rrf-commerce-addon' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'slide_banner',
			[
				'label' => esc_html__( 'Choose Image', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'slide_content', [
				'label' => esc_html__( 'Content', 'rrf-commerce-addon' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'List Content' , 'rrf-commerce-addon' ),
				'show_label' => true,
			]
		);

		$repeater->add_control(
			'slide_title', [
				'label' => esc_html__( 'Title', 'rrf-commerce-addon' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'List Title' , 'rrf-commerce-addon' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'slide_desc', [
				'label' => esc_html__( 'Description', 'rrf-commerce-addon' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Description' , 'rrf-commerce-addon' ),
				'label_block' => true,
			]
		);

		

		// $repeater->add_control(
		// 	'list_color',
		// 	[
		// 		'label' => esc_html__( 'Color', 'rrf-commerce-addon' ),
		// 		'type' => \Elementor\Controls_Manager::COLOR,
		// 		'selectors' => [
		// 			'{{WRAPPER}} {{CURRENT_ITEM}}' => 'color: {{VALUE}}'
		// 		],
		// 	]
		// );

		$this->add_control(
			'slides',
			[
				'label' => esc_html__( 'Repeater List', 'rrf-commerce-addon' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'slide_title' => esc_html__( 'Title #1', 'rrf-commerce-addon' ),
						'slide_content' => esc_html__( 'Item content. Click the edit button to change this text.', 'rrf-commerce-addon' ),
					]
				],
				'title_field' => '{{{ slide_title }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'settings_section',
			[
				'label' => esc_html__( 'Settings Control', 'plugin-name' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'fade',
			[
				'label' => esc_html__( 'Fade', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'your-plugin' ),
				'label_off' => esc_html__( 'No', 'your-plugin' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);
		$this->add_control(
			'dots',
			[
				'label' => esc_html__( 'Dots', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'your-plugin' ),
				'label_off' => esc_html__( 'No', 'your-plugin' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);
		$this->add_control(
			'arrows',
			[
				'label' => esc_html__( 'Arrows', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'your-plugin' ),
				'label_off' => esc_html__( 'No', 'your-plugin' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
		$this->add_control(
			'autoplay',
			[
				'label' => esc_html__( 'Autoplay', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'your-plugin' ),
				'label_off' => esc_html__( 'No', 'your-plugin' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);
		// $this->add_control(
		// 	'autoplay_time',
		// 	[
		// 		'label' => esc_html__( 'Autoplay Time', 'plugin-name' ),
		// 		'type' => \Elementor\Controls_Manager::SWITCHER,
		// 		'default' => '5000',
		// 		'condition' => [
		// 			'autoplay'	=> 'yes',	
		// 		]
		// 	]
		// );

		

		$this->end_controls_section();

	}


	/**
	 * Render oEmbed widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();

		$dynamic_id = rand(21323,45465);
		// if(count($settings['slides'] > 1)){
			if($settings['fade'] === 'yes'){
				$fade = 'true';
			} else{
				$fade = 'false';
			}
			if($settings['dots'] === 'yes'){
				$dots = 'true';
			} else{
				$dots = 'false';
			}
			if($settings['arrows'] === 'yes'){
				$arrows = 'true';
			} else{
				$arrows = 'false';
			}
			if($settings['autoplay'] === 'yes'){
				$autoplay = 'true';
			} else{
				$autoplay = 'false';
			}
			echo '<script>
				jQuery(document).ready(function($){
					$("#slides-'.$dynamic_id.'").slick({
						fade: '.$fade.',
						dots: '.$dots.',
						infinite: true,
						arrows: '.$arrows.',
						autoplay: '.$autoplay.',
						slidesToShow: 1,
						prevArrow: "<span class=\'arrow left\'><i class=\'fa fa-angle-left\'></i></span>",
						nextArrow: "<span class=\'arrow right\'><i class=\'fa fa-angle-right\'></i></span>",
					});
				});
			</script>';
			
		// }
	?>
	<?php if($settings['slides']) { ?>
	<div id="slides-<?php echo $dynamic_id; ?>" class="slides">
		<?php foreach($settings['slides'] as $slide) { ?>
		<div class="single-slide-item" style="background-image: url(<?php echo wp_get_attachment_image_url( $slide['slide_banner']['id'], 'large' ); ?>)">
			<div class="row">
				<div class="col my-auto text-center">
					<h2><?php echo _e( $slide['slide_content'] ); ?></h2>
				</div>
			</div>
			<div class="slide-info">
				<h4><?php echo _e( $slide['slide_title'] ); ?></h4>
				<p><?php echo _e( $slide['slide_desc'] ); ?></p>
			</div>
		</div>
		<?php } ?>
	</div>
	<?php }; ?>
	<?php

	}

}