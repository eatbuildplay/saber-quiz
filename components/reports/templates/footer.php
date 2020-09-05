<?php

$args = [
  'post_type' => 'quiz_score',
  'numberposts' => -1
];
$posts = get_posts( $args );

$model = new \SaberQuiz\Quiz\Model\QuizScore;

$models = [];
foreach( $posts as $post ) {
  $models[] = $model::load( $post );
}




var_dump($models[0]);

?>

<?php if( !empty( $models )) { ?>
<table>
  <thead>
    <tr>
      <th>Quiz</th>
      <th>Date</th>
      <th>User</th>
      <th>Question Count</th>
      <th>Questions Correct</th>
      <th>Points Awarded</th>
      <th>Points Awarded %</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach( $models as $qs ) { ?>
    <tr>
      <td><?php print $qs->quiz->title; ?></td>
      <td><?php print $qs->start; ?></td>
      <td><?php print $qs->user; ?></td>
      <td><?php print $qs->questionCount; ?></td>
      <td><?php print $qs->questionsCorrectCount; ?></td>
      <td><?php print $qs->pointsAwarded; ?></td>
      <td><?php print $qs->pointsAwardedPercent . '%'; ?></td>
    </tr>
  <?php } ?>
</tbody>
</table>

<?php } else { // if empty list of quiz scores ?>
  <div class="quiz-scores-empty">No quiz scores available.</div>
<?php } // end if empty ?>
