
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
        rl.question("This version already exists! Do you wish to overwrite it? (yes/no) ", answer => {

            if ('yes' === answer.toLocaleLowerCase()) {
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

        const destName = `tags/${this.version}`,
            callback = err => {
                if (err) return console.error(err)
            }

        fs.mkdirSync(destName)

        config.tagFiles
            .filter(fileName => fs.existsSync(fileName))
            .map(fileName => {
                fs.copy(fileName, `${destName}/${fileName}`, err => err && console.error(err))
            })

        console.log('Tag was successfully created.')
    },
}

makeTag.init()
