<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirigiendo…</title>
</head>
<body>
<script>
    (function () {
        var target = {{ json_encode($to ?? '/') }} || '/';
        var payload = { type: 'celumarket-auth-redirect', to: target };

        function fallbackRedirect() {
            window.location.assign(target);
        }

        try {
            if (window.top && window.top !== window) {
                window.top.location.assign(target);
                return;
            }
        } catch (error) {
            // Si no podemos controlar la ventana superior, seguimos con postMessage.
        }

        if (window.parent && window.parent !== window) {
            try {
                window.parent.postMessage(payload, '*');
                setTimeout(fallbackRedirect, 800);
                return;
            } catch (error) {
                // No se pudo enviar el mensaje, aplicamos la redirección local.
            }
        }

        fallbackRedirect();
    })();
</script>
<p>Redirigiendo…</p>
</body>
</html>
