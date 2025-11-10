<style>
    /* --- MODAL DE AUTENTICACIÓN (complemento Tailwind) --- */
    .auth-modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,.55); display: none; align-items: flex-start; justify-content: center; padding: 3rem 1rem; z-index: 1100; }
    .auth-modal-overlay.open { display: flex; }
    .auth-tabs { display: grid; grid-template-columns: 1fr 1fr; gap: .5rem; padding: .5rem; margin: 1rem; background: #f3f6fb; border-radius: 999px; }
    .auth-tab { padding: .6rem .75rem; text-align: center; border-radius: 999px; font-weight: 600; color: #334155; background: transparent; border: none; cursor: pointer; }
    .auth-tab.active { background: #fff; box-shadow: 0 1px 2px rgba(0,0,0,.06); }
    .auth-content { padding: 0 1.25rem 1.25rem; }
    .auth-card { border: 1px solid #eef0f4; border-radius: 12px; padding: 1rem; margin-bottom: 1rem; }
    .auth-form h3 { margin: .25rem 0 .35rem; color: #111827; }
    .auth-form p { color: #6b7280; margin-bottom: 1rem; }
    .auth-form label { display: block; font-size: .9rem; color: #374151; margin-bottom: .35rem; }
    .auth-input { width: 100%; background: #f8fafc; border: 1px solid #e5e7eb; padding: .7rem .9rem; border-radius: 10px; outline: none; }
    .auth-input:focus { border-color: #94a3b8; box-shadow: 0 0 0 3px rgba(59,130,246,.15); }
    .btn-auth-primary { display: inline-block; width: 100%; background: #1a233a; color: #fff; padding: .8rem 1rem; border-radius: 10px; font-weight: 700; border: none; cursor: pointer; }
    .btn-auth-primary:hover { background: #233255; }
    .auth-footer-title { font-size: .75rem; letter-spacing: .08em; color: #9ca3af; text-align: center; margin: .75rem 0; }
    .demo-card { display: flex; gap: .75rem; align-items: start; padding: .85rem; border: 1px solid #eef0f4; border-radius: 12px; }
    .demo-card + .demo-card { margin-top: .65rem; }
    .demo-icon { width: 36px; height: 36px; display: grid; place-items: center; border-radius: 8px; background: #f3f4f6; color: #334155; }
    .badge { font-size: .7rem; color: #fff; background: #ef4444; padding: .15rem .45rem; border-radius: 999px; margin-left: .5rem; }
    .auth-close { position: absolute; right: .75rem; top: .75rem; background: transparent; border: none; font-size: 1.1rem; cursor: pointer; color: #6b7280; }
</style>

<!-- Componente de modal de autenticación -->
<div id="authModalOverlay" class="auth-modal-overlay" aria-hidden="true">
    <div class="auth-modal w-full max-w-2xl bg-white rounded-2xl border border-slate-200 shadow-2xl relative" role="dialog" aria-modal="true" aria-labelledby="authModalTitle">
        <header class="text-slate-500 text-sm border-b border-slate-100 px-5 py-4">
            Inicia sesión o regístrate para acceder a todas las funcionalidades de CELU MARKET
            <button class="auth-close" id="close-auth-modal" aria-label="Cerrar">×</button>
        </header>

        <div class="auth-tabs" role="tablist">
            <button class="auth-tab active" id="tab-login" role="tab" aria-selected="true">Iniciar sesión</button>
            <button class="auth-tab" id="tab-register" role="tab" aria-selected="false">Registrarse</button>
        </div>

        <div class="auth-content">
            <!-- INICIO DE SESIÓN -->
            <div id="panel-login" class="auth-panel" role="tabpanel" aria-labelledby="tab-login">
                <div class="auth-card auth-form">
                    <h3 class="text-lg font-semibold">Iniciar sesión</h3>
                    <p class="text-slate-500">Ingresa tus credenciales para acceder a tu cuenta</p>
                    <form method="POST" action="{{ route('login') }}" class="space-y-3">
                        @csrf
                        <label for="login_email">Correo electrónico</label>
                        <input id="login_email" class="auth-input" type="email" name="email" placeholder="tu@email.com" required autocomplete="username">
                        <div style="height:.65rem"></div>
                        <label for="login_password">Contraseña</label>
                        <input id="login_password" class="auth-input" type="password" name="password" placeholder="••••••••" required autocomplete="current-password">
                        <div style="height:1rem"></div>
                        <button type="submit" class="btn-auth-primary">Iniciar sesión</button>
                    </form>
                </div>

                <div class="auth-footer-title">CUENTAS DE PRUEBA</div>
                <div class="demo-card">
                    <div class="demo-icon"><i class="fa-solid fa-crown"></i></div>
                    <div>
                        <strong>Administrador</strong> <span class="badge">Administrador</span><br>
                        <small>admin@celumarket.com</small><br>
                        <small style="color:#6b7280">Acceso completo al panel</small>
                    </div>
                </div>
                <div class="demo-card">
                    <div class="demo-icon"><i class="fa-solid fa-user"></i></div>
                    <div>
                        <strong>Cliente Demo</strong><br>
                        <small>cliente@demo.com</small><br>
                        <small style="color:#6b7280">Cuenta de cliente estándar</small>
                    </div>
                </div>
                <div class="demo-card">
                    <div class="demo-icon"><i class="fa-solid fa-id-badge"></i></div>
                    <div>
                        <strong>Juan Pérez</strong><br>
                        <small>juan@gmail.com</small><br>
                        <small style="color:#6b7280">Usuario de ejemplo</small>
                    </div>
                </div>
            </div>

            <!-- REGISTRO -->
            <div id="panel-register" class="auth-panel" role="tabpanel" aria-labelledby="tab-register" style="display:none;">
                <div class="auth-card auth-form">
                    <h3 class="text-lg font-semibold">Crear cuenta</h3>
                    <p class="text-slate-500">Regístrate para comprar y gestionar tus pedidos</p>
                    <form method="POST" action="{{ route('register') }}" class="space-y-3">
                        @csrf
                        <label for="reg_name">Nombre</label>
                        <input id="reg_name" class="auth-input" type="text" name="name" placeholder="Tu nombre" required autocomplete="name">
                        <div style="height:.65rem"></div>
                        <label for="reg_email">Correo electrónico</label>
                        <input id="reg_email" class="auth-input" type="email" name="email" placeholder="tu@email.com" required autocomplete="email">
                        <div style="height:.65rem"></div>
                        <label for="reg_password">Contraseña</label>
                        <input id="reg_password" class="auth-input" type="password" name="password" required autocomplete="new-password">
                        <div style="height:.65rem"></div>
                        <label for="reg_password_confirmation">Confirmar contraseña</label>
                        <input id="reg_password_confirmation" class="auth-input" type="password" name="password_confirmation" required autocomplete="new-password">
                        <div style="height:1rem"></div>
                        <button type="submit" class="btn-auth-primary">Registrarse</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (function(){
        const overlay = document.getElementById('authModalOverlay');
        const openBtn = document.getElementById('open-auth-modal');
        const closeBtn = document.getElementById('close-auth-modal');
        const tabLogin = document.getElementById('tab-login');
        const tabRegister = document.getElementById('tab-register');
        const panelLogin = document.getElementById('panel-login');
        const panelRegister = document.getElementById('panel-register');

        function open(){ overlay.classList.add('open'); document.body.style.overflow='hidden'; }
        function close(){ overlay.classList.remove('open'); document.body.style.overflow=''; }
        function showLogin(){ tabLogin.classList.add('active'); tabRegister.classList.remove('active'); panelLogin.style.display='block'; panelRegister.style.display='none'; }
        function showRegister(){ tabRegister.classList.add('active'); tabLogin.classList.remove('active'); panelRegister.style.display='block'; panelLogin.style.display='none'; }

        openBtn?.addEventListener('click', (e)=>{ e.preventDefault(); open(); showLogin(); });
        closeBtn?.addEventListener('click', close);
        overlay.addEventListener('click', (e)=>{ if(e.target===overlay) close(); });
        tabLogin.addEventListener('click', showLogin);
        tabRegister.addEventListener('click', showRegister);

        if (location.hash === '#register') { open(); showRegister(); }
    })();
</script>
