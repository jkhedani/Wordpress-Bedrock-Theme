( function( $ ){

  //  Example function
  //  wp.customize('setting_name',function( value ) {
  //      value.bind(function(to) {
  //          $('.posttitle').css('color', to ? '#' + to : '' );
  //      });
  //  });

  // Course Number postMessage
  wp.customize('blogname',function( value ) {
    value.bind(function(to) {
      $('.site-title a').html(to);
    });
  });

  // Course Name
  wp.customize('blogdescription',function( value ) {
    value.bind(function(to) {
      $('#site-description').html(to);
    });
  });

  // Courses Description
  wp.customize( 'courses_short_desc', function( value ) {
    value.bind( function( to ) {
      $('.intro-banner-content p').html(to);
    });
  }); 

  // Course Affiliations
  wp.customize('courses_branding_college_affil',function( value ) {
    value.bind(function(to) {
      $('#navbar .site-affiliation').attr('data-affil',to);
      $('.college-branding').attr('data-affil',to);
    });
  });

  // Branding
  // wp.customize( 'courses_branding_tint', function( value ) {
  //     value.bind( function( to ) {
  //         if (to == 'light') {
  //             $('#intro-banner').css('background-color', '#EBEBEB');
  //         } else {
  //             $('#intro-banner').css('background-color', '#1B1B1B');
  //         }
  //     });
  // });

  // Layout: IA
  wp.customize( 'courses_layout_ia', function( value ) {
    value.bind( function( to ) {
      // Update the combined value storing the two layout values
      // if (!$('#hiddenLayoutSettings').length) {
      //   $('body').append("<input type='hidden' id='hiddenLayoutSettings' value='default,default' />");
      // }
      var hiddenLayoutSettingsArray = $('#hiddenLayoutSettings').val().split(',');
      hiddenLayoutSettingsArray[0] = to;
      $('#hiddenLayoutSettings').val(hiddenLayoutSettingsArray.join(','));

      // React to layout values
      var layoutSettingsArray = $('#hiddenLayoutSettings').val().split(',');
      updateLayout(layoutSettingsArray[0], layoutSettingsArray[1]);
    });
  });

  // Layout: Visual
  wp.customize( 'courses_layout_template', function( value ) {
    value.bind( function( to ) {
      // Update the combined value storing the two layout values
      // if (!$('#hiddenLayoutSettings').length) {
      //   $('body').append("<input type='hidden' id='hiddenLayoutSettings' value='default,default' />");
      // }
      var hiddenLayoutSettingsArray = $('#hiddenLayoutSettings').val().split(',');
      hiddenLayoutSettingsArray[1] = to;
      $('#hiddenLayoutSettings').val(hiddenLayoutSettingsArray.join(','));

      // React to layout values
      var layoutSettingsArray = $('#hiddenLayoutSettings').val().split(',');
      updateLayout(layoutSettingsArray[0], layoutSettingsArray[1]);
    });
  });

  // Helper function: modify body classes based on two layout options (info architecture, visual layout)
  function updateLayout(ia, visual) {

    if ((ia=='modulesLessons') && (visual=='singular')) {
      $('body').toggleClass('modules-lessons', true).toggleClass('units-modules-lessons', false);
      $('body').toggleClass('single-layout', true).toggleClass('nested-layout', false).toggleClass('custom-layout', false);
      $('#singularModulesLessons').toggleClass('hide',false);
      $('#nestedModulesLessons').toggleClass('hide',true);
      $('#unitsModulesLessons').toggleClass('hide',true);
      $('body.modules-lessons.single-layout #main ol#singularModulesLessons').equalHeights(); // Makes all the module blocks even heights based on title
    } else if ((ia=='modulesLessons') && (visual=='nested')) {
      $('body').toggleClass('modules-lessons', true).toggleClass('units-modules-lessons', false);
      $('body').toggleClass('single-layout', false).toggleClass('nested-layout', true).toggleClass('custom-layout', false);
      $('#singularModulesLessons').toggleClass('hide',true);
      $('#nestedModulesLessons').toggleClass('hide',false);
      $('#unitsModulesLessons').toggleClass('hide',true);
    } else if (ia=='unitsModulesLessons') {
      $('body').toggleClass('modules-lessons', false).toggleClass('units-modules-lessons', true);
      $('body').toggleClass('single-layout', false).toggleClass('nested-layout', false).toggleClass('custom-layout', true);
      $('#singularModulesLessons').toggleClass('hide',true);
      $('#nestedModulesLessons').toggleClass('hide',true);
      $('#unitsModulesLessons').toggleClass('hide',false);
    }
    //else if ((ia=='unitsModulesLessons') && )
    //  $('body').toggleClass('modules-lessons', false).toggleClass('units-modules-lessons', true);

    // if (visual=='singular')
    //   $('body').toggleClass('single-layout', true).toggleClass('nested-layout', false).toggleClass('custom-layout', false);
    // else if (visual=='nested')
    //   $('body').toggleClass('single-layout', false).toggleClass('nested-layout', true).toggleClass('custom-layout', false);
    // else
    //   $('body').toggleClass('single-layout', false).toggleClass('nested-layout', false).toggleClass('custom-layout', true);
  }

} )( jQuery )
