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
            $('#intro-banner-content p').html(to);
        });
    });

    // Branding
    wp.customize( 'courses_branding_tint', function( value ) {
        value.bind( function( to ) {
            if (to == 'light') {
                $('#intro-banner').css('background-color', '#EBEBEB');
            } else {
                $('#intro-banner').css('background-color', '#1B1B1B');
            }
        });
    });

} )( jQuery )