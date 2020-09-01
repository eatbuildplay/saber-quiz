<?php

namespace SaberQuiz\Quiz;

class QuestionTypePostType extends \SaberQuiz\PostType {

  public $showInMenu = false;

  public function getKey() {
    return 'question_type';
  }

}
