var CACHE_NAME = 'v0.1';
var urlsToCache = [
  '/',
  '/img/google-logo.png',
  '/img/bg-doro5.png'
];


self.addEventListener('install', function(event) {
  // Perform install steps
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then( function(cache) {
        console.log('Opened cache');
        return cache.addAll(urlsToCache);
      })
  );
});
