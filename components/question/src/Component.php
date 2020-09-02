<?php

namespace SaberQuiz\Question;

class Component {

  public function __construct() {

    add_action('init', [$this, 'registerPostTypes']);

    // load controllers
    require_once( SABER_QUIZ_PATH . 'components/question/src/QuestionEditor.php' );
    new QuestionEditor();

    // load models
    require_once( SABER_QUIZ_PATH . 'components/question/src/models/Question.php' );
    require_once( SABER_QUIZ_PATH . 'components/question/src/models/QuestionAnswer.php' );
    require_once( SABER_QUIZ_PATH . 'components/question/src/models/QuestionOption.php' );

    add_filter('single_template', [$this, 'singlePageTemplates'] );
    add_action('wp', [$this, 'setGlobals']);

  }

  public function setGlobals() {

    global $post;

    if ( is_object($post) && $post->post_type == 'question' ) {
      $GLOBALS['question'] = \SaberQuiz\Quiz\Model\Quiz::load( $post );
    }

  }

  public function singlePageTemplates( $single ) {

    global $post;

    if ( $post->post_type == 'question' ) {
      return SABER_QUIZ_PATH . 'components/question/templates/singles/question.php';
    }

    return $single;

  }

  public function registerPostTypes() {

    require_once( SABER_QUIZ_PATH . 'components/question/src/cpt/QuestionPostType.php' );
    $pt = new QuestionPostType();
    $pt->register();

    require_once( SABER_QUIZ_PATH . 'components/question/src/cpt/QuestionAnswerPostType.php' );
    $pt = new QuestionAnswerPostType();
    $pt->register();

    require_once( SABER_QUIZ_PATH . 'components/question/src/cpt/QuestionOptionPostType.php' );
    $pt = new QuestionOptionPostType();
    $pt->register();

  }

}
