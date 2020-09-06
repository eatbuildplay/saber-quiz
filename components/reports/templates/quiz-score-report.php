<?php if( !empty( $models )) { ?>
<table id="quiz_score_report_table" class="display nowrap" >
  <thead>
    <tr>
      <th>Quiz</th>
      <th>Date</th>
      <th>User</th>
      <th>Correct</th>
      <th>Points</th>
      <th>Score</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach( $models as $qs ) { ?>
    <tr>
      <td><?php print $qs->quiz->title; ?></td>
      <td><?php print $qs->start; ?></td>
      <td><?php print $qs->user; ?></td>
      <td><?php print $qs->questionsCorrectCount . '/' . $qs->questionCount; ?></td>
      <td><?php print $qs->pointsAwarded; ?></td>
      <td><?php print $qs->pointsAwardedPercent . '%'; ?></td>
    </tr>
  <?php } ?>
</tbody>
</table>

<?php } else { // if empty list of quiz scores ?>
  <div class="quiz-scores-empty">No quiz scores available.</div>
<?php } // end if empty ?>
