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

        const loginUrl = "{{ route('auth.embed.login') }}";
        const registerUrl = "{{ route('auth.embed.register') }}";

        function setSrc(which){
            const current = window.location.pathname + window.location.search + window.location.hash;
            const qp = '?redirect=' + encodeURIComponent(current);
            iframe.src = (which === 'register' ? registerUrl : loginUrl) + qp;
        }

        function open(which='login'){
            setSrc(which);
            overlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        function close(){
            overlay.classList.add('hidden');
            document.body.style.overflow = '';
        }

        openBtn?.addEventListener('click', function(e){ e.preventDefault(); open('login'); });
        // Soporte para botones existentes de otras vistas (e.g., .btn-open-auth-modal)
        document.querySelectorAll('.btn-open-auth-modal').forEach(function(btn){
            btn.addEventListener('click', function(e){
                e.preventDefault();
                e.stopImmediatePropagation();
                open('login');
            });
        });
        closeBtn?.addEventListener('click', close);
        overlay.addEventListener('click', (e)=>{ if(e.target===overlay) close(); });
        // Si llega con hash #register abrir directamente esa vista
        if (location.hash === '#register') { open('register'); }
    })();
</script>
