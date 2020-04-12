'use strict'

const fs = require('fs-extra'),
    wpPot = require('wp-pot'),
    dotenv = require('dotenv').config(),
    split = require('split-string')

if (dotenv.error) {
    throw dotenv.error
}

const env = dotenv.parsed,
    domain = env.TEXT_DOMAIN || 'primera',
    destFile = `languages/${domain}.pot`

let potFiles;
if (env.POT_FILES && env.POT_FILES.indexOf(',')) {
    potFiles = env.POT_FILES.trim().split(',')
    potFiles.length && (
        potFiles = potFiles.map(fileName => fileName.trim())
    )
}

if (! potFiles) {
    console.error(`No WP pot files found. Please make sure your .env file has "POT_FILES" listed.`)
    return
}

fs.ensureDirSync('languages')

wpPot({
    destFile: destFile,
    domain: domain,
    src: potFiles,
})

console.log(`WP pot file "${destFile}" created.`)

