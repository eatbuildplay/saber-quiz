<?php

namespace SaberQuiz\Quiz;

class QuestionOptionPostType extends \SaberQuiz\PostType {

  public $showInMenu = false;

  public function getKey() {
    return 'question_option';
  }

}
