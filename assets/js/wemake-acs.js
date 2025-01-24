jQuery(function ($) {
    // ACS functions
    $(document).on("click", ".wm-plg-acs-button", function () {
        $("#wemake-plg-acs-frontend").toggleClass("active");
    });

    $(document).on("click", ".wm-i-v1.icon-vector1", function () {

        $("#wemake-plg-acs-frontend").removeClass("active");

    });

    $(document).on("click", function (e) {


        let acsMenu = $("#wemake-plg-acs-frontend"),

            callPp = $(".call-popup");


        if (e.target != acsMenu[0] && !acsMenu.has(e.target).length) {

            acsMenu.removeClass("active");

        }


        if (e.target != callPp[0] && !callPp.has(e.target).length) {

            callPp.removeClass("active");

        }


    });

    $.fn.removeAcsClass = function (pattern) {


        let el = $(this),

            items = [],

            re = new RegExp(pattern);


        $.each(el.attr("class").split(/\s+/), function (index, item) {

            if (re.test(item)) {

                items.push(item);

            }

        });


        el.removeClass(items.join(" "));


        $(window).trigger("resize");


        return el;


    };

    let acsAction,
        body = $("body"),
        zoomStepX = 1,
        maxScaleSize = 1.8,
        minScaleSize = 1,
        zoomStep = 1.1,
        zoomElements = $(
            "body, h1, h2, h3, h4, h5, h6, p, li, a, span,label, ol, strong, b, i, del, ins, sup, sub, small, mark"
        ).not("#wemake-plg-acs-frontend *");

        // zoomElements = $("body,h1,h2,h3,h4,h5:not('.wm-plg-acs-title'),h6:not('.acs-title'),p:not('.wm-plg-acs-wemake-powered-wrapper'),li:not('.wm-plg-acs-item'),a:not('.wm-plg-acs-link-item'):not(.wm-plg-acs-powered):not(.wm-poweredby-logo),span,div.icon-item_text,.fr-text"),



    function zoomIn() {
        if (zoomStepX >= minScaleSize && zoomStepX < maxScaleSize) {

            zoomStepX = zoomStepX === 1 ? zoomStep : zoomStepX * zoomStep;

            body.addClass("wm-plg-acs-" + acsAction);

            setZoomInSizeToElements(zoomStep);
        }
    }

    function setZoomInSizeToElements(zoomStep) {
        zoomElements.each(function () {
            let fontSizeVal = $(this).css("fontSize").slice(0, -2),
                fontSizeValCalc = fontSizeVal * zoomStep;

            if (fontSizeValCalc) $(this).css("fontSize", fontSizeValCalc + "px");
        });
    }

    function zoomOut() {
        if (zoomStepX > minScaleSize) {
            zoomStepX = zoomStepX === 1 ? 1 / zoomStep : zoomStepX / zoomStep;

            body.removeAcsClass(/wm-plg-acs-zoom/);

            if (zoomStepX >= minScaleSize && zoomStepX <= minScaleSize) {
                zoomReset();
            } else {
                setZoomOutSizeToElements(zoomStep);
            }
        }
    }

    function setZoomOutSizeToElements(zoomStep) {
        zoomElements.each(function () {

            let fontSizeVal = $(this).css("fontSize").slice(0, -2),
                fontSizeValCalc = Math.floor(fontSizeVal / zoomStep);

            if (fontSizeValCalc) {
                $(this).css("fontSize", fontSizeValCalc + "px");
            }

        });
    }

    function zoomReset() {
        removeFontSizeInlineFromElements(zoomElements);

        if (typeof (sessionStorage) !== "undefined") {

            sessionStorage.removeItem("acs_body_class");

            sessionStorage.removeItem("acs_zoom_step_fz");

            zoomStepX = minScaleSize;
        }
    }

    function removeFontSizeInlineFromElements(elements) {
        elements.each(function () {
            let style = $(this).attr('style');
            if (style && style.includes('font-size')) {
                let newStyle = style.replace(/font-size:\s*[^;]+;/, '');
                $(this).attr('style', newStyle);
            }
        });
    }

    $(document).on("click", ".wm-plg-acs-link-item", function (e) {

        e.preventDefault();

        acsAction = $(this).data("action");

        switch (acsAction) {

            case "clear":

                zoomReset();

                body.removeAcsClass(/wm-plg-acs-/);

                body.removeClass("wm-plg-acs-zoom");

                $(".wm-plg-acs-link-item").removeClass("active");

                break;

            case "zoomIn":

                zoomIn();

                body.addClass("wm-plg-acs-zoom wm-plg-acs-zoomIn");

                body.removeClass("wm-plg-acs-zoomOut");

                $(this).addClass("active");

                $(".wm-plg-acs-link-item[data-action='zoomOut']").removeClass("active");

                break;

            case "zoomOut":

                zoomOut();

                body.addClass("wm-plg-acs-zoom wm-plg-acs-zoomOut");

                body.removeClass("wm-plg-acs-zoomIn");

                $(this).addClass("active");

                $(".wm-plg-acs-link-item[data-action='zoomIn']").removeClass("active");

                break;

            case "contrast":

            case "contrast-negative":

            case "contrast-light":

                if (acsAction !== "contrast") {

                    body.removeClass("wm-plg-acs-contrast");

                    $(".wm-plg-acs-link-item[data-action='contrast']").removeClass("active");

                }

                if (acsAction !== "contrast-negative") {

                    body.removeClass("wm-plg-acs-contrast-negative");

                    $(".wm-plg-acs-link-item[data-action='contrast-negative']").removeClass("active");

                }

                if (acsAction !== "contrast-light") {

                    body.removeClass("wm-plg-acs-contrast-light");

                    $(".wm-plg-acs-link-item[data-action='contrast-light']").removeClass("active");

                }

                if (acsAction === "contrast-light") {
                    setClassContrastLightVideoTags();
                } else {
                    $('video').removeClass('acs-contrast-light-video');
                }

                body.toggleClass("wm-plg-acs-" + acsAction);

                break;

            case "cursor-w":

                body.removeClass("wm-plg-acs-cursor-b");

                body.toggleClass("wm-plg-acs-cursor-w");

                $(".wm-plg-acs-link-item[data-action='cursor-b']").removeClass("active");

                break;

            case "cursor-b":

                body.removeClass("wm-plg-acs-cursor-w");

                body.toggleClass("wm-plg-acs-cursor-b");

                $(".wm-plg-acs-link-item[data-action='cursor-w']").removeClass("active");

                break;

            default:

                // Add class to the body tag

                body.toggleClass("wm-plg-acs-" + acsAction);

        }


        if (acsAction !== "clear" && acsAction !== "zoomIn" && acsAction !== "zoomOut") {

            $(this).toggleClass("active");

        }

        // Save changes to session storage

        if (acsAction !== "clear" && typeof (sessionStorage) !== "undefined") {


            let body_class = body.attr("class"),

                acs_body_class = [],

                zoom = false;


            if (body_class.length) {

                body_class = body_class.split(" ");

                for (let ii = 0; ii < body_class.length; ii++) {

                    if (body_class[ii].search("acs") >= 0) {

                        acs_body_class.push(body_class[ii]);

                    }

                    if (body_class[ii] === "wm-plg-acs-zoom") {

                        zoom = true;

                    }

                }

            }


            sessionStorage.setItem("acs_body_class", acs_body_class.join(" "));


            if (zoom) {
                sessionStorage.setItem("acs_zoom_step_fz", zoomStepX);
                // sessionStorage.setItem("acs_zoom_fz", body.css("font-size"));
            }

        }


        window.setTimeout(function () {

            $(window).trigger("resize");

        }, 500);


    });

    // Restore changes from session storage
    if (typeof (sessionStorage) !== "undefined") {

        let acs_body_class = sessionStorage.getItem("acs_body_class"),
            acs_zoom_step_fz = +sessionStorage.getItem("acs_zoom_step_fz");

        if (acs_body_class !== null) {
            body.addClass(acs_body_class);

            acs_body_class = acs_body_class.split(" ");

            for (let ii = 0; ii < acs_body_class.length; ii++) {
                acs_body_class[ii] = acs_body_class[ii].replace(/wm-plg-acs-/, "");

                const element = $(".wm-plg-acs-link-item[data-action='" + acs_body_class[ii] + "']");
                if (element.length) element.addClass("active");
            }

            if (acs_body_class.includes('contrast-light')) {
                setClassContrastLightVideoTags();
            }
        }

        if (acs_zoom_step_fz) {
            let initialFontSizes = [];

            zoomElements.each(function () {
                initialFontSizes.push(parseFloat($(this).css("fontSize")));
            });

            zoomElements.each(function (index) {
                let fontSizeValCalc = initialFontSizes[index] * acs_zoom_step_fz;
                $(this).css("fontSize", fontSizeValCalc + "px");
            });

            zoomStepX = acs_zoom_step_fz;
        }
    }

    function setClassContrastLightVideoTags() {
        const videos = $('video');
        const screenWidth = $(window).width();

        if (videos.length) {
            videos.each(function () {
                const video = $(this);
                const videoWidth = video.outerWidth();
                if (videoWidth === screenWidth) {
                    $(this).addClass('acs-contrast-light-video');
                }
            })
        }
    }

    // Tab button press
    $(document).on("keydown", function (e) {
        if (e.keyCode === 9) {
            $("body").addClass("wmacs-tab");
        }
    });

    $(document).on("mousedown", function () {
        $("body").removeClass("wmacs-tab");
    });

    // FIX for carousels
    $(".owl-carousel a,.bx-wrapper a").attr("tabindex", "-1");
});


function wmacs_ie_browser() {

    return navigator.userAgent.indexOf("MSIE ") > -1 || navigator.userAgent.indexOf("Trident/") > -1;

}
