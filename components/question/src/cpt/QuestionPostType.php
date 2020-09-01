<?php

namespace SaberQuiz\Question;

class QuestionPostType extends \SaberQuiz\PostType {

  public $showInMenu = false;

  public function getKey() {
    return 'question';
  }

}
