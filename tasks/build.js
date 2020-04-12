'use strict'

const fs = require('fs-extra'),
    rimraf = require('rimraf'),
    dotenv = require('dotenv').config(),
    replace = require('replace-in-file')

if (dotenv.error) {
    throw dotenv.error
}

const env = dotenv.parsed,
    name = env.THEME_SLUG || 'primera',
    version = env.VERSION || 0,
    buildPath = env.BUILD_DIR_PATH || 'dist/primera',
    archivePath = env.ARCHIVE_DIR_PATH || 'dist/archive'

let files
if (env.BUILD_FILES && env.BUILD_FILES.indexOf(',')) {
    files = env.BUILD_FILES.trim().split(',')
    files.length && (
        files = files.map(fileName => fileName.trim())
    )
}

let filesCount = files.length

if (! filesCount) {
    console.log('Your `.env` file is missing "BUILD_FILES".')
    return
}

fs.ensureDirSync(buildPath)
fs.ensureDirSync(archivePath)

// Delete all existing build files.
rimraf.sync(buildPath + '/*')

// Copy files to build folder.
for (let i = 0; i < filesCount; i++) {

    if (fs.existsSync(files[i])) {
        // let options = {
        //     files: files[i],
        //     from: [/\%\%td\%\%/gi, /\%\%v\%\%/gi],
        //     to: [name, version],
        // }
        // replace(options, (error, results) => {
        //     error && console.error(error)
        //     fs.copySync(files[i], `${buildPath}/${files[i]}`)
        // })
        fs.copySync(files[i], `${buildPath}/${files[i]}`)
    }
}

console.log(`Build folder "${buildPath}" created.`)
