<?php

namespace SaberQuiz\Quiz;

class QuestionAnswerPostType extends \SaberQuiz\PostType {

  public $showInMenu = false;

  public function getKey() {
    return 'question_answer';
  }

}
