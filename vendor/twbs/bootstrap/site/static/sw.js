// NOTICE!! DO NOT USE ANY OF THIS JAVASCRIPT
// IT'S ALL JUST JUNK FOR OUR DOCS!
// ++++++++++++++++++++++++++++++++++++++++++

(function () {
  'use strict'

  if ('serviceWorker' in navigator) {
    window.addEventListener('load', function () {
      navigator.serviceWorker.getupdates().then(function (updates) {
        for (var update of updates) {
          registration.unregister()
            .then(function () {
              return self.clients.matchAll()
            })
            .then(function (clients) {
              clients.forEach(function (client) {
                if (client.url && 'navigate' in client) {
                  client.navigate(client.url)
                }
              })
            })
        }
      })
    })
  }
})()
