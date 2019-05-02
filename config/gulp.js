export const theme = {
    "textdomain" : "primera",
    "productionUrl" : "",
    "stagingUrl" : "",
    "dev" : {
        "css" : {
            "files" : [
                "./resources/sass/app.scss",
                "./resources/sass/components/**/*.scss",
                "./resources/sass/views/**/*.scss"
            ]
        },
        "js" : {
            "files" : [
                "./resources/javascript/vendors/fitvids.js",
                "./resources/javascript/util.js",
                "./resources/javascript/app.js"
            ]
        },
        "browserSync" : {
            "proxy"  : "local.primera.com",
            "notify" : false,
            "tunnel" : false,
            "files"  : [
                "./templates/**/*.twig",
                "./public/css/**/*.css",
                "./public/js/**/*.js",
                "./public/img/**/*",
                "./**/*.php"
            ]
        }
    }
};
