self.addEventListener('fetch', (event) => {
    const url = event.request.url;
    if (url.includes('.m3u8') || url.includes('.ts') || url.includes(':8080')) {
        event.respondWith(
            fetch(event.request, {
                mode: 'cors',
                credentials: 'omit',
                referrerPolicy: 'no-referrer',
                headers: {
                    'User-Agent': navigator.userAgent // Tarayıcı kimliğini gönder
                }
            }).then(response => {
                const newHeaders = new Headers(response.headers);
                newHeaders.set('Access-Control-Allow-Origin', '*');
                newHeaders.set('Access-Control-Allow-Methods', 'GET, HEAD, OPTIONS');
                newHeaders.set('Access-Control-Allow-Headers', '*');

                return new Response(response.body, {
                    status: response.status,
                    statusText: response.statusText,
                    headers: newHeaders
                });
            })
        );
    }
});
