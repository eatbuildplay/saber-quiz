<template id="question-template">
  <div class="question question-{questionId}" data-question-id="{questionId}">

    <?php if( $settings['question_page_show_question_numbers'] == 1 ) { ?>
      <h3>{questionNumber}</h3>
    <?php } ?>

    <h1>{questionTitle}</h1>
    <ul class="selectable"></ul>
  </div>
</template>
