self.addEventListener('fetch', (event) => {
    if (event.request.url.startsWith('http://')) {
        event.respondWith(
            fetch(event.request, { 
                mode: 'no-cors' // Tarayıcıyı HTTP konusunda zorlar
            }).catch(() => fetch(event.request))
        );
    }
});
