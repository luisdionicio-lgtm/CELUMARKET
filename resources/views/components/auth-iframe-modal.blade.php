<!-- Modal de autenticación en iframe -->
<div id="authIframeOverlay" class="fixed inset-0 hidden items-start justify-center bg-black/60 p-4 md:p-12 z-50" aria-hidden="true">
    <div class="relative w-full max-w-2xl rounded-2xl border border-slate-200 bg-white shadow-2xl" role="dialog" aria-modal="true" aria-labelledby="authIframeTitle">
        <header class="px-5 pt-5 text-slate-700">
            <h3 id="authIframeTitle" class="text-lg font-semibold">Accede a tu cuenta</h3>
            <p class="mb-3 -mt-1 text-sm text-slate-500">Inicia sesión o regístrate para disfrutar todas las funciones de CELU MARKET</p>
        </header>

        <div class="px-5 pb-6">
            <iframe id="auth-iframe" src="about:blank" class="h-[72vh] w-full rounded-xl border border-slate-200 md:h-[80vh]" referrerpolicy="no-referrer" loading="lazy"></iframe>
        </div>

        <button id="close-auth-iframe" class="absolute right-3 top-3 text-xl text-slate-400 transition hover:text-slate-600" aria-label="Cerrar">×</button>
    </div>
</div>

<script>
    (function () {
        const overlay = document.getElementById('authIframeOverlay');
        const openBtn = document.getElementById('open-auth-modal');
        const closeBtn = document.getElementById('close-auth-iframe');
        const iframe = document.getElementById('auth-iframe');

        const loginUrl = "{{ route('auth.embed.login', absolute: false) }}";
        const registerUrl = "{{ route('auth.embed.register', absolute: false) }}";
        const bridgePath = "{{ route('auth.bridge', absolute: false) }}";

        function setSrc(which) {
            if (!iframe) return;
            const current = window.location.pathname + window.location.search + window.location.hash;
            const qp = '?redirect=' + encodeURIComponent(current);
            iframe.src = (which === 'register' ? registerUrl : loginUrl) + qp;
        }

        function open(which = 'login') {
            setSrc(which);
            overlay?.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function close() {
            overlay?.classList.add('hidden');
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
            window.location.assign(sanitizeDestination(destination));
        }

        if (openBtn) {
            openBtn.addEventListener('click', (event) => {
                event.preventDefault();
                open('login');
            });
        }

        document.querySelectorAll('.btn-open-auth-modal').forEach((btn) => {
            btn.addEventListener('click', (event) => {
                event.preventDefault();
                event.stopImmediatePropagation();
                open('login');
            });
        });

        closeBtn?.addEventListener('click', close);
        overlay?.addEventListener('click', (event) => {
            if (event.target === overlay) close();
        });

        window.addEventListener('message', (event) => {
            const data = event.data || {};
            if (data.type !== 'celumarket-auth-redirect') {
                return;
            }
            close();
            redirectTo(data.to);
        });

        iframe?.addEventListener('load', () => {
            try {
                const frameWindow = iframe.contentWindow;
                if (!frameWindow || !frameWindow.location || !bridgePath) return;

                const normalizedPath = bridgePath.startsWith('/') ? bridgePath : '/' + bridgePath;
                if (!frameWindow.location.pathname.endsWith(normalizedPath)) return;

                const params = new URLSearchParams(frameWindow.location.search || '');
                const target = params.get('to') || frameWindow.location.hash || window.location.pathname;
                close();
                redirectTo(target);
            } catch (error) {
                // Si no se puede acceder (p. ej. orígenes distintos), dependemos del postMessage.
            }
        });

        if (location.hash === '#register') {
            open('register');
        }
    })();
</script>
