import counterUp from "counterup2";
import AOS from "aos";

require("waypoints/lib/noframework.waypoints.js");

// // aos
AOS.init({
    // Global settings:
    offset: 120, // offset (in px) from the original trigger point
    delay: 0, // values from 0 to 3000, with step 50ms
    duration: 400, // values from 0 to 3000, with step 50ms
    easing: "ease", // default easing for AOS animations
    once: false, // whether animation should happen only once - while scrolling down
    anchorPlacement: "top-bottom", // defines which position of the element regarding to window should trigger the animation
});

// // counter up
const els = document.querySelectorAll(".count");
els.forEach(function (el) {
    new Waypoint({
        element: el,
        delay: 30,
        time: 15000,
        handler: function () {
            counterUp(el);
            this.destroy();
        },
        offset: "bottom-in-view",
    });
});

$(`[href="#"]`).on(`click`, function (e) {
    e.preventDefault();
});

// $(`.btn-jump-top`).on(`click`, function (e) {
//     $(`html, body`).animate(
//         {
//             scrollTop: 0,
//         },
//         $(`body`).height() * 2.5
//     );
// });

// $(`.hero-banner`)
//     .find(`.btn-grp a`)
//     .on(`mouseenter`, function (e) {
//         let self = $(this);

//         let opposite = self.parent().find(`a`).not(self);

//         opposite.removeClass(`primary`).addClass(`secondary`);
//         self.removeClass(`secondary`).addClass(`primary`);
//     });

// $(document).ready(function (e) {
//     setTimeout(() => {
//         $(`.start-loading`).remove();
//     }, 1000);
// });

$(document).ready(function () {
    // Smooth scroll when clicking on links
    $('a[href^="#"]:not([href="#"])').on("click", function (event) {
        // if($(`#{}`))
        var target = $(this.getAttribute("href"));
        // var target = $(this).attr(`href`);
        // target = $(`${target}`);
        if (target.length > 1) {
            event.preventDefault();
            $("html, body").stop().animate(
                {
                    scrollTop: target.offset().top,
                },
                1000
            );
        }
    });
});

