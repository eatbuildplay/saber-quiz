<?php

namespace SaberQuiz\Quiz\Model;

class QuizScore {

  public $id;
  public $title;
  public $permalink;
  public $quiz;
  public $user;
  public $start;
  public $quizScoreQuestions;

  public function save() {

    $this->user = get_current_user_id();

    if( $this->id > 0 ) {
      $this->update();
    } else {
      $this->id = $this->create();
      if( !$this->id ) {
        return false;
      }
    }

    $this->permalink = get_permalink( $this->id );

    update_post_meta( $this->id, 'quiz_score_user', $this->user );
    update_post_meta( $this->id, 'quiz_score_quiz', $this->quiz );
    update_post_meta( $this->id, 'quiz_score_start', date('Y-m-d H:i:s') );

  }

  public function create() {

    $this->title = "Quiz " . $this->quiz . ", User " . $this->user;

    $params = [
      'post_type'   => 'quiz_score',
      'post_title'  => $this->title,
      'post_status' => 'publish'
    ];
    $postId = wp_insert_post( $params );
    $this->id = $postId;
    return $postId;

  }

  public static function load( $post ) {

    // enable passing id and loading post from id
    if( is_numeric( $post )) {
      $post = get_post( $post );
    }


    $obj = new QuizScore;

    // post-based properties
    $obj->id = $post->ID;
    $obj->title = $post->post_title;
    $obj->permalink = get_permalink( $post->ID );

    // meta-based properties
    $obj->user = get_post_meta( $obj->id, 'quiz_score_user', 1);
    $quizId = get_post_meta( $obj->id, 'quiz_score_quiz', 1);
    $obj->quiz = Quiz::load( $quizId );
    $obj->start = get_post_meta( $obj->id, 'quiz_score_start', 1);
    $obj->quizScoreQuestions = QuizScoreQuestion::fetchList( $obj->id );

    // calculated properties
    $obj->setQuestionCount();
    $obj->setQuestionsCorrectCount();
    $obj->setPointsAwarded();
    $obj->setPointsAwardedPercent();

    return $obj;

  }

  public function setQuestionCount() {
    $this->questionCount = count( $this->quizScoreQuestions );
  }

  public function setQuestionsCorrectCount() {
    $this->questionsCorrectCount = 0;
    $this->questionsIncorrectCount = 0;
    foreach( $this->quizScoreQuestions as $esq ) {
      if( $esq->correct ) {
        $this->questionsCorrectCount++;
      } else {
        $this->questionsIncorrectCount++;
      }
    }
  }

  public function setPointsAwarded() {
    $this->pointsAwarded = 0;
    foreach( $this->quizScoreQuestions as $esq ) {
      if( $esq->correct ) {
        $this->pointsAwarded++;
      }
    }
  }

  /*
   * Returns number from 0-100
   * Uses round(), default up to 2 decimal points
   */
  public function setPointsAwardedPercent() {
    if( $this->pointsAwarded ) {
      $this->pointsAwardedPercent = round(($this->pointsAwarded / $this->questionCount) * 100);
    } else {
      $this->pointsAwardedPercent = 0;
    }
  }

}
