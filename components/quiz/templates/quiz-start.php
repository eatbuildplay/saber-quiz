<template id="quiz-single-start">
  <div class="quiz-single-start">
    <h2><?php print $quiz->title; ?></h2>
    <div class="quiz-start-page-description">
      <?php print $quiz->description; ?>
    </div>
    <button class="quiz-control-start"><?php print $settings['start_quiz_button_label']; ?></button>
  </div>
</template>
