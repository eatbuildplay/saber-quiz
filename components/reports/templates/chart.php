<div id="reports-wrap">

  <header id="reports-header">
    <h1>Saber Quiz Reports</h1>
  </header>

  <!-- Stats Grid -->
  <div class="stat-grid-3">

    <div class="report-stat">
      <h2><?php print $cts->exam; ?></h2>
      <h4>Quizzes</h4>
    </div>

    <div class="report-stat">
      <h2><?php print $cts->examScore; ?></h2>
      <h4>Quiz Attempts</h4>
    </div>

    <div class="report-stat">
      <h2><?php print $cts->question; ?></h2>
      <h4>Questions</h4>
    </div>

    <div class="report-stat">
      <h2><?php print $userCount['total_users']; ?></h2>
      <h4>Registered Students</h4>
    </div>

  </div>
  <!-- / Stats Grid -->

</div><!-- / #reports-wrap -->
