'use strict'

const fs = require('fs-extra'),
    archiver = require('archiver')('zip'),
    spinner = require('ora')(),
    {execSync} = require('child_process'),
    dotenv = require('dotenv').config(),
    rl = require('readline').createInterface({
        input: process.stdin,
        output: process.stdout,
    })

if (dotenv.error) {
    throw dotenv.error
}

const env = dotenv.parsed,
    questionSync = q => {
        return new Promise(resolve => rl.question(q, a => resolve(a)))
    }

let buildPath = env.BUILD_DIR_PATH || 'dist/primera',
    archivePath = env.ARCHIVE_DIR_PATH || 'dist/archive',
    name = env.THEME_SLUG || 'primera',
    version = env.VERSION || 0,
    zipFilePath = `${archivePath}/${name}-${version}.zip`,
    answer = '',
    output

(async () => {

    if (fs.existsSync(zipFilePath)) {
        console.info(`\r\nAn archive with the version "${version}" already exists. To change the version number, please see \`primera-config.js\`. \r\n`)
        answer = await questionSync(`Do you wish to replace the archive? (y/n) `)
        if (answer !== 'y') {
            console.info("The archive was not replaced.")
            rl.close()
            return
        }
    }

    if (! fs.existsSync(buildPath)) {
        console.info("Just a second, your files are being prepared.")
        execSync("npm run production && npm run pot && node ./tasks/build")
    }

    output = fs.createWriteStream(zipFilePath)
        .on('pipe', () => {
            spinner.text = 'Please wait while the build is being zipped.'
            spinner.start()
        })
        .on('close', () => {
            spinner.stop()
            console.log(`Zip file "${zipFilePath}" created.`)
        })

    archiver.on('error', err => console.error(err))
    archiver.pipe(output)
    archiver.directory(buildPath, name)
    archiver.finalize()

    rl.close()

})()
