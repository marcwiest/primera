
const fs = require('fs-extra'),
    rimraf = require('rimraf'),
    rl = require('readline').createInterface({
        input: process.stdin,
        output: process.stdout,
    }),
    config = require('../primera-config')

const makeTag = {

    init: function() {
        fs.ensureDirSync('tags')
        this.initQuestioning()
    },

    initQuestioning: function() {
        this.questionVersionNum()
    },

    questionVersionNum: function() {
        rl.question("What version number should the tag have? ", version => {

            this.version = version.trim()

            if (fs.existsSync(`tags/${this.version}`)) {
                this.questionExistingTagOverwrite()
            } else {
                this.makeTag()
            }
        })
    },

    questionExistingTagOverwrite: function() {
        rl.question("This version already exists! Do you wish to overwrite it? (y/n) ", answer => {

            if ('y' === answer.toLocaleLowerCase()) {
                rimraf.sync(`tags/${this.version}`)
                // TODO: Remove rimraf in favor of the below, starting with node version 12.10.
                // fs.rmdirSync('./languages/', {
                //     recursive: true,
                // });
                this.makeTag()
            } else {
                rl.close()
                console.log("The tag was not created.")
            }
        })
    },

    makeTag: function() {
        rl.close()

        const files = config.tagFiles.filter(fileName => {
                if (fileName === 'tags') return false
                return fs.existsSync(fileName)
            }),
            filesCount = files.length,
            destName = `tags/${this.version}`

        let mapIteration = 1

        fs.ensureDirSync(destName)

        files.map(fileName => {
            fs.copy(fileName, `${destName}/${fileName}`, err => {
                err && console.error(err)
                mapIteration === filesCount && console.log(`Tag "${this.version}" was successfully created.`)
                mapIteration++
            })
        })
    },
}

makeTag.init()
