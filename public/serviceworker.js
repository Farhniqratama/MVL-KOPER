const CACHE_NAME = 'my-app-cache-v1';
const urlsToCache = [
    '/',
    '/parfume/assets/css/bootstrap.min.css',
    '/parfume/assets/vendor/fontawesome-free/css/all.min.css',
    '/parfume/assets/css/demo6.min.css',
    '/parfume/assets/css/animate.min.css',
    '/parfume/assets/vendor/fontawesome-free/css/all.min.css',
    '/parfume/assets/js/jquery.min.js',
    '/parfume/assets/js/bootstrap.bundle.min.js',
    '/parfume/assets/js/plugins.min.js',
    '/parfume/assets/js/jquery.appear.min.js',
    '/parfume/assets/js/main.min.js',
    '/parfume/assets/images/icons/favicon.png'
];

self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return cache.addAll(urlsToCache);
        })
    );
});

self.addEventListener('fetch', (event) => {
    event.respondWith(
        caches.match(event.request).then((response) => {
            return response || fetch(event.request);
        })
    );
});
