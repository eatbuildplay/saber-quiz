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

    $this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'saber-quiz' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
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

    $this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'start_header_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} ' . '.quiz-single-start h2',
			)
    );

    $this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'start_button_border',
				'selector' => '{{WRAPPER}} ' . '.quiz-single-start button',
			)
    );

    $this->add_control(
			'start_button_color',
			array(
				'label'     => esc_html__( 'Button Text Color', 'saber-quiz' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
          '{{WRAPPER}} ' . '.quiz-single-start button' => 'color: {{VALUE}}',
        ]
      )
		);

		/* Start Button Styles */
    $this->start_controls_tabs( 'start_button_styles' );

    $this->start_controls_tab(
			'start_button_style_normal',
			array(
				'label' => esc_html__( 'Normal', 'saber-quiz' ),
			)
		);

    $this->add_control(
			'start_button_background_color',
			array(
				'label'     => esc_html__( 'Button Background Color', 'saber-quiz' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
          '{{WRAPPER}} ' . '.quiz-single-start button' => 'background-color: {{VALUE}}',
        ]
      ),
			25
		);

    $this->end_controls_tab();

    $this->start_controls_tab(
			'start_button_style_hover',
			array(
				'label' => esc_html__( 'Hover', 'saber-quiz' ),
			)
		);

    $this->add_control(
			'start_button_background_color_hover',
			array(
				'label'     => esc_html__( 'Button Background Color', 'saber-quiz' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
          '{{WRAPPER}} ' . '.quiz-single-start button:hover' => 'background-color: {{VALUE}}',
        ]
      ),
			25
		);

    $this->end_controls_tab();
    $this->end_controls_tabs();
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
		$quizRender = new QuizRender();

		if ( \Elementor\Plugin::instance()->editor->is_edit_mode() ) {

			$quizRender->renderElementorCanvas();

			$quizRender->renderElementorQuestionPage();
			$quizRender->renderElementorDivider();
			$quizRender->renderElementorStartPage();
			$quizRender->renderElementorDivider();
			$quizRender->renderElementorEndPage();

		} else {
			$quizId = 32;
	    $quizRender->render( $quizId );
		}

	}

}
