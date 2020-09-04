<?php

namespace SaberQuiz\Quiz;

class QuizRender {

  public function __construct() {

    add_action( 'wp_ajax_saber_quiz_quiz_load', array( $this, 'jxQuizLoad'));
    add_action( 'wp_ajax_saber_quiz_create_quiz_score', array( $this, 'jxQuizScoreCreate'));
    add_action( 'wp_ajax_saber_quiz_record_answer', array( $this, 'jxQuizRecordAnswer'));
    add_action( 'wp_ajax_saber_quiz_end', array( $this, 'jxQuizEnd'));

  }

  public function render( $quizId = 0, $settings = [] ) {

    // load quiz model from passed $quizId or current post
    if( $quizId ) {
      $this->quiz = Model\Quiz::load( $quizId );
    } else {
      global $post;
      $this->quiz = Model\Quiz::load( $post->ID );
    }

    // setup template
    $template = new \SaberQuiz\Template();
    $template->path = 'components/quiz/templates/';

    $content = '';

    // main template
    $template->name = 'quiz-canvas';
    $template->data = array(
      'quiz' => $this->quiz
    );
    $content .= $template->get();

    // quiz controls template
    $template->name = 'quiz-controls';
    $template->data = [];
    $content .= $template->get();

    // question template
    $template->name = 'quiz-question';
    $content .= $template->get();

    // question options template
    $template->name = 'quiz-question-option';
    $content .= $template->get();

    // start screen template
    $template->name = 'quiz-start';
    $template->data = [
      'quiz' => $this->quiz,
      'settings' => $settings
    ];
    $content .= $template->get();

    // end screen template
    $template->name = 'quiz-end';
    $template->data = [
      'quiz' => $this->quiz,
      'settings' => $settings
    ];
    $content .= $template->get();

    print $content;

  }

  public function renderPreview( $quizId, $settings ) {

    $this->settings = $settings;

    // load quiz model from passed $quizId or current post
    if( $quizId ) {
      $this->quiz = Model\Quiz::load( $quizId );
    } else {
      global $post;
      $this->quiz = Model\Quiz::load( $post->ID );
    }

    $this->renderElementorQuestionPage();
    $this->renderElementorDivider();
    $this->renderElementorStartPage();
    $this->renderElementorDivider();
    $this->renderElementorEndPage();

  }

  public function renderElementorCanvas() {

    // setup template
    $template = new \SaberQuiz\Template();
    $template->path = 'components/quiz/templates/';

    $content = '';

    // main template
    $template->name = 'quiz-canvas';
    $template->data = [
      'quiz' => $this->quiz,
      'settings' => $this->settings
    ];
    $content .= $template->get();
    print $content;

  }

  public function renderElementorStartPage() {

    // setup template
    $template = new \SaberQuiz\Template();
    $template->path = 'components/quiz/templates/elementor/';

    $content = '';

    // start screen template
    $template->name = 'quiz-start';
    $template->data = [
      'quiz' => $this->quiz,
      'settings' => $this->settings
    ];
    $content .= $template->get();

    print $content;

  }

  public function renderElementorEndPage() {

    $template = new \SaberQuiz\Template();
    $template->path = 'components/quiz/templates/elementor/';

    $template->name = 'quiz-end';
    $template->data = [
      'quiz' => $this->quiz,
      'settings' => $this->settings
    ];
    print $template->get();

  }

  public function renderElementorDivider() {

    print '<div style="margin: 10px 0 10px 0;color: #B2B2B2;"><hr /></div>';

  }

  public function renderElementorQuestionPage() {

    $template = new \SaberQuiz\Template();
    $template->path = 'components/quiz/templates/elementor/';

    $template->name = 'quiz-question';
    $template->data = [
      'quiz' => $this->quiz,
      'settings' => $this->settings
    ];
    print $template->get();

  }

  public function jxQuizRecordAnswer() {

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




}
