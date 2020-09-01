<?php

namespace SaberQuiz\Quiz;

class QuizScorePostType extends \SaberQuiz\PostType {

  public $showInMenu = false;

  public function getKey() {
    return 'quiz_score';
  }

}
