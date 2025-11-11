<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirigiendo…</title>
</head>
<body>
<p>Redirigiendo…</p>

<script>
    (function () {
        // Lee el parámetro ?to de la URL
        const params = new URLSearchParams(window.location.search);
        const target = params.get('to') || '/';

        // Mensaje que se enviará al padre (la tienda principal)
        const payload = { type: 'celumarket-auth-redirect', to: target };

        function fallbackRedirect() {
            window.location.assign(target);
        }

        try {
            // Si el iframe está embebido dentro de la misma ventana
            if (window.top && window.top !== window) {
                window.top.postMessage(payload, window.location.origin);
                setTimeout(fallbackRedirect, 600);
                return;
            }
        } catch (error) {
            // Si el acceso al top window falla, probamos con el parent
        }

        try {
            if (window.parent && window.parent !== window) {
                window.parent.postMessage(payload, window.location.origin);
                setTimeout(fallbackRedirect, 600);
                return;
            }
        } catch (error) {
            // Si tampoco se puede, hacemos redirect normal
        }

        fallbackRedirect();
    })();
</script>
</body>
</html>
