<?php

namespace SaberQuiz\Quiz;

class QuizPostType extends \SaberQuiz\PostType {

  public $showInMenu = false;

  public function getKey() {
    return 'quiz';
  }

}
