self.addEventListener('install', (e) => e.waitUntil(self.skipWaiting()));
self.addEventListener('activate', (e) => e.waitUntil(self.clients.claim()));

self.addEventListener('fetch', (event) => {
    const url = event.request.url;
    // IPTV linklerini ve portlarını (8080 vb.) yakala
    if (url.includes('.m3u8') || url.includes('.ts') || url.includes(':')) {
        event.respondWith(
            fetch(event.request, {
                mode: 'cors',
                referrerPolicy: 'no-referrer'
            }).then(response => {
                // Tarayıcıyı kandıran başlıklar
                const newHeaders = new Headers(response.headers);
                newHeaders.set('Access-Control-Allow-Origin', '*');
                newHeaders.set('Access-Control-Allow-Methods', 'GET, HEAD, OPTIONS');
                newHeaders.set('Access-Control-Allow-Headers', '*');

                return new Response(response.body, {
                    status: response.status,
                    statusText: response.statusText,
                    headers: newHeaders
                });
            }).catch(() => fetch(event.request))
        );
    }
});
