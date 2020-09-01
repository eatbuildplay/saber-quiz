<?php

namespace SaberQuiz\Dashboard;

class DashboardShortcode {

  public $tag = 'saber-dashboard';

  public function __construct() {
    add_action('init', array( $this, 'init'));
  }

  public function init() {
    add_shortcode($this->tag, array($this, 'doShortcode'));
  }

  public function doShortcode( $atts ) {

    $template = new \SaberQuiz\Template();
    $template->path = 'components/dashboard/templates/';

    $content = '';

    // get student
    $student = \SaberQuiz\Student\Model\Student::load();

    // get course registrations
    $cr = new \SaberQuiz\Register\Model\CourseRegistration;
    $courses = $cr->fetchAllStudent();

    // header
    $template->name = 'header';
    $template->data = [
      'student' => $student,
      'courses' => $courses
    ];
    $content .= $template->get();

    // widgets
    $template->name = 'widgets';
    $template->data = [
      'student' => $student,
      'courses' => $courses
    ];
    $content .= $template->get();

    return $content;

  }

}
