<div class="quiz-editor-menu">

  <div class="quiz-editor-menu-add">
    <button id="question-add-button">Add Question</button>
  </div>

  <div class="editor-add-forms">

    <div id="search-form-question">
      <input
        type="text"
        placeholder="Question Title or ID"
        id="question-search-box"
        name="question-search-box"
        class="search-box"
        />
      <button class="search-button" id="question-search-button">Search</button>
      <div class="search-results"></div>
    </div>

  </div>

</div>


<div class="quiz-editor-timeline">
  <div class="quiz-editor-timeline-grid">

    <?php

      if( !empty( $quiz->timeline->items) ):
        foreach( $quiz->timeline->items as $item ) :

          if (is_a( $item, 'Saber\Question\Model\Question')) {
            $type = 'lesson';
          }

          $classes = 'quiz-editor-timeline-item quiz-editor-timeline-item-' . $type;

    ?>

        <div class="<?php print $classes; ?>"
          data-id="<?php print $item->id ?>"
          data-type="question"><h4><?php print $item->title ?></h4>
          <span class="dashicons dashicons-trash"></span>
        </div>

    <?php endforeach; endif; ?>

  </div>
</div>

<textarea id="quiz-editor-data" name="quiz-editor-data">
  <?php print $quiz->timeline->data; ?>
</textarea>
