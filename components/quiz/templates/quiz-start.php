<template id="quiz-single-start">
  <div class="quiz-start-page">

    <?php if( $settings['start_page_override_quiz_title'] == 1 ) { ?>
      <h1><?php print $settings['start_page_headline_override']; ?></h1>
    <?php } else { ?>
      <h1><?php print $quiz->title; ?></h1>
    <?php } ?>

    <?php if( $settings['show_description'] ): ?>
      <div class="quiz-start-page-description">
        <?php print $quiz->description; ?>
      </div>
    <?php endif; ?>

    <button class="quiz-control-start"><?php print $settings['start_quiz_button_label']; ?></button>

  </div>
</template>
