/**
 * Main JS file for Simple Property Management
 * Author: Kael Steinert
 */
jQuery(document).ready(function ($) {

    /**
     * Slideset Properties
     */
    $('.prop-slideset').slick({
        dots: false,
        arrows: true,
        infinite: true,
        speed: 300,
        slidesToShow: 4,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 991,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 650,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });
    /**
     * Gallery Slideset
     */
    $('.gallery-slideset').slick({
        dots: false,
        arrows: true,
        infinite: true,
        speed: 300,
        slidesToShow: 4,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    infinite: true,
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
        ]
    });
    /**
     * Accordion
     */
    var allPanels = $('.accordion > [data-accordion=content]').hide();
    var activePanel = $('.accordion > [data-accordion=content].active').show();
    $('.accordion > [data-accordion=title]').click(function () {
        var target = $(this).next();
        var holder = $(this).closest('.accordion');
        var allPanelTitles = holder.find('> [data-accordion=title]');
        var allPanels = holder.find('[data-accordion=content]');

        if (!$(this).hasClass('active')) {
            allPanelTitles.removeClass('active');
            $(this).addClass('active');
        }
        if (!target.hasClass('active')) {
            allPanels.removeClass('active').slideUp();
            target.addClass('active').slideDown();
        }
        return false;
    });
    /**
     * Property Listing Gallery
     * @type {*}
     */
    var listingGallery = $('#listing-gallery');
    if (listingGallery) {
        var galleryView = listingGallery.find('#gallery-view');
        var galleryNavItems = listingGallery.find('#gallery-nav .thumb-item');
        listingGallery.find('#gallery-nav .thumb-item:first-of-type').addClass('active');
        $('#gallery-nav .thumb-item').click(function () {
            var image = $(this).attr('data-image');
            galleryNavItems.removeClass('active');
            $(this).addClass('active');
            galleryView.css('background-image', 'url(' + image + ')');
        });
    }
    /**
     * Property Listing Gallery Slideset
     */
    $('.prop-gallery-nav').slick({
        dots: false,
        arrows: true,
        infinite: true,
        speed: 300,
        slidesToShow: 4,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 601,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 401,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            }
        ]
    });

});// END document.ready

/*************************************************************************/
/* Window.load  */
/*************************************************************************/
jQuery(window).load(function () {

    /**
     * Smooth Scroll
     */
    jQuery('a.smooth[href^="#"]:not([href="#"])').on('click', function (e) {
        e.preventDefault();
        var target = this.hash;
        var $target = jQuery(target);
        if (jQuery(window).width() > 767 && jQuery(window).width() < 991) {
            var $offset = $target.offset().top - 225;
        }
        else {
            var $offset = $target.offset().top - 180;
        }
        jQuery('html, body').stop().animate({
            'scrollTop': $offset
        }, 900, 'swing', function () {
            window.location.hash = target;
        });
    });

});/* END window.load */

/**
 * Match Height Columns
 * USAGE: data-col=a
 */
function colMatchHeight() {
    var cols = document.querySelectorAll('[data-col]'),
        encountered = [];
    for (i = 0; i < cols.length; i++) {
        var attr = cols[i].getAttribute('data-col');
        if (encountered.indexOf(attr) == -1) {
            encountered.push(attr);
        }
    }
    for (set = 0; set < encountered.length; set++) {
        var col = document.querySelectorAll('[data-col="' + encountered[set] + '"]'),
            group = [];
        for (i = 0; i < col.length; i++) {
            col[i].style.height = 'auto';
            group.push(col[i].scrollHeight);
        }
        for (i = 0; i < col.length; i++) {
            col[i].style.height = Math.max.apply(Math, group) + 'px';
        }
    }
}
window.addEventListener("load", colMatchHeight);
window.addEventListener("resize", colMatchHeight);

/**
 * Proper Parallax
 */
function getTop(elem) {
    var box = elem.getBoundingClientRect();
    var body = document.body;
    var docEl = document.documentElement;
    var scrollTop = window.pageYOffset || docEl.scrollTop || body.scrollTop;
    var clientTop = docEl.clientTop || body.clientTop || 0;
    var top  = box.top +  scrollTop - clientTop;
    return Math.round(top);
}
function parallaxImages() {
    // Set the scroll for each parallax individually
    var plx = document.getElementsByClassName('parallax');
    for(i=0;i<plx.length;i++){
        var height = plx[i].clientHeight;
        var img = plx[i].getAttribute('data-plx-img');
        var plxImg = document.createElement("div");
        plxImg.className += " plx-img";
        plxImg.style.height = (height+(height/2))+'px';
        plxImg.style.backgroundImage = 'url('+ img +')';
        plx[i].insertBefore(plxImg, plx[i].firstChild);
    }
}
window.addEventListener('load', parallaxImages);
function plxScroll(){
    var scrolled = window.scrollY;
    var win_height_padded = window.innerHeight * 1.25;
    // Set the scroll for each parallax individually
    var plx = document.getElementsByClassName('parallax');
    for(i=0;i<plx.length;i++){
        var offsetTop = getTop(plx[i]);
        //var orientation = plx[i].getAttribute('data-plx-o');
        if (scrolled + win_height_padded >= offsetTop) {
            var plxImg = plx[i].getElementsByClassName('plx-img')[0];
            if(plxImg) {
                var plxImgHeight = plxImg.clientHeight;
                var singleScroll = (scrolled - offsetTop) - plxImgHeight/5;
                plxImg.style.top = (singleScroll / 5) + "px";
            }
        }
    }
}
window.addEventListener('load', plxScroll);
window.addEventListener('resize', plxScroll);
window.addEventListener('scroll', plxScroll);

/**
 * Scroll Revealing Items
 */
var isScrolling = false;
window.addEventListener("scroll", throttleScroll);
function throttleScroll(e) {
    if (isScrolling == false) {
        window.requestAnimationFrame(function() {
            scrolling(e);
            isScrolling = false;
        });
    }
    isScrolling = true;
}
document.addEventListener("DOMContentLoaded", scrolling, false);

function scrolling(e) {
    var scrollItems = document.querySelectorAll("[data-reveal]");
    for (var i = 0; i < scrollItems.length; i++) {
        var scrollItem = scrollItems[i];
        var animationType = scrollItems[i].getAttribute('data-reveal');

        if (isPartiallyVisible(scrollItem)) {
            scrollItem.classList.add('animated', animationType);
        } /*else {
            scrollItem.classList.remove('animated', animationType);
        }*/
    }
}
function isPartiallyVisible(el) {
    var elementBoundary = el.getBoundingClientRect();
    var top = elementBoundary.top;
    var bottom = elementBoundary.bottom;
    var height = elementBoundary.height;

    return ((top + height >= 0) && (height + window.innerHeight >= bottom));
}
function isFullyVisible(el) {
    var elementBoundary = el.getBoundingClientRect();
    var top = elementBoundary.top;
    var bottom = elementBoundary.bottom;

    return ((top >= 0) && (bottom <= window.innerHeight));
}
