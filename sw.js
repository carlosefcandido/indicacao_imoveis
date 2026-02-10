const CACHE_NAME = 'acir-indicacoes-v1';
const urlsToCache = [
  './',
  './index.php',
  './css/style.css',
  './imagens/favicon.png'
];

self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => cache.addAll(urlsToCache))
  );
});

self.addEventListener('fetch', event => {
  event.respondWith(
    caches.match(event.request)
      .then(response => response || fetch(event.request))
  );
});