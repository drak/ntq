(function($) {
    function updateExternalLinks() {
        $("a[href*='http://']:not([href*='" + location.hostname.replace('www.', '') + "'])").attr('target', '_blank');
        $("a[href*='https://']:not([href*='" + location.hostname.replace('www.', '') + "'])").attr('target', '_blank');
    }

    function initFactDetails() {
        $('#page1 .col-sm-6 h3')
            .css({ cursor: 'pointer' })
            .append(' <i class="fa fa-chevron-circle-right" style="font-size: .8em; margin-left: 8px"></i>')
            .each(function (index) {
                var headingId, listId;

                headingId = 'featureHeading' + (index + 1);
                listId = 'featureCollapse' + (index + 1);

                $(this)
                    .attr('id', headingId)
                    .attr('role', 'button')
                    .data('toggle', 'collapse')
                    .data('parent', $(this).parent().parent().parent().parent())
                    .attr('href', '#' + listId)
                    .attr('aria-expanded', 'false')
                    .attr('aria-controls', listId)
                    .click(function (event) {
                        $(this).parent().parent().parent().parent().find('.collapse').collapse('hide');
                        $(this).next('.collapse').collapse('show');
                    })
                ;
                $(this).next('ul.fa-ul')
                    .attr('id', listId)
                    .addClass('collapse')
                    .attr('role', 'tabpanel')
                    .attr('aria-labelledby', headingId)
                ;
            })
        ;
        $('.collapse').on('shown.bs.collapse hidden.bs.collapse', equalFactHeight);
    }

    function initFactScreens() {
        $('#page1 a.image-link').magnificPopup({
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

    function equalFactHeight() {
        var leftSide, rightSide, leftHeadings, rightHeadings;

        leftSide = $('.col-sm-6 .left').first();
        rightSide = $('.col-sm-6 .right').first();
        leftHeadings = leftSide.find('h3');
        rightHeadings = rightSide.find('h3');
        leftHeadings.eq(0).add(rightHeadings.eq(0)).matchHeight();
        leftHeadings.eq(1).add(rightHeadings.eq(1)).matchHeight();

        leftSide.add(rightSide).css('height', 'auto');
        if (window.innerWidth > 767) {
            if (leftSide.height() > rightSide.height()) {
                rightSide.height(leftSide.height());
            } else {
                leftSide.height(rightSide.height());
            }
        }
    }

    function equalDownloadsHeight() {
        $('#page2 .col-sm-4 .coremanager-button a').matchHeight();
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
            initFactScreens();
            equalFactHeight();
            $(window).resize(equalFactHeight);
        } else if ($('#page2').length > 0) {
            equalDownloadsHeight();
            $(window).resize(equalDownloadsHeight);
        }

        $('#vendorList a').tooltip();

        initExtensionsFiltering();
    });
})(jQuery)
