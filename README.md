
**Primera Theme**

---

See `./vendor/illuminate/support/helpers.php` for additional helper functions.

https://wptavern.com/the-most-common-wordpress-theme-development-mistakes-and-how-to-fix-them

---














OLD DOCS:

**A WordPress starter theme with support for SCSS, PostCSS, ES2015, BrowserSync and Gulp.**

**Note:** Using this theme requires you to have [Node](https://nodejs.org/) & [Composer](#) installed.

## Example Codes Folder

See the `example-codes`.

## Installation

**1st** Rename the theme's folder name to whatever suits your project is. _Side note:_ Update conflicts with themes from wordpress.org arise from themes having identical folder names. To avoid such conflicts simply make sure that your theme's folder name is unique (e.g. via a prefix).

**2nd** Replace all instances of the following strings with whatever suits your project.
- `primeraPhpNamespace`
- `primeraFunctionPrefix`
- `primeraTextDomain`
- `primeraCssPrefix`

**3rd** Open `scss/style.css` and adjust the [header comment section](https://developer.wordpress.org/themes/basics/main-stylesheet-style-css/). Open `gulpfile.js` and adjust the constants in the top of the document.

**4th** Open your terminal and `cd` into the theme's folder. There you run `sudo npm install` and enter you computers admin password to install all node modules. Now you can run any of the following gulp commands.

## Gulp Commands

GulpJS is a task runner. Below is a list of tasks you can run inside your terminal.

**`gulp css`**
- Processes SCSS, PostCSS
- Concatenates and minifies all `css` files into `./style.css`
- Runs once

**`gulp js`**
- Processes ES2015 via [BabelJS](//babeljs.io/)
- Concatenates and minifies all `js` files into `./script.js`
- Runs once

**`gulp watch`**
- Listens for changes within any `php`, `js` or `css` file
- Applies `gulp css` or `gulp js` as needed
- Will reload the browser to reflect the changes
- Will keep running until you hit `crtl+c` within the terminal

**`gulp imgmin`**
- Optimizes all images that are inside the `img` folder
- Runs once

**`gulp potfile`**
- Create a `.pot` file to be used for translations
- Please see the Translation section below for more information
- Runs once

**`gulp build`**
- Runs `gulp css`, `gulp js`, `gulp imgmin` and `gulp potfile`
- Runs once

**`gulp`**
- Runs `gulp watch`
- Runs once

## Folder Structure & Important Files

### build
### images
### includes
### javascript
### languages
### sass
### templates

## SCSS & PostCSS Plugins

[SASS](//sass-lang.com/) or [SCSS](//sass-lang.com/) is a CSS extension that supplies some [really cool features](//sass-lang.com/guide/) to CSS.

[PostCSS](//postcss.org) is a JavaScript framework which processes CSS files. Primera includes the following PostCSS plugins.
- [PropertyLookup](//github.com/simonsmith/postcss-property-lookup)
- [Easings](https://www.npmjs.com/package/postcss-easings)
- [MQPacker](https://www.npmjs.com/package/css-mqpacker)

## PHP Sessions

https://github.com/pantheon-systems/wp-native-php-sessions

## ES2015 Resources

- https://github.com/mbeaudru/modern-js-cheatsheet
- https://babeljs.io/learn-es2015/
- https://laracasts.com/series/es6-cliffsnotes
- https://hacks.mozilla.org/category/es6-in-depth/
- http://es6-features.org/

## Browser Support

While writing CSS you do not need to worry about writing browser prefixes. The autoprefixer PostCSS plugin supplied via CSSNext will do that for you. To see or change which browsers are supported you can simply change the `browserlist` inside `package.json` using [this guide](https://github.com/ai/browserslist).

Please also remember that [autoprefixer](https://autoprefixer.github.io/) can't help older browsers understand CSS properties which they simply do not support. For a great place to check which browser supports what visit [caniuse.com](http://caniuse.com/).

## Translation

1) While developing, wrap any hard coded translatable text strings in their [appropriate WP function](https://developer.wordpress.org/themes/functionality/internationalization/#localization-functions).
2) Revisit `gulpfile.js` and make sure the `domain` property inside `wpPot()` matches your theme's text domain.
3) Run `gulp potfile` to create a `.pot` file inside the languages folder.
4) To translate the `.pot` file and create the necessary `.po` and `.mo` files, you can use either [Poedit](https://poedit.net/) or [Loco Translate](https://wordpress.org/plugins/loco-translate/).

Please visit the following link to learn more about internationalization (i18n):
https://developer.wordpress.org/themes/functionality/internationalization/

## Versioning

To update the themes version simply bump the version number inside `scss/style.scss`.
