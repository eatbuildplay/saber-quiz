<?php

namespace SaberQuiz\Quiz;

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Typography;
use \Elementor\Scheme_Typography;

class QuizWidget extends \Elementor\Widget_Base {

	public function __construct($data = [], $args = null) {

		parent::__construct($data, $args);

		wp_register_script(
			'quiz-elementor',
			SABER_QUIZ_URL . 'components/quiz/assets/quiz-elementor.js',
			[ 'elementor-frontend' ],
			'1.0.0',
			true
		);

	}

	public function get_script_depends() {
		return [ 'quiz-elementor' ];
	}

	public function get_name() {
		return 'saber_quiz';
	}

	public function get_title() {
		return __( 'Quiz', 'saber-quiz' );
	}

	public function get_icon() {
		return 'fa fa-grip-vertical';
	}

	public function get_categories() {
		return [ 'general' ];
	}

  protected function _register_controls() {

		/* Content > Start Page */
    $this->start_controls_section(
			'content_start_page_section',
			[
				'label' => __( 'Start Page', 'saber-quiz' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'start_quiz_button_label',
			[
				'label' => __( 'Start Button Label', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Start Quiz', 'plugin-domain' ),
				'placeholder' => __( 'Start Button Label', 'plugin-domain' ),
			]
		);

		$this->add_control(
			'show_description',
			[
				'label' => __( 'Show Quiz Description', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'your-plugin' ),
				'label_off' => __( 'Hide', 'your-plugin' ),
				'return_value' => '1',
				'default' => '1',
			]
		);

		$this->add_control(
			'start_page_override_quiz_title',
			[
				'label' => __( 'Override Quiz Title', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'your-plugin' ),
				'label_off' => __( 'No', 'your-plugin' ),
				'return_value' => '1',
				'default' => '0',
			]
		);

		$this->add_control(
			'start_page_headline_override',
			[
				'label' => __( 'Start Page Headline', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( '', 'plugin-domain' ),
				'placeholder' => __( 'Start Page Headline', 'plugin-domain' ),
				'condition' => [
        	'start_page_override_quiz_title' => '1'
        ],
			]
		);

    $this->end_controls_section();

    /* Style > Start Page */
    $this->start_controls_section(
			'start_page_section',
			[
				'label' => __( 'Start Page', 'saber-quiz' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		/* Style > Start Page > Headline */
		$this->add_control(
			'start_page_headline_heading',
			array(
				'label'     => esc_html__( 'Headline/Title', 'saber-quiz' ),
				'type'      => Controls_Manager::HEADING,
      )
		);

    $this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'label' => 'Headline Typography',
				'name'     => 'start_header_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} ' . '.quiz-start-page h1',
			)
    );

		$this->add_control(
			'start_page_headline_text_color',
			array(
				'label'     => esc_html__( 'Headline Text Color', 'saber-quiz' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
          '{{WRAPPER}} ' . '.quiz-start-page h1' => 'color: {{VALUE}}',
        ]
      )
		);

		/* Style > Start Page > Start Button */
		$this->add_control(
			'start_page_start_button_heading',
			array(
				'label'     => esc_html__( 'Start Button', 'saber-quiz' ),
				'type'      => Controls_Manager::HEADING,
      )
		);

    $this->start_controls_tabs( 'start_button_styles' );

    $this->start_controls_tab(
			'start_button_style_normal',
			array(
				'label' => esc_html__( 'Normal', 'saber-quiz' ),
			)
		);

		$this->add_control(
			'start_button_text_color',
			array(
				'label'     => esc_html__( 'Button Text Color', 'saber-quiz' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
          '{{WRAPPER}} ' . '.quiz-start-page button' => 'color: {{VALUE}}',
        ]
      )
		);

    $this->add_control(
			'start_button_background_color',
			array(
				'label'     => esc_html__( 'Button Background Color', 'saber-quiz' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
          '{{WRAPPER}} ' . '.quiz-start-page button' => 'background-color: {{VALUE}}',
        ]
      ),
			25
		);

    $this->end_controls_tab();

		/* Style > Start Page > Start Button > Hover */
    $this->start_controls_tab(
			'start_button_style_hover',
			array(
				'label' => esc_html__( 'Hover', 'saber-quiz' ),
			)
		);

		$this->add_control(
			'start_button_text_color_hover',
			array(
				'label'     => esc_html__( 'Button Text Color', 'saber-quiz' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
          '{{WRAPPER}} ' . '.quiz-start-page button:hover' => 'color: {{VALUE}}',
        ]
      )
		);

    $this->add_control(
			'start_button_background_color_hover',
			array(
				'label'     => esc_html__( 'Button Background Color', 'saber-quiz' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
          '{{WRAPPER}} ' . '.quiz-start-page button:hover' => 'background-color: {{VALUE}}',
        ]
      ),
			25
		);

    $this->end_controls_tab();
    $this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'start_button_border',
				'selector' => '{{WRAPPER}} ' . '.quiz-start-page button',
			)
    );

		$this->add_control(
			'start_page_general_heading',
			array(
				'label'     => esc_html__( 'General Styles', 'saber-quiz' ),
				'type'      => Controls_Manager::HEADING,
      )
		);

		$this->add_responsive_control(
      'end_page_headline_align',
      [
        'label' => __( 'Alignment', 'elementor' ),
        'type' => Controls_Manager::CHOOSE,
        'options' => [
          'left' => [
            'title' => __( 'Left', 'elementor' ),
            'icon' => 'eicon-text-align-left',
          ],
          'center' => [
            'title' => __( 'Center', 'elementor' ),
            'icon' => 'eicon-text-align-center',
          ],
          'right' => [
            'title' => __( 'Right', 'elementor' ),
            'icon' => 'eicon-text-align-right',
          ],
        ],
        'selectors' => [
          '{{WRAPPER}} .quiz-start-page' => 'text-align: {{VALUE}}',
        ],
      ]
    );

    $this->end_controls_section();

    /* Style > End Page */
    $this->start_controls_section(
			'end_page_section',
			[
				'label' => __( 'End Page', 'saber-quiz' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		/* Style > End Page > Headline */
		$this->add_control(
			'end_page_headline_heading',
			array(
				'label'     => esc_html__( 'Headline', 'saber-quiz' ),
				'type'      => Controls_Manager::HEADING,
      )
		);

		$this->add_responsive_control(
      'end_page_headline_align',
      [
        'label' => __( 'Alignment', 'elementor' ),
        'type' => Controls_Manager::CHOOSE,
        'options' => [
          'left' => [
            'title' => __( 'Left', 'elementor' ),
            'icon' => 'eicon-text-align-left',
          ],
          'center' => [
            'title' => __( 'Center', 'elementor' ),
            'icon' => 'eicon-text-align-center',
          ],
          'right' => [
            'title' => __( 'Right', 'elementor' ),
            'icon' => 'eicon-text-align-right',
          ],
        ],
        'selectors' => [
          '{{WRAPPER}} .quiz-end-page h2' => 'text-align: {{VALUE}}',
        ],
      ]
    );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'end_page_headline_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} ' . '.quiz-end-page h2',
			)
    );

		$this->add_control(
			'end_page_headline_text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'saber-quiz' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
          '{{WRAPPER}} ' . '.quiz-end-page h2' => 'color: {{VALUE}}',
        ]
      )
		);

		/* Style > End Page > Body Text */
		$this->add_control(
			'end_page_body_heading',
			array(
				'label'     => esc_html__( 'Body', 'saber-quiz' ),
				'type'      => Controls_Manager::HEADING,
      )
		);

		$this->add_responsive_control(
      'end_page_body_align',
      [
        'label' => __( 'Alignment', 'elementor' ),
        'type' => Controls_Manager::CHOOSE,
        'options' => [
          'left' => [
            'title' => __( 'Left', 'elementor' ),
            'icon' => 'eicon-text-align-left',
          ],
          'center' => [
            'title' => __( 'Center', 'elementor' ),
            'icon' => 'eicon-text-align-center',
          ],
          'right' => [
            'title' => __( 'Right', 'elementor' ),
            'icon' => 'eicon-text-align-right',
          ],
        ],
        'selectors' => [
          '{{WRAPPER}} .quiz-end-page .quiz-end-page-body' => 'text-align: {{VALUE}}',
        ],
      ]
    );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'end_page_body_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} ' . '.quiz-end-page .quiz-end-page-body',
			)
    );

		$this->add_control(
			'end_page_body_text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'saber-quiz' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
          '{{WRAPPER}} ' . '.quiz-end-page .quiz-end-page-body' => 'color: {{VALUE}}',
        ]
      )
		);

		/* Restart Button Styles */
    $this->start_controls_tabs( 'restart_button_styles' );

    $this->start_controls_tab(
			'restart_button_style_normal',
			array(
				'label' => esc_html__( 'Normal', 'saber-quiz' ),
			)
		);

    $this->add_control(
			'restart_button_background_color',
			array(
				'label'     => esc_html__( 'Button Background Color', 'saber-quiz' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
          '{{WRAPPER}} ' . '.quiz-control-restart' => 'background-color: {{VALUE}}',
        ]
      ),
			25
		);

    $this->end_controls_tab();

    $this->start_controls_tab(
			'restart_button_style_hover',
			array(
				'label' => esc_html__( 'Hover', 'saber-quiz' ),
			)
		);

    $this->add_control(
			'restart_button_background_color_hover',
			array(
				'label'     => esc_html__( 'Button Background Color', 'saber-quiz' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
          '{{WRAPPER}} ' . '.quiz-control-restart:hover' => 'background-color: {{VALUE}}',
        ]
      ),
			25
		);

    $this->end_controls_tab();
    $this->end_controls_tabs();

    $this->end_controls_section();

    /* Style > Question Page */
    $this->start_controls_section(
			'question_display_section',
			[
				'label' => __( 'Question Page', 'saber-quiz' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

    $this->add_control(
			'quiz_controls_question_number_heading',
			array(
				'label'     => esc_html__( 'Question Number', 'saber-quiz' ),
				'type'      => Controls_Manager::HEADING,
      )
		);

    $this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'question_number_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} ' . '.question h3',
			)
    );

    $this->add_control(
			'quiz_controls_question_body_heading',
			array(
				'label'     => esc_html__( 'Question Body', 'saber-quiz' ),
				'type'      => Controls_Manager::HEADING,
      )
		);

    $this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'question_body_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} ' . '.question h1',
			)
    );

    $this->add_control(
			'quiz_controls_quiz_controls_heading',
			array(
				'label'     => esc_html__( 'Quiz Control Buttons', 'saber-quiz' ),
				'type'      => Controls_Manager::HEADING,
      )
		);

    $this->add_control(
			'quiz_controls_button_color',
			array(
				'label'     => esc_html__( 'Button Text Color', 'saber-quiz' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
          '{{WRAPPER}} ' . '.quiz-controls button' => 'color: {{VALUE}}',
        ]
      )
		);

    $this->add_control(
			'quiz_controls_button_background_color',
			array(
				'label'     => esc_html__( 'Button Background Color', 'saber-quiz' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
          '{{WRAPPER}} ' . '.quiz-controls button' => 'background-color: {{VALUE}}',
        ]
      )
		);

    /* Style > Question Page > Question Options */

    $this->add_control(
			'quiz_controls_option_heading',
			array(
				'label'     => esc_html__( 'Question Options', 'saber-quiz' ),
				'type'      => Controls_Manager::HEADING,
      )
		);

    $this->add_control(
			'question_question_option_background_color',
			array(
				'label'     => esc_html__( 'Background Color', 'saber-quiz' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
          '{{WRAPPER}} ' . '.question .question-option' => 'background-color: {{VALUE}}',
        ]
      )
		);

    $this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'question_question_option_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} ' . '.question .question-option',
			)
    );

    $this->add_control(
			'question_question_option_text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'saber-quiz' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
          '{{WRAPPER}} ' . '.question .question-option' => 'color: {{VALUE}}',
        ]
      )
		);

    $this->add_responsive_control(
      'question_question_option_align',
      [
        'label' => __( 'Alignment', 'elementor' ),
        'type' => Controls_Manager::CHOOSE,
        'options' => [
          'left' => [
            'title' => __( 'Left', 'elementor' ),
            'icon' => 'eicon-text-align-left',
          ],
          'center' => [
            'title' => __( 'Center', 'elementor' ),
            'icon' => 'eicon-text-align-center',
          ],
          'right' => [
            'title' => __( 'Right', 'elementor' ),
            'icon' => 'eicon-text-align-right',
          ],
        ],
        'selectors' => [
          '{{WRAPPER}} .question .question-option' => 'text-align: {{VALUE}}',
        ],
      ]
    );

    $this->end_controls_section();

	}

  protected function render() {

		$settings = $this->get_settings_for_display();

		$quizId = 32;
		$quizRender = new QuizRender();

		if ( \Elementor\Plugin::instance()->editor->is_edit_mode() ) {
			$quizRender->renderPreview( $quizId, $settings );
		} else {
	    $quizRender->render( $quizId, $settings );
		}

	}

}
