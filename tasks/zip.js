'use strict'

const fs = require('fs-extra'),
    archiver = require('archiver')('zip'),
    spinner = require('ora')(),
    {execSync} = require('child_process'),
    {name, version, buildDirPath, archiveDirPath} = require('../tasks-config'),
    rl = require('readline').createInterface({
        input: process.stdin,
        output: process.stdout,
    })

const questionSync = q => {
    return new Promise(resolve => rl.question(q, a => resolve(a)))
}

let buildPath = buildDirPath || 'dist/primera',
    archivePath = archiveDirPath || 'dist/archive',
    zipFilePath = `${archivePath}/${name}-${version}.zip`,
    answer = '',
    output

if (fs.existsSync(zipFilePath)) {
    // Await can only be used inside an async function.
    (async () => {
        console.info(`\r\nAn archive with the version "${version}" already exists. To change the version number, please see \`primera-config.js\`. \r\n`)
        answer = await questionSync(`Do you wish to replace the archive? (y/n)`)
        if (answer !== 'y') {
            console.info("The archive was not replaced.")
            rl.close()
            return
        }
    })()
}

if (! fs.existsSync(buildPath)) {
    console.info("The files are being prepared.")
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
