;(function($){
    'use strict';

    $('.tabs-nav a').click(function() {
    
        // Check for active
        $('.tabs-nav li').removeClass('active');
        $(this).parent().addClass('active');
    
        // Display active tab
        let currentTab = $(this).attr('href');
        $('.tabs-content div').hide();
        $(currentTab).show();
    
        return false;
    });

    // Show the first tab and hide the rest
    // $('#tabs-nav li:first-child').addClass('active');
    // $('.tab-content').hide();
    // $('.tab-content:first').show();

    // // Click function
    // $('#tabs-nav li').click(function(){
    // $('#tabs-nav li').removeClass('active');
    // $(this).addClass('active');
    // $('.tab-content').hide();
    
    // var activeTab = $(this).find('a').attr('href');
    // $(activeTab).fadeIn();
    //     return false;
    // });


})(jQuery); // End of use strict