<?php

namespace SaberQuiz\Quiz;

class QuestionBankPostType extends \SaberQuiz\PostType {

  public $showInMenu = false;

  public function getKey() {
    return 'question_bank';
  }

}
