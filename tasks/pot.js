'use strict'

const fs = require('fs-extra'),
    wpPot = require('wp-pot'),
    {textDomain, potFiles} = require('../primera-config')

let domain = textDomain || 'primera',
    destFile = `languages/${domain}.pot`

fs.ensureDirSync('languages')

wpPot({
    destFile: destFile,
    domain: domain,
    src: potFiles,
})

console.log(`WP pot file "${destFile}" created.`)
