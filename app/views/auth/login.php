<div class="login-wrap">
    <div class="login-card">
        <h1>📘 Buku C Pertanahan</h1>
        <p class="sub">Desa Sidamulya · Kec. Wanasari · Kab. Brebes</p>
        <form method="post" action="<?= BASE_URL ?>/login">
            <?= csrf_field() ?>
            <label>Username<input name="username" required autocomplete="username"></label>
            <label>Password<input name="password" type="password" required autocomplete="current-password"></label>
            <button type="submit" class="btn">Masuk</button>
        </form>
        <p class="hint">Default: admin / admin123</p>
    </div>
</div>
