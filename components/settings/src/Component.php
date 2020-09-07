<?php

namespace SaberQuiz\Settings;

class Component {

  public function __construct() {

    add_action('admin_enqueue_scripts', [$this, 'adminScripts']);

    add_action('wp_ajax_saber_quiz_settings_save', [$this, 'jxSaveSettings']);

  }

  protected function jxSaveSettings() {

    

  }

  public function pageCallback() {

    $template = new \SaberQuiz\Template;
    $template->path = 'components/settings/templates/';
    $content = '';

    $template->name = 'header';
    $template->data = [];
    $content .= $template->get();

    $template->name = 'main';
    $template->data = [];
    $content .= $template->get();

    $template->name = 'tabs';
    $template->data = [];
    $content .= $template->get();

    $template->name = 'footer';
    $template->data = [];
    $content .= $template->get();

    print $content;

  }

  public function adminScripts() {

    wp_enqueue_style(
      'saber-settings',
      SABER_QUIZ_URL . 'components/settings/assets/settings.css',
      array(),
      true
    );

    wp_enqueue_script(
      'saber-settings',
      SABER_QUIZ_URL . 'components/settings/assets/settings.js',
      array('jquery', 'jquery-ui-tabs'),
      SABER_QUIZ_VERSION,
      true
    );

  }

}
