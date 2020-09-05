<?php

/**
 *
 * Plugin Name: Saber Quiz
 * Plugin URI: https://eatbuildplay.com/plugins/saber
 * Description: Saber quiz provides a quiz system for Elementor.
 * Version: 1.0.0
 * Author: Casey Milne, Eat/Build/Play
 * Author URI: https://eatbuildplay.com/
 * License: GPL3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 *
 */

namespace SaberQuiz;

define( 'SABER_QUIZ_PATH', plugin_dir_path( __FILE__ ) );
define( 'SABER_QUIZ_URL', plugin_dir_url( __FILE__ ) );
define( 'SABER_QUIZ_VERSION', '1.1.0' );

class Plugin {

  public function __construct() {

    require_once( SABER_QUIZ_PATH . 'src/Template.php' );
    require_once( SABER_QUIZ_PATH . 'src/PostType.php' );

    $this->loadComponents();

    /* admin menu */
    add_action('admin_menu', [$this, 'menu']);

    /* highlight menu */
    add_filter('parent_file', [$this, 'setParentMenu'], 10, 2 );

    /* admin scripts */
    add_action('admin_enqueue_scripts', [$this, 'adminScripts']);

  }

  /*
   * loadComponents
   * @TODO add filter load additional components
   */
  protected function loadComponents() {

    require_once( SABER_QUIZ_PATH . 'components/dashboard/src/DashboardComponent.php' );
    new \SaberQuiz\Dashboard\DashboardComponent();

    require_once( SABER_QUIZ_PATH . 'components/reports/src/Component.php' );
    new \SaberQuiz\Reports\Component();

    require_once( SABER_QUIZ_PATH . 'components/quiz/src/Component.php' );
    new \SaberQuiz\Quiz\Component();

    require_once( SABER_QUIZ_PATH . 'components/question/src/Component.php' );
    new \SaberQuiz\Question\Component();

    require_once( SABER_QUIZ_PATH . 'components/settings/src/SettingsComponent.php' );
    new \SaberQuiz\Settings\SettingsComponent();

  }

  public function setParentMenu( $parent_file ) {

    global $submenu_file, $current_screen;

    $cpts = [
      'quiz',
      'quiz_score',
      'quiz_score_question',
      'question',
      'question_type',
      'question_option',
      'question_bank',
      'question_answer',
    ];

    if( in_array($current_screen->post_type, $cpts)) {
      $parent_file = 'saber-quiz';
    }

    return $parent_file;

  }

  public function menu() {

    \add_menu_page(
      'Saber Quiz',
      'Saber Quiz',
      'edit_posts',
      'saber-quiz',
      ['\SaberQuiz\Plugin', 'DashboardPage'],
      'dashicons-welcome-learn-more',
      2
    );

    \add_submenu_page(
      'saber-quiz',
      'Dashboard',
      'Dashboard',
      'edit_posts',
      'saber-quiz'
    );

    \add_submenu_page(
      'saber-quiz',
      'Quizzes',
      'Quizzes',
      'edit_posts',
      'edit.php?post_type=quiz'
    );

    \add_submenu_page(
      'saber-quiz',
      'Questions',
      'Questions',
      'edit_posts',
      'edit.php?post_type=question'
    );

    \add_submenu_page(
      'saber-quiz',
      'Reports',
      'Reports',
      'edit_posts',
      'saber-reports',
      ['\SaberQuiz\Reports\Component', 'pageCallback']
    );

    \add_submenu_page(
      'saber-quiz',
      'Settings',
      'Settings',
      'edit_posts',
      'saber-settings',
      ['\SaberQuiz\Settings\SettingsComponent', 'pageCallback']
    );

  }

  public function adminScripts() {

    wp_enqueue_style(
      'saber-quiz',
      SABER_QUIZ_URL . 'src/assets/saber.css',
      array(),
      true
    );

  }

  public function dashboardPage() {

    print "dashboard";

  }

}

new Plugin();
