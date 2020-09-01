<?php

namespace SaberQuiz\Quiz;

class QuizScoreQuestionPostType extends \SaberQuiz\PostType {

  public $showInMenu = false;

  public function getKey() {
    return 'quiz_score_question';
  }

}
