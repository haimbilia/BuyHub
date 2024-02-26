/* Start of Common Carousel.
This setting is applicable if you want to stop slick slider at any specific resolution.

Pass data-destroy="1,1,1,0". attribute to js-carousel element.
e.g. 1200 = 1(destroy)
     992 = 1(destroy)
     768 = 1(destroy)
     576 = 0(Run Slick slider)
*/

$(function () {
    initCarousel = (element) => {
        if ('undefined' == typeof $.fn.slick) {
            return false;
        }

        if ('undefined' != typeof element) {
            if ('object' != typeof element) {
                var _carousel = element;
            } else if ('string' != typeof element) {
                var element = (0 != element.indexOf('.') ? '.' + element : element);
                var _carousel = $(element);
            } else {
                var _carousel = $('.js-carousel');
            }
        } else {
            var _carousel = 'undefined' != typeof element ? element : $('.js-carousel');
        }

        _carousel.each(function () {
            var _this = $(this);
            if (_this.hasClass('slick-initialized')) {
                return;
            }
            var _slidesToShow = (_this.data("slides")).toString().split(',');
            var _breakpoints = [1200, 992, 768, 576];
            var _responsiveArray = [];
            var _slidesDestroy = [];

            if (_this.data("destroy")) {
                _slidesDestroy = (_this.data("destroy")).toString().split(',');
            } else {
                _slidesDestroy.length = 0;
            }

            _breakpoints.forEach((_bp, i) => {
                if (_slidesDestroy.length > 0 && parseInt(_slidesDestroy[i])) {
                    _responsiveArray.push({
                        breakpoint: _bp,
                        settings: "unslick"
                    });
                }
                else {
                    _responsiveArray.push({
                        breakpoint: _bp,
                        settings: {
                            slidesToShow: parseInt(parseInt(_slidesToShow.length > 1 ? _slidesToShow[i] : "2")),
                            vertical: false
                        }
                    });
                }

            });

            _this.slick({
                rtl: ('rtl' == langLbl.layoutDirection),
                slidesToShow: parseInt(_slidesToShow.length > 0 ? _slidesToShow[0] : "3"),
                slidesToScroll: 1,
                centerMode: _this.data("mode"),
                arrows: _this.data("arrows"),
                vertical: _this.data("vertical"),
                dots: _this.data("slickdots"),
                infinite: _this.data("infinite"),
                prevArrow: (() => { return $('.btn-prev[data-href="#' + _this.attr("id") + '"]') })(),
                nextArrow: (() => { return $('.btn-next[data-href="#' + _this.attr("id") + '"]') })(),
                autoplay: false,
                pauseOnHover: false,
                centerPadding: 0,
                adaptiveHeight: true,
                touchThreshold: 100,
                responsive: _responsiveArray
            });
        });
    }

    initCarousel();
});

/* End of Common Carousel */
