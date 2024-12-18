jQuery(function($){



    // ACS functions



    $(document).on("click", ".acs-button", function (){

        $("#wemake-acs").toggleClass("active");

    });

    $(document).on("click", ".icon-vector1", function (){

        $("#wemake-acs").removeClass("active");

    });


    $(document).on("click", function (e){



        let acsMenu = $("#wemake-acs"),

            callPp = $(".call-popup");



        if(e.target != acsMenu[0] && !acsMenu.has(e.target).length) {

            acsMenu.removeClass("active");

        }



        if(e.target != callPp[0] && !callPp.has(e.target).length) {

            callPp.removeClass("active");

        }



    });



    $.fn.removeAcsClass = function (pattern){



        let el = $(this),

            items = [],

            re = new RegExp(pattern);



        $.each(el.attr("class").split(/\s+/), function (index, item){

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

        zoomElements = $("body,h1,h2,h3,h4,h5:not('.acs-title'),h6:not('.acs-title'),p:not('.acs-wemake'),li:not('.acs'),a:not('.acs-link'):not(.acs-powered):not(.wm-poweredby-logo),span,div.icon-item_text,.fr-text"),

        zoomStep = 1.1,

        maxSize = 200,

        minSize = 10,

        zoomInArray = [],

        zoomOutArray = [];



    function zoomIn(){



        zoomOutArray = [];



        if(Math.max.apply(null, zoomInArray) < maxSize){



            zoomInArray = [];

            body.addClass("acs-" + acsAction);



            zoomElements.each(function(){



                let fontSizeVal = $(this).css("fontSize").slice(0, -2),

                    fontSizeValCalc = Math.ceil(fontSizeVal * zoomStep);



                if(fontSizeValCalc){

                    zoomInArray.push(fontSizeValCalc);

                    $(this).css("fontSize", fontSizeValCalc + "px");

                }



            });



        }



    }



    function zoomOut(){



        zoomInArray = []



        if(Math.min.apply(null, zoomOutArray) > minSize){



            zoomOutArray = [];

            body.removeAcsClass(/acs-zoom/);



            zoomElements.each(function (){

                let fontSizeVal = $(this).css("fontSize").slice(0, -2),

                    fontSizeValCalc = Math.floor(fontSizeVal / zoomStep);

                if(fontSizeValCalc){

                    zoomOutArray.push(fontSizeValCalc);

                    $(this).css("fontSize", fontSizeValCalc + "px");

                }

            });



        }



    }



    function zoomReset(){



        zoomInArray = [];

        zoomOutArray = [];



        zoomElements.each(function (){

            $(this).removeAttr("style");

        });



        if(typeof(sessionStorage)!=="undefined"){

            sessionStorage.removeItem("acs_body_class");

            sessionStorage.removeItem("acs_zoom_fz");

        }



    }



    $(document).on("click", ".acs-link", function (e){



        e.preventDefault();



        acsAction = $(this).data("action");



        switch (acsAction) {

            case "clear":

                zoomReset();

                body.removeAcsClass(/acs-/);

                body.removeClass("acs-zoom");

                $(".acs-link").removeClass("active");

                break;

            case "zoomIn":

                zoomIn();

                body.addClass("acs-zoom acs-zoomIn");

                body.removeClass("acs-zoomOut");

                $(this).addClass("active");

                $(".acs-link[data-action='zoomOut']").removeClass("active");

                break;

            case "zoomOut":

                zoomOut();

                body.addClass("acs-zoom acs-zoomOut");

                body.removeClass("acs-zoomIn");

                $(this).addClass("active");

                $(".acs-link[data-action='zoomIn']").removeClass("active");

                break;

            case "contrast":

            case "contrast-negative":

            case "contrast-light":

                if(acsAction!=="contrast"){

                    body.removeClass("acs-contrast");

                    $(".acs-link[data-action='contrast']").removeClass("active");

                }

                if(acsAction!=="contrast-negative"){

                    body.removeClass("acs-contrast-negative");

                    $(".acs-link[data-action='contrast-negative']").removeClass("active");

                }

                if(acsAction!=="contrast-light"){

                    body.removeClass("acs-contrast-light");

                    $(".acs-link[data-action='contrast-light']").removeClass("active");

                }

                body.toggleClass("acs-" + acsAction);

                break;

            case "cursor-w":

                body.removeClass("acs-cursor-b");

                body.toggleClass("acs-cursor-w");

                $(".acs-link[data-action='cursor-b']").removeClass("active");

                break;

            case "cursor-b":

                body.removeClass("acs-cursor-w");

                body.toggleClass("acs-cursor-b");

                $(".acs-link[data-action='cursor-w']").removeClass("active");

                break;

            default:

                // Add class to the body tag

                body.toggleClass("acs-" + acsAction);

        }



        if(acsAction!=="clear" && acsAction!=="zoomIn" && acsAction!=="zoomOut"){

            $(this).toggleClass("active");

        }



        // Save changes to session storage



        if(acsAction!=="clear" && typeof(sessionStorage)!=="undefined"){



            let body_class = body.attr("class"),

                acs_body_class = [],

                zoom = false;



            if(body_class.length){

                body_class = body_class.split(" ");

                for(let ii=0;ii<body_class.length;ii++){

                    if(body_class[ii].search("acs") >= 0){

                        acs_body_class.push(body_class[ii]);

                    }

                    if(body_class[ii]==="acs-zoom"){

                        zoom = true;

                    }

                }

            }



            sessionStorage.setItem("acs_body_class", acs_body_class.join(" "));



            if(zoom){

                sessionStorage.setItem("acs_zoom_fz", body.css("font-size"));

            }



        }



        window.setTimeout(function(){

            $(window).trigger("resize");

        },500);



    });



    // Restore changes from session storage



    if(typeof(sessionStorage)!=="undefined"){



        let acs_body_class = sessionStorage.getItem("acs_body_class"),

            acs_zoom_fz = sessionStorage.getItem("acs_zoom_fz");



        if(acs_body_class!==null){



            body.addClass(acs_body_class);

            acs_body_class = acs_body_class.split(" ");



            for(let ii=0;ii<acs_body_class.length;ii++){

                acs_body_class[ii] = acs_body_class[ii].replace(/acs-/, "");

                $(".acs-link[data-action=" + acs_body_class[ii] + "]").addClass("active");

            }



        }



        if(acs_zoom_fz!==null){

            zoomElements.each(function(){

                $(this).css("fontSize", acs_zoom_fz);

            });

        }



    }



    // Tab button press



    $(document).on("keydown", function(e){

        if(e.keyCode===9){

            $("body").addClass("wmacs-tab");

        }

    });



    $(document).on("mousedown", function(){

        $("body").removeClass("wmacs-tab");

    });



    // FIX for carousels



    $(".owl-carousel a,.bx-wrapper a").attr("tabindex", "-1");



});



function wmacs_ie_browser(){

    return navigator.userAgent.indexOf("MSIE ") > -1 || navigator.userAgent.indexOf("Trident/") > -1;

}