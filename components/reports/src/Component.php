<?php

namespace SaberQuiz\Reports;

class Component {

  public function __construct() {

    require_once(SABER_QUIZ_PATH . 'components/reports/src/reports/ReportModel.php');

    add_action('admin_print_scripts-saber-quiz_page_saber-reports', [$this, 'adminScripts']);

  }

  public static function pageCallback() {

    $template = new \SaberQuiz\Template;
    $template->path = 'components/reports/templates/';
    $content = '';

    $userCount = count_users();

    // $cts = Content Counts []
    $cts = self::fetchContentCounts();

    $template->name = 'header';
    $template->data = [];
    $content .= $template->get();

    $template->name = 'chart';
    $template->data = [
      'userCount' => $userCount,
      'cts'       => $cts
    ];
    $content .= $template->get();

    $template->name = 'footer';
    $template->data = [];
    $content .= $template->get();

    print $content;

  }

  public function fetchContentCounts() {

    $cts = new \stdClass;

    $cts->exam = \wp_count_posts('quiz')->publish;
    $cts->examScore = \wp_count_posts('quiz_score')->publish;
    $cts->question = \wp_count_posts('question')->publish;

    return $cts;

  }

  public function adminScripts() {

    wp_enqueue_style(
      'saber-reports',
      SABER_QUIZ_URL . 'components/reports/assets/reports.css',
      array(),
      true
    );

    wp_enqueue_script(
      'saber-reports',
      SABER_QUIZ_URL . 'components/reports/assets/reports.js',
      array('jquery', 'chartjs'),
      SABER_VERSION,
      true
    );

  }

}
