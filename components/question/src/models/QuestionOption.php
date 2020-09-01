<?php

namespace SaberQuiz\Quiz\Model;

class QuestionOption {

  public $id;
  public $title;
  public $label;
  public $correct;

  public function save() {

    if( $this->id > 0 ) {
      $this->update();
    } else {
      $this->id = $this->create();
      if( !$this->id ) {
        return false;
      }
    }

    update_post_meta( $this->id, 'question_option_label', $this->title );
    update_post_meta( $this->id, 'question_option_correct', $this->correct );

  }

  public function create() {

    $params = [
      'post_type'   => 'question_option',
      'post_title'  => $this->title,
      'post_status' => 'publish'
    ];
    $postId = wp_insert_post( $params );
    $this->id = $postId;
    return $postId;

  }

  public function update() {

  }

  public static function load( $post ) {

    // enable passing id and loading post from id
    if( is_numeric( $post )) {
      $post = get_post( $post );
    }

    $obj = new QuestionOption;
    $obj->id = $post->ID;
    $obj->title = $post->post_title;

    $obj->label = get_post_meta($obj->id, 'question_option_label', 1);
    $obj->correct = get_post_meta($obj->id, 'question_option_correct', 1);

    return $obj;

  }

}
