<?php

namespace SaberQuiz\Reports;

class QuizScoreReport {

  public function run() {

    $models = $this->query();
    $template = new \SaberQuiz\Template;
    $template->path = 'components/reports/templates/';
    $template->name = 'quiz-score-report';
    $template->data = [
      'models' => $models
    ];
    return $template->get();

  }

  protected function query() {

    $args = [
      'post_type' => 'quiz_score',
      'numberposts' => -1
    ];
    $posts = get_posts( $args );

    $model = new \SaberQuiz\Quiz\Model\QuizScore;

    $models = [];
    foreach( $posts as $post ) {
      $models[] = $model::load( $post );
    }

    return $models;

  }

}
