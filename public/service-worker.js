const CACHE_NAME = 'msa-intranet-v1';

const URLS_TO_CACHE = [
    '/',
    '/manifest.json',
    '/icon-192.png',
    '/icon-512.png',
    // Можно добавить сюда что-то ещё (CSS/JS), но Vite хеширует имена файлов,
    // так что лучше оставить так для начала.
];

self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME).then(cache => {
            return cache.addAll(URLS_TO_CACHE).catch(() => {});
        })
    );
});

self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(keys => {
            return Promise.all(
                keys
                    .filter(key => key !== CACHE_NAME)
                    .map(key => caches.delete(key))
            );
        })
    );
});

self.addEventListener('fetch', event => {
    const request = event.request;

    // Только GET запросы
    if (request.method !== 'GET') {
        return;
    }

    event.respondWith(
        caches.match(request).then(response => {
            return response || fetch(request).catch(() => {
                // Можно вернуть кастомную offline-страницу, если захочешь
                return caches.match('/');
            });
        })
    );
});
