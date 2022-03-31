/*Start of Common Carousel*/
$(function () {
    var _carousel = $('.js-carousel');
    _carousel.each(function () {

        var _this = $(this);
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

            if (_slidesDestroy.length > 0 && parseInt(_slidesDestroy[i + 1])) {
                _responsiveArray.push({
                    breakpoint: _bp,
                    settings: "unslick"
                });
            }
            else {
                _responsiveArray.push({
                    breakpoint: _bp,
                    settings: {
                        slidesToShow: parseInt(parseInt(_slidesToShow.length > 1 ? _slidesToShow[i + 1] : "2")),
                        vertical: false
                    }
                });
            }

        });

        _this.slick({
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
            responsive: _responsiveArray
        });
    });
});

/*End of Common Carousel*/