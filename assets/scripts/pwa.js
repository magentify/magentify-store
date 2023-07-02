import {Xt} from 'xtendui'

Xt.mount({
    matches: 'body',
    mount: () => {
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/service-worker.js')
        }
    },
})
