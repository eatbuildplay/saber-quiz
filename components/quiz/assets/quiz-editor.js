(function($) {

  var QuizEditor = {

    data: {
      timeline: []
    }, // stores the quiz data

    init: function() {

      /* init load */
      var dataJson = $('#quiz-editor-data').val();
      console.log( dataJson )
      QuizEditor.data.timeline = JSON.parse( dataJson );

      /* menu handlers */
      QuizEditor.menuClear();
      QuizEditor.questionSetup();

      $('.quiz-editor-menu button').on('click', function(e) {
        e.preventDefault();
      });

      /* question search handler */
      $('#question-search-button').on('click', function() {
        QuizEditor.searchQuestions();
      });

      /* Click on option returned from search */
      $(document).on('click', '.clickable-option', function() {

        var data = {};
        data.type = $(this).data('type');
        data.id = $(this).data('id');
        data.title = $(this).html();

        // check for duplicate in timeline
        var isDuplicate = QuizEditor.timelineDuplicateCheck( data );
        if( isDuplicate ) {
          console.log('item is duplicate')
          return;
        }

        // move item (or clone item) into quiz timeline
        QuizEditor.insertTimeline( data );

        // update the data
        var timelineItem = {
          type: data.type,
          id: data.id
        };
        QuizEditor.data.timeline.push( timelineItem );
        $('#quiz-editor-data').val( JSON.stringify(QuizEditor.data.timeline));

      });

      /* setup sorting */
      $( '.quiz-editor-timeline-grid' ).sortable({
        stop: function( event, ui ) {
          QuizEditor.sortingHandler();
        }
      });

      /* search clear */
      $(document).on('click', '.ce-search-clear', function(e) {
        e.preventDefault();
        $('#search-form-question .search-results').html('');
        $('#search-form-question .search-box').val('');
      });

      /* trash item */
      $(document).on('click', '.quiz-editor-timeline-item .dashicons-trash', function() {
        $(this).parent().remove();
        QuizEditor.sortingHandler();
      });

    },

    emptySearchHandlerQuestions: function() {
      var msg = '<div class="quiz-editor-empty-search">';
      msg +=    'No results found, please try a different search term.';
      msg +=    '</div>';
      $('#ceLessonSearchResults').append( msg );
    },

    /* Duplicate check */
    timelineDuplicateCheck: function( data ) {

      console.log( data )
      console.log( QuizEditor.data.timeline )

      var isDuplicate = 0;

      QuizEditor.data.timeline.forEach( function( item ) {

        console.log( item.id )
        console.log( data.id )

        if( item.id == data.id ) {
          isDuplicate = 1;
        }

      });

      return isDuplicate;

    },

    menuClear: function() {



    },

    questionSetup: function() {

      $('#question-add-button').on('click', function() {

        QuizEditor.menuClear();
        $('#search-form-question').show();
        $(this).addClass('active');

      });

    },

    /* Insert item to timeline */
    insertTimeline: function( data ) {

      var timelineItem = '<div class="quiz-editor-timeline-item quiz-editor-timeline-item-quiz" data-id="' + data.id + '" data-type="question">';
      timelineItem += data.title;
      timelineItem += '<span class="dashicons dashicons-trash"></span>';
      timelineItem += '</div>';

      var timelineGrid = $('.quiz-editor-timeline-grid');
      timelineGrid.append( timelineItem );

    },

    sortingHandler: function() {

      console.log('sortingHandler')

      // clear existing timeline data
      QuizEditor.data.timeline = [];

      $('.quiz-editor-timeline-item').each( function( index, item ) {

        var itemEl = $(item);

        // update the data
        var timelineItem = {
          type: itemEl.data('type'),
          id: itemEl.data('id')
        };
        QuizEditor.data.timeline.push( timelineItem );

      });

      console.log( QuizEditor.data.timeline );

      $('#quiz-editor-data').val( JSON.stringify(QuizEditor.data.timeline));

    },

    searchQuestions: function() {

      data = {
        action: 'saber_quiz_editor_question_search',
        search: $('#lesson-search-box').val(),
      }
      $.post(
        ajaxurl,
        data,
        function( response ) {

          console.log( response );
          var searchResultsEl = $('#search-form-question .search-results');

          searchResultsEl.html('');
          response = JSON.parse(response);

          if( response.items.length == 0 ) {
            QuizEditor.emptySearchHandlerQuestions();
            return;
          }

          response.items.forEach( function( item ) {

            console.log( item )

            var clickableOption = '<div class="clickable-option" data-id="' + item.id + '" data-type="question">';
            clickableOption += '<h4>' + item.title + '</h4>';
            clickableOption += '</div>';

            searchResultsEl.append( clickableOption );

          });

          var clearButton = '<button class="ce-search-clear">';
          clearButton += 'Clear';
          clearButton += '</button>';
          $('#ceLessonSearchResults').append( clearButton );

        }
      );

    },

  } // end QuizEditor


  // init
  QuizEditor.init();

})( jQuery );
