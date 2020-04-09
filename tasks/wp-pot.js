const wpPot = require('wp-pot')
// const replace = require('replace-in-file')

const textDomain = 'primeraTextDomain'

wpPot({
    destFile: 'languages/primera.pot',
    domain: textDomain,
    src: ['app/*.php', 'source/*.php'],
})
