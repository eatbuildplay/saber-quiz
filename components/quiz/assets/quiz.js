/*
 * Quiz Controller
 * Path: components\quiz\assets
 * Filename: quiz.js
 *
 * Method Count: 18
 *
 * Version 1.0
 */

var Quiz = {

  id: jQuery('#quiz-canvas').data('quiz-id'),
  canvas: {
    body: jQuery('#quiz-body-canvas'),
    controls: jQuery('#quiz-controls-canvas'),
  },
  quiz: [],
  score: {},
  state: {
    started: false,
    currentQuestion: {
      index: 0,
      question: false
    }
  },

  init: function() {

console.log( "poohiulgyufytdtr" )
    console.log( Quiz.id )

    if( !Quiz.id ) {
      return;
    }

    Quiz.selectQuestionOption();
    Quiz.quizLoad();
    Quiz.next();

    Quiz.showStart();
    Quiz.startClickHandler();

    Quiz.restartClickHandler();

    Quiz.viewScore();

  },

  viewScore: function() {




  },

  restartClickHandler: function() {
    jQuery(document).on('click', '.quiz-control-restart', Quiz.showStart);
  },

  timelineItemCount: function() {
    return Quiz.quiz.timeline.items.length;
  },

  end: function() {

    Quiz.hideControls();

    // quiz single end template
    var $template = jQuery('#quiz-single-end').html();
    Quiz.canvas.body.html( $template );

    // quiz score results
    var $template = jQuery('#quiz-score-results').html();
    Quiz.canvas.body.append( $template );

    Quiz.canvas.body.find('.quiz-score-main-result')
      .html( '<h2>' + Quiz.score.pointsAwardedPercent + '%</h2>' );

    Quiz.canvas.body.find('.quiz-score-question-count')
      .html( 'Question Count: ' + Quiz.score.questionCount );

    // send end call
    data = {
      action: 'saber_quiz_end',
      quizId: Quiz.id
    }
    jQuery.post( saberQuiz.ajaxurl, data, function( response ) {

      response = JSON.parse(response);

    });


  },

  showStart: function() {

    var $template = jQuery('#quiz-single-start').html();
    Quiz.canvas.body.html( $template );

  },

  startClickHandler: function() {
    jQuery(document).on('click', '.quiz-control-start', Quiz.start);
  },

  start: function() {

    // make QuizScore
    Quiz.createQuizScore();

    // show question
    var $question = Quiz.quiz.timeline.items[ 0 ];
    var $questionNumber = 1;
    Quiz.questionShow( $question, $questionNumber );
    Quiz.state.currentQuestion.index = 0;
    Quiz.state.currentQuestion.question = $question;

    // show controls
    Quiz.loadControls();
    Quiz.showControls();

  },

  createQuizScore: function() {

    data = {
      action: 'saber_quiz_create_quiz_score',
      quizId: Quiz.id
    }
    jQuery.post( saberQuiz.ajaxurl, data, function( response ) {

      response = JSON.parse(response);

      console.log(response.quizScore)

      Quiz.score = response.quizScore;

    });

  },

  loadControls: function() {
    var $template = jQuery('#quiz-controls').html();
    Quiz.canvas.controls.html( $template );
  },

  showControls: function() {
    Quiz.canvas.controls.show();
  },

  hideControls: function() {
    Quiz.canvas.controls.hide();
  },

  showLastQuestion: function() {
    jQuery('button.quiz-next').html('Finish Quiz');
  },

  next: function() {

    jQuery(document).on('click', '.quiz-next', function() {

      var $nextQuestionIndex = Quiz.state.currentQuestion.index +1;
      var $question = Quiz.quiz.timeline.items[ $nextQuestionIndex ];

      // end is next
      if( Quiz.timelineItemCount() == $nextQuestionIndex +1 ) {
        Quiz.showLastQuestion();
      }

      // is end
      if( !$question ) {
        Quiz.end();
        return;
      }

      var $questionNumber = $nextQuestionIndex +1;
      Quiz.questionShow( $question, $questionNumber );
      Quiz.state.currentQuestion.index = $nextQuestionIndex;
      Quiz.state.currentQuestion.question = $question;

    });

  },

  /*
   * Load quiz data via AJAX
   */
  quizLoad: function() {

    data = {
      action: 'saber_quiz_quiz_load',
      quizId: Quiz.id
    }
    jQuery.post( saberQuiz.ajaxurl, data, function( response ) {

      response = JSON.parse(response);
      Quiz.quiz = response.quiz;

    });

  },

  questionShow: function( $question, $questionNumber ) {

    // populate templates
    var $template = jQuery('#question-template').html();
    $template = $template.replace(
      '{questionId}',
      $question.id
    );
    $template = $template.replace(
      '{questionTitle}',
      $question.title
    );
    $template = $template.replace(
      '{questionNumber}',
      'Question ' + $questionNumber
    );

    Quiz.canvas.body.html( $template );

    // get the question as an element so we can make changes
    var $questionEl = jQuery('.question');

    var lettering = [
      'a', 'b', 'c', 'd', 'e', 'f'
    ];
    var $optionsHtml = '';
    $question.options.forEach( function( option, index ) {

      var $template = jQuery('#question-option-template').html();
      $template = $template.replace(
        /\{questionOptionId\}/g,
        option.id
      );

      $template = $template.replace(
        '{questionOptionLabel}',
        lettering[index] + ') ' + option.title
      );
      $template = $template.replace(
        '{questionId}',
        $question.id
      );
      $optionsHtml += $template;
    });

    $questionEl.find('ul').html( $optionsHtml );

  },

  selectQuestionOption: function() {

    jQuery( document ).on( 'click', '.question ul.selectable li', function() {

      // handle ux changes
      jQuery(this).addClass('selected');
      jQuery(this).parent('ul').removeClass('selectable');

      // record the answer
      var $questionId = jQuery(this).data('question-id');
      var $questionOptionId = jQuery(this).data('question-option-id');
      Quiz.recordAnswer( $questionId, $questionOptionId );

    })

  },

  recordAnswer: function( $questionId, $questionOptionId ) {

    data = {
      action: 'saber_quiz_record_answer',
      quizScoreId: Quiz.score.id,
      questionId: $questionId,
      questionOptionId: $questionOptionId
    }
    jQuery.post( saberQuiz.ajaxurl, data, function( response ) {

       response = JSON.parse(response);

       // update quiz score
       Quiz.score = response.quizScore;

       // add focus on answered question
       var $questionEl = jQuery('.question-' + response.question.id);
       $questionEl.addClass('focus');

       var $selectedOption = $questionEl.find('li.selected');

       if(response.isCorrect) {
         $selectedOption.addClass('correct');
       } else {
         $selectedOption.addClass('incorrect');
       }

    });

  }

}

Quiz.init();
