<?php

namespace SaberQuiz\Quiz;

class QuizEditor {

  public function __construct() {

    /* metaboxes */
    add_action( 'admin_menu', [$this, 'metaboxes'] );
    add_action( 'save_post_quiz', [$this, 'metaboxSave'], 10, 2 );

    /* search ajax hook */
    add_action( 'wp_ajax_saber_quiz_editor_question_search', array( $this, 'jxQuestionSearch'));

    add_action( 'admin_print_scripts-post-new.php', [$this, 'editorScripts'] );
    add_action( 'admin_print_scripts-post.php', [$this, 'editorScripts'] );

  }

  public function jxQuestionSearch() {

    $search = sanitize_text_field( $_POST['search'] );

    // search for lessons
    $args = [
      's' => $search,
      'post_type' => 'question'
    ];
    $posts = \get_posts( $args );

    // form lesson array
    $models = [];
    foreach( $posts as $post ) {
      $model = new \stdClass;
      $model->id = $post->ID;
      $model->title = $post->post_title;
      $models[] = $model;
    }

    $response = [
      'code'    => 200,
      'items'   => $models,
      'search'  => $search
    ];
    print json_encode( $response );
    wp_die();

  }

  public function metaboxes() {

    add_meta_box(
  		'quiz_editor', // metabox ID
  		'Quiz Editor', // title
  		[$this, 'metaboxCb'], // callback
  		'quiz',
  		'normal', // position
  		'high' // priority
  	);

  }

  public function metaboxCb( $post ) {

    $quiz = \SaberQuiz\Quiz\Model\Quiz::Load( $post );
    $template = new \SaberQuiz\Template();
    $template->path = 'components/quiz/templates/';

    $content = '';

    $template->name = 'quiz-editor';
    $template->data = [
      'quiz' => $quiz
    ];
    $content .= $template->get();

    print $content;

  }

  /*
   * Save metabox
   */
  public function metaboxSave( $postId, $post ) {

    $postType = get_post_type_object( $post->post_type );

    /* Check if the current user has permission to edit the post. */
    if ( !current_user_can( $postType->cap->edit_post, $postId )) {
      return $postId;
    }

    $editorData = $_POST['quiz-editor-data'];
    update_post_meta( $postId, 'saber_quiz_timeline_data', $editorData );

    // quiz description
    $quizDescription = sanitize_text_field( $_POST['quiz_description'] );
    update_post_meta( $postId, 'quiz_description', $quizDescription );

  }

  public function editorScripts() {

    global $post_type;

    if( 'quiz' == $post_type ) {

      wp_enqueue_script(
        'quiz-editor',
        SABER_QUIZ_URL . 'components/quiz/assets/quiz-editor.js',
        array( 'jquery' ),
        '1.0.0',
        true
      );

      wp_enqueue_style(
        'quiz-editor',
        SABER_QUIZ_URL . 'components/quiz/assets/quiz-editor.css',
        array(),
        true
      );

    }

  }

}
