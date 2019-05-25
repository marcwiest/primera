import debounce from 'lodash/debounce';

const $    = window.jQuery || {};
const wp   = window.wp || {};
const $win = jQuery(window);
const $doc = jQuery(document);

let vh = document.body.clientHeight;
let vw = document.body.clientWidth;
let fromTop = $win.scrollTop();

window.addEventListener('resize', debounce(event => {
    vh = document.body.clientHeight;
    vw = document.body.clientWidth;
}, 100 ));

document.addEventListener('scroll', debounce(event => {
    fromTop = $win.scrollTop();
}, 100 ));

export         { $, $win, $doc, wp, vh, vw, fromTop };
export default { $, $win, $doc, wp, vh, vw, fromTop };
