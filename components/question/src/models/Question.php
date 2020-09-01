<?php

namespace SaberQuiz\Quiz\Model;

class Question {

  public $id;
  public $title;
  public $type = 'question';
  public $questionType;
  public $body;
  public $options;
  public $correct; // array of options flagged as correct

  public static function load( $post ) {

    // enable passing id and loading post from id
    if( is_numeric( $post )) {
      $post = get_post( $post );
    }

    $obj = new Question;
    $obj->id = $post->ID;
    $obj->title = $post->post_title;

    $obj->questionType = get_post_meta( $obj->id, 'question_type', 1);
    $obj->body = get_post_meta( $obj->id, 'question_body', 1);

    $optionsArray = get_post_meta( $obj->id, 'question_options', 1);
    $options = [];
    foreach( $optionsArray as $optionId ) {
      $options[] = \SaberQuiz\Quiz\Model\QuestionOption::load( $optionId );
    }
    $obj->options = $options;

    $obj->correct = get_post_meta( $obj->id, 'question_correct', 1);

    return $obj;

  }

}
