
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
- Applies `cssmin` or `jsmin` as needed
- Activated [LiveReload](https://chrome.google.com/webstore/detail/livereload/jnihajbhpnppcggbcgedagnkighmdlei) browser extension is required
- Will keep running until you hit `crtl+c`

**`gulp`**
- Runs `cssmin`, `jsmin` and `imgmin` once

## Shoelace CSS

The [Shoelace](//shoelace.style/) CSS Framework is included by default to demonstrate PostCSS.

## PostCSS & ES6 Resources

Please visit the following links to learn more:

- https://postcss.org
- https://webdesign.tutsplus.com/series/postcss-deep-dive--cms-889
- https://laracasts.com/series/es6-cliffsnotes
- https://babeljs.io/learn-es2015/

## Translation

1) While developing, wrap any hard coded translatable text strings in their [appropriate WP function](https://developer.wordpress.org/themes/functionality/internationalization/#localization-functions).
2) Revisit `gulpfile.js` and make sure the `domain` property inside `wpPot()` matches your theme's text domain.
3) Run `gulp potfile` to create a `.pot` file inside the languages folder.
4) To translate the `.pot` file and create the necessary `.po` and `.mo` files, you can use either [Poedit](https://poedit.net/) or [Loco Translate](https://wordpress.org/plugins/loco-translate/).

Please visit the following link to learn more about internationalization:
https://developer.wordpress.org/themes/functionality/internationalization/
