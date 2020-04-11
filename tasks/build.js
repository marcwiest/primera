'use strict'

const fs = require('fs-extra'),
    rimraf = require('rimraf'),
    {buildFiles, buildDirPath, archiveDirPath} = require('../tasks-config'),
    files = buildFiles.filter(fileName => {
        if (fileName === buildDirPath || fileName === archiveDirPath) return false
        return fs.existsSync(fileName)
    }),
    filesCount = files.length

let buildPath = buildDirPath || 'dist/primera',
    archivePath = archiveDirPath || 'dist/archive'

fs.ensureDirSync(buildPath)
fs.ensureDirSync(archivePath)

if (! filesCount) {
    console.log('The file `primera-config.js` is missing the "buildFiles".')
    return
}

// Delete all files.
rimraf.sync(buildDirPath + '/*')

for (let i = 0; i < filesCount; i++) {
    fs.copySync(files[i], `${buildDirPath}/${files[i]}`)
}

console.log(`Build folder "${buildDirPath}" created.`)
