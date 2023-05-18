jQuery(document).ready(function($) {
    // hide all tab panels except the first one
    $('.tab-panel').hide();
    $('#tab1').show();

    // handle tab clicks
    $('.nav-tab').click(function() {
        // remove the active class from all tabs
        $('.nav-tab').removeClass('nav-tab-active');
        // add the active class to the clicked tab
        $(this).addClass('nav-tab-active');
        // hide all tab panels
        $('.tab-panel').hide();
        // show the corresponding tab panel
        var panelId = $(this).attr('href');
        $(panelId).show();
        // prevent default link behavior
        return false;
    });
});
