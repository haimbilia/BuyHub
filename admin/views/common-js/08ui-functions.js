/* 
STARTS triggers & toggles[

data-trigger => value = target element id to be opened
data-bs-target-close => value = target element id to be closed
data-close-on-click-outside => value 
*/

$(document).ready(function () {
    $("body")
        .find("*[data-trigger]")
        .click(function () {

            var targetElmId = $(this).data("trigger");
            var elmToggleClass = targetElmId + "--on";
            if ($("body").hasClass(elmToggleClass)) {
                $("body").removeClass(elmToggleClass);
            } else {
                $("body").addClass(elmToggleClass);
            }
        });

    $("body")
        .find("*[data-bs-target-close]")
        .click(function () {
            var targetElmId = $(this).data("target-close");
            $("body").toggleClass(targetElmId + "--on");
        });

    $("body").mouseup(function (event) {
        if (
            $(event.target).data("trigger") != "" &&
            typeof $(event.target).data("trigger") !== typeof undefined
        ) {
            event.preventDefault();
            return;
        }

        $("body")
            .find("*[data-close-on-click-outside]")
            .each(function (idx, elm) {
                var slctr = $(elm);
                if (!slctr.is(event.target) && !$.contains(slctr[0], event.target)) {
                    $("body").removeClass(slctr.data("close-on-click-outside") + "--on");
                }
            });
    });



    new ScrollHint('.js-scrollable');
});

$(function () {
    jQuery(".stellarnav").stellarNav({
        theme: "custom",
        breakpoint: 1024,
        position: "left",
    });

    let currentTheme = localStorage.getItem("data-theme");
    if (currentTheme == "dark") {
        $("html").attr("data-theme", "dark");
        $(".theme-switch").removeClass("light").addClass("dark");
        $("#dark").hide();
        $("#light").show();
    } else {
        $("html").attr("data-theme", "light");
        $(".theme-switch").removeClass("dark").addClass("light");
        $("#dark").show();
        $("#light").hide();
    }

    //console.log(currentTheme);
});

function switchTheme(e) {
    if ($(".theme-switch").hasClass("dark")) {
        $("html").attr("data-theme", "light");
        localStorage.setItem("data-theme", "light");
        $(".theme-switch").removeClass("dark").addClass("light");
        $("#dark").show();
        $("#light").hide();
    } else {
        $("html").attr("data-theme", "dark");
        localStorage.setItem("data-theme", "dark");
        $(".theme-switch").removeClass("light").addClass("dark");
        $("#dark").hide();
        $("#light").show();
    }
}

$(".theme-switch").on("click", function (e) {
    switchTheme();
});

$(document).on('click', '.dropdown-menu', function (e) {
    e.stopPropagation();
});

$(document).on('click', '.collapse', function (e) {
    e.stopPropagation();
});
