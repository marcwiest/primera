import debounce from 'lodash/debounce';

const wp   = window.wp || {};
const $    = window.jQuery || {};
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

export         { wp, $, $win, $doc, vh, vw, fromTop };
export default { wp, $, $win, $doc, vh, vw, fromTop };
