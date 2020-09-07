<?php

namespace SaberQuiz\Dashboard;

class Component {

  public function __construct() {

    add_action('admin_print_scripts-toplevel_page_saber-dashboard', array( $this, 'adminScripts' ));

  }

  public function pageCallback() {

    $template = new \SaberQuiz\Template;
    $template->path = 'components/dashboard/templates/';
    $content = '';

    $template->name = 'header';
    $template->data = [];
    $content .= $template->get();

    $template->name = 'body';
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

  public function adminScripts() {

    wp_enqueue_script(
      'saber-dashboard',
      SABER_QUIZ_URL . 'components/dashboard/assets/dashboard.js',
      array( 'jquery', 'chartjs' ),
      '1.0.0',
      true
    );

    wp_enqueue_style(
      'saber-dashboard',
      SABER_QUIZ_URL . 'components/dashboard/assets/dashboard.css',
      array(),
      true
    );

  }

}
