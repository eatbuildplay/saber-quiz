<?php

namespace SaberQuiz\Quiz\Model;

class Quiz {

  public $id;
  public $title;
  public $permalink;
  public $type = 'quiz';
  public $timeline;

  public static function load( $post ) {

    // enable passing id and loading post from id
    if( is_numeric( $post )) {
      $post = get_post( $post );
    }

    $obj = new Quiz;
    $obj->id = $post->ID;
    $obj->title = $post->post_title;
    $obj->permalink = get_permalink( $post );

    // course editor data
    $key = 'saber_quiz_timeline_data';
    $timelineData = get_post_meta( $post->ID, $key, true );

    $obj->timeline = new \stdClass;
    $obj->timeline->data = $timelineData;
    $obj->timeline->items = [];
    $timelineItems = json_decode( $obj->timeline->data );

    if(!empty( $timelineItems )) {
      foreach( $timelineItems as $item ) {
        if( $item->type == 'question' ) {
          $obj->timeline->items[] = \SaberQuiz\Quiz\Model\Question::load( $item->id );
        }
      }
    }

    return $obj;

  }

}
