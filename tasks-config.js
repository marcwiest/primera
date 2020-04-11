pkg = require('./package.json')

module.exports = {

    name: pkg.name || 'primera',

    /**
    * The theme's text domain as specified in `style.css`.
    */
    textDomain: 'primeraTextDomain',

    /**
    * The current version of the project.
    *
    * This should match versions inside `CHANGELOG.md`, `package.json`, and `style.css`.
    */
    version: '1.0.0',

    /**
    * The files to be included for CLI command `$ npm run build`.
    */
    buildFiles: [
        'vendor',
        'source/views',
        'app',
        'config',
        'public',
        'templates',
        'languages',
        '.htaccess',
        'functions.php',
        'index.php',
        'index.php',
        'screenshot.png',
        'style.css',
        'LICENSE.md',
        'README.md',
        'CHANGELOG.md',
    ],

    /**
    * The files which will be scanned for translatable strings.
    *
    * See node-glob for instructions (https://github.com/isaacs/node-glob#glob-primer).
    */
    potFiles: [
        '**/*.php',
        '!vendor/**/*.php',
        '!dist/**/*.php',
    ],

    /**
    * The place where the zipped archives live.
    */
    archiveDirPath: 'dist/archive',

    /**
    * Where to place the build.
    */
    buildDirPath: `dist/${pkg.name || 'primera'}`,
}
