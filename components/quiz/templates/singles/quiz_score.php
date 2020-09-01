<?php

print '<pre>';
var_dump( $quizScore );
print '</pre>';

$correct = 0;
$points = 0;
foreach( $quizScore->questions as $qs ) {
  $correct += $qs->correct;
  $points += $qs->points;
}
$questionCount = count($quizScore->questions);
if( $points ) {
  $scorePercent = round(($points / $questionCount) * 100);
} else {
  $scorePercent = 0;
}

//get_header();

?>

<div class="quiz-score-single-wrap">
  <div class="quiz-score-single">

    <h2>Quiz Result - <?php print $quizScore->quiz->title; ?></h2>

    <header>

      <div class="header-col-1">
        <h2><?php print $scorePercent; ?>%</h2>
        <h6>Total Score</h6>
      </div>
      <div class="header-col-2">
        <h4>Taken At <?php print $quizScore->start; ?></h4>
        <h4>Quiz ID: <?php print $quizScore->quiz->id; ?></h4>
        <h4>User <?php print $quizScore->user['display_name']; ?></h4>
      </div>
    </header>

    <h3>Question Summary</h3>

    <?php
      if(!empty($quizScore->questions)):
        foreach( $quizScore->questions as $qa ):
    ?>

      <h3><?php print $qa->title; ?></h3>
      <h5>Points Awarded: <?php print $qa->points; ?></h5>
      <h5>Correct: <?php print $qa->correct; ?></h5>

    <?php endforeach; endif; ?>

  </div>
</div>

<?php //get_footer(); ?>
