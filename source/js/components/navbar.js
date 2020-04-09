
const $ = jQuery || {}

export default options => {
    let opt = $.extend({
        animation: "slide",
        animationSpeed: 250,
    }, options)
}
