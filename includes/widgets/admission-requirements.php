<?php
namespace Admission_Sight_Addon;

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
class Admission_Requirements extends \Elementor\Widget_Base {

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
		return 'admission-requirements';
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
		return esc_html__( 'Admission Requirements', 'admissionsight-addon' );
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
		return [ 'basic', 'admissionsight' ];
	}

	// Load CSS
	public function get_style_depends() {

		wp_register_style( 'admission-requirements', plugins_url( '../assets/css/admission-requirements.css', __FILE__ ));

		return [
			'admission-requirements',
		];

	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the oEmbed widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget keywords.
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
				'label' => esc_html__( 'Content', 'admissionsight-addon' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'list',
			[
				'label' => esc_html__( 'List', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => [
					[
						'name' => 'text',
						'label' => esc_html__( 'Text', 'textdomain' ),
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => esc_html__( 'List Item', 'textdomain' ),
						'default' => esc_html__( 'List Item', 'textdomain' ),
					],
					[
						'name' => 'link',
						'label' => esc_html__( 'Link', 'textdomain' ),
						'type' => \Elementor\Controls_Manager::URL,
						'placeholder' => esc_html__( 'https://your-link.com', 'textdomain' ),
					],
				],
				'default' => [
					[
						'text' => esc_html__( 'List Item #1', 'textdomain' ),
						'link' => 'https://elementor.com/',
					],
					[
						'text' => esc_html__( 'List Item #2', 'textdomain' ),
						'link' => 'https://elementor.com/',
					],
				],
				'title_field' => '{{{ text }}}',
			]
		);

		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'admissionsight-addon' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Default title', 'admissionsight-addon' ),
				'placeholder' => esc_html__( 'Type your title here', 'admissionsight-addon' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'link_text',
			[
				'label' => esc_html__( 'Link Text', 'admissionsight-addon' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Default text', 'admissionsight-addon' ),
				'placeholder' => esc_html__( 'Type your link text', 'admissionsight-addon' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'link',
			[
				'label' => esc_html__( 'Link', 'admissionsight-addon' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'admissionsight-addon' ),
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
					'custom_attributes' => '',
				],
				'label_block' => true,
			]
		);

		$this->add_control(
			'image',
			[
				'label' => esc_html__( 'Choose Image', 'admissionsight-addon' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

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
	?>

	<div class="admissionsight-statistics-tabs">
		<ul class="nav nav-tabs" id="myTab" role="tablist">
			<li class="nav-item" role="presentation">
				<button class="nav-link active" id="overview" data-bs-toggle="tab" data-bs-target="#overview-pane" type="button" role="tab" aria-controls="overview-pane" aria-selected="true">Overview</button>
			</li>
			<li class="nav-item" role="presentation">
				<button class="nav-link" id="admission" data-bs-toggle="tab" data-bs-target="#admission-pane" type="button" role="tab" aria-controls="admission-pane" aria-selected="false">Admission</button>
			</li>
			<li class="nav-item" role="presentation">
				<button class="nav-link" id="cost" data-bs-toggle="tab" data-bs-target="#cost-pane" type="button" role="tab" aria-controls="cost-pane" aria-selected="false">Cost</button>
			</li>
			<li class="nav-item" role="presentation">
				<button class="nav-link" id="majors" data-bs-toggle="tab" data-bs-target="#majors-pane" type="button" role="tab" aria-controls="cost-pane" aria-selected="false">Majors</button>
			</li>
			<li class="nav-item" role="presentation">
				<button class="nav-link" id="diversity" data-bs-toggle="tab" data-bs-target="#diversity-pane" type="button" role="tab" aria-controls="diversity-pane" aria-selected="false">Diversity</button>
			</li>
			<li class="nav-item" role="presentation">
				<button class="nav-link" id="outcomes" data-bs-toggle="tab" data-bs-target="#outcomes-pane" type="button" role="tab" aria-controls="outcomes-pane" aria-selected="false">Outcomes</button>
			</li>
			<li class="nav-item" role="presentation">
				<button class="nav-link" id="salaries" data-bs-toggle="tab" data-bs-target="#salaries-pane" type="button" role="tab" aria-controls="salaries-pane" aria-selected="false">Salaries</button>
			</li>
		</ul>
		<div class="tab-content" id="myTabContent">
			<div class="tab-pane fade show active" id="overview-pane" role="tabpanel" aria-labelledby="overview" tabindex="0">
				Lorem ipsum dolor sit amet consectetur adipisicing elit. Commodi consectetur dolor animi sapiente aliquid sed laborum. Doloribus tenetur sed officia.
			</div>
			<div class="tab-pane fade" id="admission-pane" role="tabpanel" aria-labelledby="admission" tabindex="0">
				<h1>Title here</h1> Lorem 	ipsum dolor sit amet consectetur adipisicing elit. Beatae temporibus architecto sed iusto optio obcaecati corrupti, voluptatum aliquam iure. Blanditiis debitis architecto ab omnis deleniti totam tempora sed, exercitationem provident.
			</div>
			<div class="tab-pane fade" id="cost-pane" role="tabpanel" aria-labelledby="cost" tabindex="0">
				Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem dolores quibusdam nulla quo quam consequuntur a maxime numquam perferendis illo! Eius id magni culpa dolore fuga rerum perferendis delectus, harum impedit beatae voluptatem consequatur quasi quae tenetur voluptate tempore laborum pariatur error enim! Illum voluptas numquam illo suscipit eum deleniti.
			</div>
			<div class="tab-pane fade" id="majors-pane" role="tabpanel" aria-labelledby="majors" tabindex="0">
				Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem dolores quibusdam nulla quo quam consequuntur a maxime numquam perferendis illo! Eius id magni culpa dolore fuga rerum perferendis delectus, harum impedit beatae voluptatem consequatur quasi quae tenetur voluptate tempore laborum pariatur error enim! Illum voluptas numquam illo suscipit eum deleniti.
			</div>
			<div class="tab-pane fade" id="diversity-pane" role="tabpanel" aria-labelledby="diversity" tabindex="0">
				Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem dolores quibusdam nulla quo quam consequuntur a maxime numquam perferendis illo! Eius id magni culpa dolore fuga rerum perferendis delectus, harum impedit beatae voluptatem consequatur quasi quae tenetur voluptate tempore laborum pariatur error enim! Illum voluptas numquam illo suscipit eum deleniti.
			</div>
			<div class="tab-pane fade" id="outcomes-pane" role="tabpanel" aria-labelledby="outcomes" tabindex="0">
				Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem dolores quibusdam nulla quo quam consequuntur a maxime numquam perferendis illo! Eius id magni culpa dolore fuga rerum perferendis delectus, harum impedit beatae voluptatem consequatur quasi quae tenetur voluptate tempore laborum pariatur error enim! Illum voluptas numquam illo suscipit eum deleniti.
			</div>
			<div class="tab-pane fade" id="salaries-pane" role="tabpanel" aria-labelledby="salaries" tabindex="0">
				Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem dolores quibusdam nulla quo quam consequuntur a maxime numquam perferendis illo! Eius id magni culpa dolore fuga rerum perferendis delectus, harum impedit beatae voluptatem consequatur quasi quae tenetur voluptate tempore laborum pariatur error enim! Illum voluptas numquam illo suscipit eum deleniti.
			</div>
		</div>
	</div>


	<?php

	}

}