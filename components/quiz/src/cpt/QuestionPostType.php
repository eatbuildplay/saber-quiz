<?php

namespace SaberQuiz\Quiz;

class QuestionPostType extends \SaberQuiz\PostType {

  public $showInMenu = false;

  public function getKey() {
    return 'question';
  }

}
