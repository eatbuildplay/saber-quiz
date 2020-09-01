<?php

namespace SaberQuiz\Quiz;

class QuizSingleShortcode {

  public $tag = 'quiz-single';

  public function __construct() {

    add_action('init', array( $this, 'init'));

    add_action( 'wp_ajax_saber_quiz_record_answer', array( $this, 'jxRecordAnswer'));
    add_action( 'wp_ajax_saber_quiz_question_load', array( $this, 'jxQuestionLoad'));
    add_action( 'wp_ajax_saber_quiz_quiz_load', array( $this, 'jxQuizLoad'));
    add_action( 'wp_ajax_saber_quiz_create_quiz_score', array( $this, 'jxQuizScoreCreate'));
    add_action( 'wp_ajax_saber_quiz_end', array( $this, 'jxQuizEnd'));

  }

  public function jxQuizEnd() {

    $quizId = $_POST['quizId'];

    $response = array();
    print json_encode( $response );

    do_action('saber_quiz_end', $quizId );

    wp_die();

  }

  public function jxRecordAnswer() {

    $quizScoreId = sanitize_text_field( $_POST['quizScoreId'] );

    // add QuestionAnswer
    $questionAnswer = new Model\QuestionAnswer();
    $questionAnswer->question = sanitize_text_field( $_POST['questionId'] );
    $questionAnswer->questionOption = sanitize_text_field( $_POST['questionOptionId'] );
    $questionAnswer->save();

    // add related QuizQuestionScore
    $scoreQuestion = new Model\QuizScoreQuestion();
    $scoreQuestion->title = "ESQ-".time();
    $scoreQuestion->quizScore = $quizScoreId;
    $scoreQuestion->questionAnswer = $questionAnswer;

    // do marking
    $isCorrect = 0;
    $questionPost = get_post( $questionAnswer->question );
    $question = Model\Question::load( $questionPost );
    if( $questionAnswer->questionOption == $question->correct[0] ) {
      $isCorrect = 1;
    }
    $scoreQuestion->correct = $isCorrect;

    // award point(s)
    if( $isCorrect ) {
      $scoreQuestion->points = 1;
    }
    $scoreQuestion->save();

    // load updated QuizScore model
    $quizScore = \SaberQuiz\Quiz\Model\QuizScore::load( $quizScoreId );

    $response = array(
      'isCorrect' => $isCorrect,
      'question' => $question,
      'quizScore' => $quizScore,
      'message' => 'Your answer was marked.'
    );
    print json_encode( $response );

    wp_die();

  }

  public function jxQuizScoreCreate() {

    $quizId = intval( $_POST['quizId'] );

    // create quiz score
    $quizScore = new \SaberQuiz\Quiz\Model\QuizScore;
    $quizScore->quiz = $quizId;
    $quizScore->save();

    $response = array(
      'quizScore' => $quizScore,
    );
    print json_encode( $response );

    wp_die();

  }

  public function jxQuizLoad() {

    $quizId = $_POST['quizId'];
    $quiz = Model\Quiz::load( $quizId );

    $response = array(
      'quiz' => $quiz
    );
    print json_encode( $response );

    wp_die();

  }

  public function jxQuestionLoad() {

    $questionId = $_POST['questionId'];
    $question = Model\Question::load( $questionId );

    $response = array(
      'question' => $question
    );
    print json_encode( $response );

    wp_die();

  }

  public function init() {

    add_shortcode($this->tag, array($this, 'doShortcode'));

  }

  public function doShortcode( $atts = [] ) {

    if( isset( $atts['id'] )) {
      $quizId = $atts['id'];
      $quiz = Model\Quiz::load( $quizId );
    } else {
      global $post;
      $quiz = Model\Quiz::load( $post->ID );
    }

    $template = new \SaberQuiz\Template();
    $template->path = 'components/quiz/templates/';

    $content = '';

    // main template
    $template->name = 'quiz-single';
    $template->data = array(
      'quiz' => $quiz,
      'quizFields' => $quizFields
    );
    $content .= $template->get();

    // quiz controls template
    $template->name = 'quiz-single-controls';
    $template->data = array();
    $content .= $template->get();

    // question template
    $template->name = 'question-single';
    $content .= $template->get();

    // question options template
    $template->name = 'question-option-single';
    $content .= $template->get();

    // start screen template
    $template->name = 'quiz-single-start';
    $template->data = array();
    $content .= $template->get();

    // end screen template
    $template->name = 'quiz-single-end';
    $template->data = array();
    $content .= $template->get();

    // quiz score results
    $template->path = 'components/quiz/templates/parts/';
    $template->name = 'quiz-score-results';
    $template->data = array();
    $content .= $template->get();

    return $content;

  }

}
