$('#nav-button').on('click', function() {
    $(this).magnificPopup({
        items: {
            src: '.category-main-popup',
            type: 'inline'
        },

        removalDelay: 300,
        fixedContentPos: 'true',
        fixedBgPos: 'auto',
        overflowY: 'hidden',
        mainClass: 'mfp-fade',
        closeBtnInside: false
    });
})

// Mobile button
$('.for-mobile #search-button').click(function() {
    $('#search-bar').toggleClass('open');
})

$('.category .menu .menu-badge').on('click', function(event) {
    if ($(this).closest('.mfp-content').length) {
        event.preventDefault();

        let currentItem = $(this).closest('li');
        $('.category .menu li').not(currentItem).removeClass('down');
        currentItem.toggleClass('down');
    }
})

var headerBreakpoint = function() {
    const body = $('body');
    // 849
    if ($( window ).width() < 992 && !body.hasClass('screen-sm')) {
        body.toggleClass('screen-sm');
    } 
    else if ($( window ).width() > 992 && body.hasClass('screen-sm')) {
        body.toggleClass('screen-sm');
    }
}

headerBreakpoint();

$( window).resize(function() {
    headerBreakpoint();
});