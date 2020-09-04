<template id="quiz-single-end">
  <div class="quiz-end-page">

    <?php if( $settings['end_page_override_headline'] == 1 ) { ?>
      <h1 class="quiz-end-page-headline"><?php print $settings['end_page_headline_content']; ?></h1>
    <?php } else { ?>
      <h1 class="quiz-end-page-headline">Quiz Over</h1>
    <?php } ?>


    <div class="quiz-score-results">
      <h2>Exam Score Results</h2>
      <div class="quiz-score-main-result"></div>
    </div>

    <button class="quiz-control-restart">Restart Quiz</button>

  </div>
</template>
