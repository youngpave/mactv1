self.addEventListener('install', (e) => e.waitUntil(self.skipWaiting()));
self.addEventListener('activate', (e) => e.waitUntil(self.clients.claim()));

self.addEventListener('fetch', (event) => {
    const url = event.request.url;
    
    // IPTV Linklerini ve parçalarını yakala
    if (url.includes(':8080') || url.includes('.m3u8') || url.includes('.ts')) {
        event.respondWith(
            fetch(event.request, {
                mode: 'no-cors', // Güvenlik engelini aşmak için 'no-cors' modunu zorla
                referrerPolicy: 'no-referrer',
                credentials: 'omit'
            }).then(response => {
                // Eğer veri geliyorsa ama tarayıcı 'blok' diyorsa, bot üzerinden zorla geçir
                if (response.type === 'opaque') {
                    return fetch(event.request); 
                }
                const newHeaders = new Headers(response.headers);
                newHeaders.set('Access-Control-Allow-Origin', '*');
                
                return new Response(response.body, {
                    status: response.status || 200,
                    statusText: response.statusText || 'OK',
                    headers: newHeaders
                });
            }).catch(() => fetch(event.request))
        );
    }
});
