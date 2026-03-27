self.addEventListener('install', () => self.skipWaiting());
self.addEventListener('activate', () => self.clients.claim());

self.addEventListener('fetch', (event) => {
    const url = event.request.url;

    // Sadece m3u8, ts ve port içeren IPTV isteklerini havada yakala
    if (url.includes('.m3u8') || url.includes('.ts') || url.includes(':8080')) {
        event.respondWith(
            fetch(event.request, {
                mode: 'cors',
                credentials: 'omit',
                referrerPolicy: 'no-referrer' // Referer engelini burada kırıyoruz
            }).then(response => {
                const newHeaders = new Headers(response.headers);
                // Tarayıcıyı "bu güvenli" diye kandıran başlıklar
                newHeaders.set('Access-Control-Allow-Origin', '*');
                newHeaders.set('Access-Control-Allow-Methods', 'GET, HEAD, OPTIONS');
                newHeaders.set('Access-Control-Allow-Headers', '*');

                return new Response(response.body, {
                    status: response.status,
                    statusText: response.statusText,
                    headers: newHeaders
                });
            }).catch(err => {
                return fetch(event.request);
            })
        );
    }
});
