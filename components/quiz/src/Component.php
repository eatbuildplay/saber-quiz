<?php

namespace SaberQuiz\Quiz;

class Component {

  public function __construct() {

    add_action('init', [$this, 'registerPostTypes']);

    // load QuizRender
    require_once( SABER_QUIZ_PATH . 'components/quiz/src/QuizRender.php' );
    new QuizRender();

    // load controllers
    require_once( SABER_QUIZ_PATH . 'components/quiz/src/QuizEditor.php' );
    new QuizEditor();

    // load models
    require_once( SABER_QUIZ_PATH . 'components/quiz/src/models/Quiz.php' );
    require_once( SABER_QUIZ_PATH . 'components/quiz/src/models/QuizScore.php' );
    require_once( SABER_QUIZ_PATH . 'components/quiz/src/models/QuizScoreQuestion.php' );

    add_action('wp_enqueue_scripts', array( $this, 'scripts' ));

    add_filter('single_template', [$this, 'singlePageTemplates'] );
    add_action('wp', [$this, 'setGlobals']);

    add_action( 'elementor/widgets/widgets_registered', [ $this, 'initWidgets' ] );

  }

  public function initWidgets() {

    require_once( SABER_QUIZ_PATH . 'components/quiz/widgets/QuizWidget.php' );
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new QuizWidget() );

  }

  public function setGlobals() {

    global $post;

    if ( is_object($post) && $post->post_type == 'quiz' ) {
      $GLOBALS['quiz'] = Model\Quiz::load( $post );
    }

    if ( is_object($post) && $post->post_type == 'quiz_score' ) {
      $GLOBALS['quizScore'] = Model\QuizScore::load( $post );
    }

    if ( is_object($post) && $post->post_type == 'quiz_score_question' ) {
      $GLOBALS['quizScoreQuestion'] = Model\QuizScoreQuestion::load( $post );
    }

  }

  public function singlePageTemplates( $single ) {

    global $post;

    if ( $post->post_type == 'quiz' ) {
      return SABER_QUIZ_PATH . 'components/quiz/templates/singles/quiz.php';
    }

    if ( $post->post_type == 'quiz_score' ) {
      return SABER_QUIZ_PATH . 'components/quiz/templates/singles/quiz_score.php';
    }

    if ( $post->post_type == 'quiz_score_question' ) {
      return SABER_QUIZ_PATH . 'components/quiz/templates/singles/quiz_score_question.php';
    }

    return $single;

  }

  public function scripts() {

    wp_enqueue_script(
      'quiz-js',
      SABER_QUIZ_URL . 'components/quiz/assets/quiz.js',
      array( 'jquery' ),
      '1.0.0',
      true
    );

    wp_localize_script(
      'quiz-js',
      'saberQuiz',
      [ 'ajaxurl' => admin_url('admin-ajax.php') ]
    );

    wp_enqueue_style(
      'quiz-css',
      SABER_QUIZ_URL . 'components/quiz/assets/quiz.css',
      array(),
      true
    );

  }

  public function registerPostTypes() {

    require_once( SABER_QUIZ_PATH . 'components/quiz/src/cpt/QuizPostType.php' );
    $pt = new QuizPostType();
    $pt->register();

    require_once( SABER_QUIZ_PATH . 'components/quiz/src/cpt/QuizScorePostType.php' );
    $pt = new QuizScorePostType();
    $pt->register();

    require_once( SABER_QUIZ_PATH . 'components/quiz/src/cpt/QuizScoreQuestionPostType.php' );
    $pt = new QuizScoreQuestionPostType();
    $pt->register();

  }

}
