<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover">
<meta name="theme-color" content="#0f4023">
<title>Masuk · Buku C Pertanahan · Desa Sidamulya</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
  *{-webkit-tap-highlight-color:transparent}
  html,body{height:100%}
  body{
    margin:0;min-height:100vh;
    padding:env(safe-area-inset-top) env(safe-area-inset-right) env(safe-area-inset-bottom) env(safe-area-inset-left);
    font-family:-apple-system,Segoe UI,Roboto,sans-serif;-webkit-font-smoothing:antialiased;
    overscroll-behavior-y:contain;
    background:
      radial-gradient(1200px 500px at 15% -10%, rgba(201,162,39,.18), transparent 60%),
      radial-gradient(900px 500px at 100% 110%, rgba(55,151,92,.35), transparent 60%),
      linear-gradient(160deg,#0a2b1a 0%,#0f4023 45%,#18602f 100%);
    display:flex;align-items:center;justify-content:center;
  }
  body::before{content:"";position:fixed;inset:0;pointer-events:none;opacity:.05;
    background-image:radial-gradient(#e9d27a 1px, transparent 1px);background-size:26px 26px}
  .wrap{width:100%;max-width:410px;padding:18px;animation:up .5s cubic-bezier(.22,1,.36,1)}
  @keyframes up{from{opacity:0;transform:translateY(18px) scale(.98)}to{opacity:1;transform:none}}
  .card-login{position:relative;border:1px solid rgba(201,162,39,.35);border-radius:26px;overflow:hidden;
    background:rgba(255,255,255,.96);box-shadow:0 30px 80px rgba(0,0,0,.45)}
  .card-head{background:linear-gradient(140deg,#0d3320,#18602f);color:#fff;text-align:center;padding:30px 20px 24px;position:relative;overflow:hidden}
  .card-head::after{content:"";position:absolute;left:0;right:0;bottom:0;height:6px;
    background:linear-gradient(90deg,#c9a227,#e6cf6a,#c9a227)}
  .logo{width:108px;height:108px;border-radius:50%;object-fit:cover;margin:0 auto 12px;display:block;
    box-shadow:0 10px 26px rgba(0,0,0,.35),0 0 0 3px rgba(201,162,39,.8)}
  .card-head h1{font-size:20px;font-weight:800;margin:0 0 2px;letter-spacing:.3px}
  .card-head p{margin:0;font-size:12px;opacity:.85}
  .card-body{padding:26px 22px;background:#fff}
  .form-label{font-weight:600;font-size:13px;color:#374151;margin-bottom:6px}
  .form-control{font-size:16px;min-height:52px;border:1.5px solid #dfe6df;border-left:0;border-radius:0 14px 14px 0;padding:12px 14px}
  .input-group-text{background:#f4f7f4;border:1.5px solid #dfe6df;border-right:0;border-radius:14px 0 0 14px;color:#6b7280}
  .form-control:focus{box-shadow:0 0 0 4px rgba(31,109,60,.12);border-color:#1f6d3c}
  .password-wrap{position:relative}
  .toggle{position:absolute;right:14px;top:50%;transform:translateY(-50%);border:0;background:none;font-size:19px;color:#6b7280;z-index:5}
  .btn-login{width:100%;min-height:54px;border-radius:14px;font-size:16px;font-weight:700;border:0;
    background:linear-gradient(135deg,#14532d,#1f6d3c);box-shadow:0 10px 22px rgba(20,83,45,.32);letter-spacing:.2px}
  .btn-login:active{transform:scale(.98)}
  .foot{color:#8a938a;font-size:12px}
</style>
</head>
<body>
  <div class="wrap">
    <div class="card card-login">
      <div class="card-head">
        <img class="logo" src="<?= BASE_URL ?>/assets/logo-desa-sidamulya.png" alt="Logo Desa Sidamulya" onerror="this.style.display='none'">
        <h1>Buku C Pertanahan</h1>
        <p>Desa Sidamulya · Kec. Wanasari · Kab. Brebes</p>
      </div>
      <div class="card-body">
        <?php if ($err = flash_get('error')): ?>
          <div class="alert alert-danger py-2 small mb-3"><?= e($err) ?></div>
        <?php endif; ?>
        <form method="post" action="<?= BASE_URL ?>/login" autocomplete="on">
          <?= csrf_field() ?>
          <div class="mb-3">
            <label class="form-label" for="u">Username</label>
            <div class="input-group">
              <span class="input-group-text">👤</span>
              <input id="u" name="username" class="form-control" required autocomplete="username" placeholder="Masukkan username">
            </div>
          </div>
          <div class="mb-4">
            <label class="form-label" for="p">Password</label>
            <div class="password-wrap input-group">
              <span class="input-group-text">🔒</span>
              <input id="p" name="password" type="password" class="form-control" required autocomplete="current-password" placeholder="••••••••">
              <button type="button" class="toggle" id="togglePass" aria-label="Lihat password">👁️</button>
            </div>
          </div>
          <button type="submit" class="btn btn-success btn-login">Masuk</button>
        </form>
        <p class="foot text-center mt-4 mb-0">Aplikasi internal pemerintahan desa</p>
      </div>
    </div>
  </div>
  <script>
    (function(){
      var b=document.getElementById('togglePass');
      if(b){b.addEventListener('click',function(){var i=document.getElementById('p'),s=i.type==='password';i.type=s?'text':'password';b.textContent=s?'🙈':'👁️';});}
      var u=document.getElementById('u'); if(u) u.focus();
    })();
  </script>
</body>
</html>
