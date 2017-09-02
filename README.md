
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

GulpJS is a task runner. Below is a list of tasks you can run inside your terminal.

**`gulp cssmin`**
- Processes PostCSS and includes support for [CSSNext](//cssnext.io/) as well as [LostGrid](//lostgrid.org/)
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
- Listens for changes within any `php`, `js` or `css` file
- Applies `gulp cssmin` or `gulp jsmin` as needed
- The [LiveReload](https://chrome.google.com/webstore/detail/livereload/jnihajbhpnppcggbcgedagnkighmdlei) browser extension must be active
- Will keep running until you hit `crtl+c` within the terminal

**`gulp potfile`**
- Create a `.pot` file to be used for translations
- Please see the Translation section below for more information

**`gulp`**
- Runs `gulp cssmin`, `gulp jsmin`, `gulp imgmin` and `gulp potfile` once

## PostCSS, CSSNext and Shoelace

PostCSS is a JavaScript framework which processes CSS files. [CSSNext](//cssnext.io/) is a [PostCSS](https://postcss.org) plugin which helps you use the latest CSS syntax. The [Shoelace](//shoelace.style/) CSS framework is included by default to demonstrate the syntax.

## ES6 Resources

- https://laracasts.com/series/es6-cliffsnotes
- https://babeljs.io/learn-es2015/

## Translation

1) While developing, wrap any hard coded translatable text strings in their [appropriate WP function](https://developer.wordpress.org/themes/functionality/internationalization/#localization-functions).
2) Revisit `gulpfile.js` and make sure the `domain` property inside `wpPot()` matches your theme's text domain.
3) Run `gulp potfile` to create a `.pot` file inside the languages folder.
4) To translate the `.pot` file and create the necessary `.po` and `.mo` files, you can use either [Poedit](https://poedit.net/) or [Loco Translate](https://wordpress.org/plugins/loco-translate/).

Please visit the following link to learn more about internationalization:
https://developer.wordpress.org/themes/functionality/internationalization/

## Theme Updates
Update conflicts with themes from wordpress.org arise from themes having identical folder names. To avoid such conflicts simply make sure that your theme's folder name is unique (e.g. via a prefix).

## Versioning
To update your themes version, as found inside the `style.css` file, simply bump the version inside your `package.json` file and run `gulp cssmin`.
