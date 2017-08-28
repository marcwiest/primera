
A WordPress starter theme with support for PostCSS (inc. autoprefixer), ES6 and LiveReload using GulpJS.

---

## Requirements

1. [Node.js](https://nodejs.org/)
2. [Gulp.js](http://gulpjs.com/)
3. [LiveReload](https://chrome.google.com/webstore/detail/livereload/jnihajbhpnppcggbcgedagnkighmdlei)

## Installation

Place the theme into your themes directory and `cd` into that directory via your terminal. There you run `sudo npm install` and enter you computers admin password to install all gulp plugins.

When you are done, just run `glup watch` and active the [LiveReload](https://chrome.google.com/webstore/detail/livereload/jnihajbhpnppcggbcgedagnkighmdlei) browser extension.

## Gulp Commands

**`gulp cssmin`**
- Processes PostCSS and includes support for [CSSNext](//cssnext.io/) and [LostGrid](//lostgrid.org/)
- Concatenates and minifies all CSS files into style.css
- Runs once

**`gulp jsmin`**
- Processes [ES6](//babeljs.io/learn-es2015/) via [BabelJS](//babeljs.io/)
- Concatenates and minifies all JS files into app.js
- Runs once

**`gulp imgmin`**
- Optimizes all images that are inside the `img` folder
- Runs once

**`gulp watch`**
- Listens for changes within any `.php`, `.js` or `.css` files via [LiveReload](https://chrome.google.com/webstore/detail/livereload/jnihajbhpnppcggbcgedagnkighmdlei)
- Applies `gulp cssmin` or `gulp jsmin` as needed
- Activated [LiveReload](https://chrome.google.com/webstore/detail/livereload/jnihajbhpnppcggbcgedagnkighmdlei) browser extension is required
- Will keep running until you hit `crtl+c`

**`gulp`**
- Runs `gulp cssmin`, `gulp jsmin` and `imgmin` once

## Shoelace CSS

The [Shoelace](//shoelace.style/) CSS Framework is included by default to demonstrate PostCSS but can be removed.

## PostCSS & ES6 Resources

- [postcss.org](//postcss.org)
- [webdesign.tutsplus.com/series/postcss-deep-dive--cms-889](//webdesign.tutsplus.com/series/postcss-deep-dive--cms-889)
- [babeljs.io/learn-es2015/](//babeljs.io/learn-es2015/)
