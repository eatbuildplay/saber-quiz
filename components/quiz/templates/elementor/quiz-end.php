<div id="quiz-canvas" class="quiz-canvas">
  <div class="quiz-end-page">

    <?php if( $settings['end_page_override_headline'] == 1 ) { ?>
      <h1 class="quiz-end-page-headline"><?php print $settings['end_page_headline_content']; ?></h1>
    <?php } else { ?>
      <h1 class="quiz-end-page-headline">Quiz Over</h1>
    <?php } ?>

    <div class="quiz-end-page-body">

    </div>

    <div class="quiz-score-results">

      <?php if( $settings['end_page_score_header_override'] == 1 ) { ?>
        <h2><?php print $settings['end_page_score_header']; ?></h2>
      <?php } else { ?>
        <h2>Your Score</h2>
      <?php } ?>

      <div class="quiz-score-main-result">85%</div>
      
    </div>

    <button class="quiz-control-restart">Restart Quiz</button>
  </div>
</div>
