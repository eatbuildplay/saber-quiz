<?php

namespace SaberQuiz\Quiz;

class QuizSectionPostType extends \SaberQuiz\PostType {

  public $showInMenu = false;

  public function getKey() {
    return 'quiz_section';
  }

}
