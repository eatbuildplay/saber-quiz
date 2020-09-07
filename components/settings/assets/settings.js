jQuery(document).ready(function($) {

  /* save settings */
  $('#sq_settings_save_button').on('click', function() {

    var formData = $('#sq_settings_form').serialize();
    console.log( formData );

    data = {
      action: 'saber_quiz_settings_save'
    }
    $.post(
      ajaxurl,
      data,
      function( response ) {
        console.log( 'response from save')
      }
    );

  });

  /* setup settings tabs */
  $('#saber-settings-tabs').tabs();

  //hover states on the static widgets
  $('#dialog_link, ul#icons li').hover(
    function() { $(this).addClass('ui-state-hover'); },
    function() { $(this).removeClass('ui-state-hover'); }
  );

});
