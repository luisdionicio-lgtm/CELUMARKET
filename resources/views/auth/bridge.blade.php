<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirigiendo…</title>
</head>
<body>
<script>
    (function(){
        var to = {{ json_encode($to ?? '/') }};
        try {
            if (window.top) {
                window.top.location.assign(to);
            } else {
                window.location.href = to;
            }
        } catch (e) {
            window.location.href = to;
        }
    })();
 </script>
 Redirigiendo…
</body>
</html>

