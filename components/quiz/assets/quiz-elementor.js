// See https://www.ibenic.com/ultimate-guide-for-javascript-in-elementor-widgets/


class QuizWidgetHandlerClass extends elementorModules.frontend.handlers.Base {

  onElementChange( propertyName ) {
    console.log('times are changing they are! ' + propertyName )
  }

  getDefaultSettings() {
    return {
      selectors: {
        button: '.buttonClassName',
        content: '.contentClassName',
      },
    };
  }

  getDefaultElements() {
    const selectors = this.getSettings( 'selectors' );

  }

  bindEvents() {

  }

}



jQuery( window ).on( 'elementor/frontend/init', () => {

   const addHandler = ( $element ) => {
     elementorFrontend.elementsHandler.addHandler( QuizWidgetHandlerClass, {
       $element,
     });
   };

   elementorFrontend.hooks.addAction( 'frontend/element_ready/saber_quiz.default', addHandler );

});
