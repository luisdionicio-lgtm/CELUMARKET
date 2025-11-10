<!-- Modal de Autenticación (iframe) -->
<div id="authIframeOverlay" class="fixed inset-0 bg-black/60 hidden items-start justify-center p-4 md:p-12 z-50" aria-hidden="true">
    <div class="w-full max-w-2xl bg-white rounded-2xl border border-slate-200 shadow-2xl relative" role="dialog" aria-modal="true" aria-labelledby="authIframeTitle">
        <header class="text-slate-700 px-5 pt-5">
            <h3 id="authIframeTitle" class="text-lg font-semibold">Accede a tu cuenta</h3>
            <p class="text-sm text-slate-500 -mt-1 mb-3">Inicia sesión o regístrate para acceder a todas las funcionalidades de CELU MARKET</p>
        </header>

        <!-- Iframe content -->
        <div class="px-5 pb-6">
            <iframe id="auth-iframe" src="about:blank" class="w-full h-[72vh] md:h-[80vh] rounded-xl border border-slate-200" referrerpolicy="no-referrer" loading="lazy"></iframe>
        </div>

        <button id="close-auth-iframe" class="absolute right-3 top-3 text-slate-400 hover:text-slate-600 text-xl" aria-label="Cerrar">✕</button>
    </div>
</div>

<script>
    (function(){
        const overlay = document.getElementById('authIframeOverlay');
        const openBtn = document.getElementById('open-auth-modal');
        const closeBtn = document.getElementById('close-auth-iframe');
        const iframe = document.getElementById('auth-iframe');

        const loginUrl = "{{ route('auth.embed.login', absolute: false) }}";
        const registerUrl = "{{ route('auth.embed.register', absolute: false) }}";
        const bridgePath = "{{ route('auth.bridge', absolute: false) }}";

        function setSrc(which){
            if (!iframe) {
                return;
            }
            const current = window.location.pathname + window.location.search + window.location.hash;
            const qp = '?redirect=' + encodeURIComponent(current);
            iframe.src = (which === 'register' ? registerUrl : loginUrl) + qp;
        }

        function open(which='login'){
            setSrc(which);
            if (overlay) {
                overlay.classList.remove('hidden');
            }
            document.body.style.overflow = 'hidden';
        }
        function close(){
            if (overlay) {
                overlay.classList.add('hidden');
            }
            document.body.style.overflow = '';
            if (iframe) {
                iframe.src = 'about:blank';
            }
        }

        function sanitizeDestination(value) {
            if (typeof value !== 'string' || value.length === 0) {
                return window.location.pathname;
            }
            if (value.startsWith('http://') || value.startsWith('https://')) {
                try {
                    const url = new URL(value);
                    if (url.origin === window.location.origin) {
                        return url.pathname + url.search + url.hash;
                    }
                } catch (error) {
                    return window.location.pathname;
                }
                return window.location.pathname;
            }

            if (value.startsWith('/')) {
                return value;
            }

            return '/' + value.replace(/^\/+/, '');
        }

        function redirectTo(destination) {
            const target = sanitizeDestination(destination);
            window.location.assign(target);
        }

        if (openBtn) {
            openBtn.addEventListener('click', function(e){
                e.preventDefault();
                open('login');
            });
        }
        // Soporte para botones existentes de otras vistas (e.g., .btn-open-auth-modal)
        const modalTriggers = document.querySelectorAll('.btn-open-auth-modal');
        modalTriggers.forEach(function(btn){
            btn.addEventListener('click', function(e){
                e.preventDefault();
                e.stopImmediatePropagation();
                open('login');
            });
        });
        if (closeBtn) {
            closeBtn.addEventListener('click', close);
        }
        if (overlay) {
            overlay.addEventListener('click', function(e){
                if (e.target === overlay) {
                    close();
                }
            });
        }

        window.addEventListener('message', function(event){
            const data = event.data || {};
            if (data.type !== 'celumarket-auth-redirect') {
                return;
            }

            close();
            redirectTo(data.to);
        });

        if (iframe) {
            iframe.addEventListener('load', function(){
                try {
                    const frameWindow = iframe.contentWindow;
                    if (!frameWindow || !frameWindow.location) {
                        return;
                    }
                    const path = frameWindow.location.pathname || '';
                    if (!bridgePath) {
                        return;
                    }
                    const normalizedPath = bridgePath.startsWith('/')
                        ? bridgePath
                        : '/' + bridgePath;

                    if (!path.endsWith(normalizedPath)) {
                        return;
                    }

                    const params = new URLSearchParams(frameWindow.location.search || '');
                    const target = params.get('to') || frameWindow.location.hash || window.location.pathname;
                    close();
                    redirectTo(target);
                } catch (error) {
                    // No se puede inspeccionar (p.ej., por orígenes distintos); dependeremos del postMessage.
                }
            });
        }

        // Si llega con hash #register abrir directamente esa vista
        if (location.hash === '#register') { open('register'); }
    })();
</script>
