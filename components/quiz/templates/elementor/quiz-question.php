<div id="quiz-canvas" class="quiz-canvas">

  <div class="quiz-question-page">

    <div id="quiz-body-canvas">

      <div class="question question-1" data-question-id="1">

        <?php if( $settings['question_page_show_question_numbers'] == 1 ) { ?>
          <h3>Question 1</h3>
        <?php } ?>
        <h1>What is 1+1?</h1>
        <ul class="selectable">
          <li class="question-option question-option-123"
            data-question-id="123"
            data-question-option-id="123">
              15</li>
          <li class="question-option question-option-123"
            data-question-id="123"
            data-question-option-id="123">
              22</li>
        </ul>
      </div>

    </div>

    <div id="quiz-controls-canvas">
      <div class="quiz-controls">
        <button class="quiz-next">Next Question</button>
      </div>
    </div>

  </div><!-- / .quiz-question-page -->

</div>
