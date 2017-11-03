(function($) {
    function updateExternalLinks() {
        $("a[href*='http://']:not([href*='" + location.hostname.replace('www.', '') + "'])").attr('target', '_blank');
        $("a[href*='https://']:not([href*='" + location.hostname.replace('www.', '') + "'])").attr('target', '_blank');
    }

    function initFactDetails() {
        $('#page1 .col-sm-6 h3').popover('hide');
        $('#page1 .col-sm-6 h3 i').remove();
        $('#page1 .col-sm-6 h3').css({ cursor: 'pointer' }).append(' <i class="fa fa-chevron-circle-right" style="font-size: .8em; margin-left: 8px"></i>');
        $('#page1 .col-sm-6 h3').each(function (index) {
            jQuery(this).unbind('click').click(function (event) {
                $('#page1 .col-sm-6 h3').popover('destroy');
                var placement = window.innerWidth < 768 ? 'top' : (index == 0 || index == 2 ? 'right' : 'left');
                $(this).popover({
                    container: 'body',
                    title: $(this).text(),
                    content: '<ul class="fa-ul">' + $(this).next('ul').html() + '</ul>',
                    html: true,
                    trigger: 'click focus',
                    placement: 'auto ' + placement
                }).popover('show');
            });
        });
    }

    function initFactScreens() {
        jQuery('#page1 a.image-link').magnificPopup({
            type: 'image',
            closeOnContentClick: true,
            image: {
                titleSrc: 'title',
                verticalFit: true
            },
            gallery: {
                enabled: true,
                navigateByImgClick: true,
                arrowMarkup: '<button title="%title%" type="button" class="mfp-arrow mfp-arrow-%dir%"></button>',
                tPrev: Translator.__('Previous (Left arrow key)'),
                tNext: Translator.__('Next (Right arrow key)'),
                tCounter: '<span class="mfp-counter">%curr% ' + Translator.__('of') + ' %total%</span>'
            },
            zoom: {
                enabled: true,
                duration: 300,
                easing: 'ease-in-out'
            }
        });
    }

    function initFactHeight() {
        leftHeadings = $('.col-sm-6 .left h3');
        rightHeadings = $('.col-sm-6 .right h3');
        leftHeadings.eq(0).add(rightHeadings.eq(0)).matchHeight();
        leftHeadings.eq(1).add(rightHeadings.eq(1)).matchHeight();
    }

    function updateExtensionsList(event) {
        event.preventDefault();
        $(this).find('i').addClass('fa-spin');
        $.ajax({
            method: 'GET',
            url: Routing.generate('zikulazksitetheme_ajax_getextensions'),
            data: {
                searchTerm: $('#extensionsFilter').val()
            },
            success: function(data) {
                $('#extensionsListContainer').html(data);
                updateExternalLinks();
                initExtensionsFiltering();
            }
        });
    }

    function initExtensionsFiltering() {
        if ($('#extensionsFilterGroup').length < 1) {
            return;
        }

        $('#extensionsFilterGroup').removeClass('hidden');
        $('#extensionsFilter').keyup(function(event) {
            if (event.keyCode == 13) {
                updateExtensionsList(event);
            }
        });
        $('#btnApplyFilter').click(updateExtensionsList);
    }

    $(document).ready(function() {
        updateExternalLinks();

        if ($('#page1').length > 0) {
            initFactDetails();
            $(window).resize(initFactDetails);
            initFactScreens();
            initFactHeight();
            $(window).resize(initFactHeight);
            var leftHeadings, rightHeadings;
        }

        $('#vendorList a').tooltip();

        initExtensionsFiltering();
    });
})(jQuery)
