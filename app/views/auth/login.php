<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="theme-color" content="#14532d">
<title>Masuk · Buku C Pertanahan</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
  body{
    min-height:100vh;
    background:linear-gradient(135deg,#14532d 0%,#1f6d3c 55%,#2f8f54 100%);
    display:flex;align-items:center;justify-content:center;padding:20px;
    padding-bottom:calc(20px + env(safe-area-inset-bottom));
    font-family:-apple-system,Segoe UI,Roboto,sans-serif;
  }
  .card-login{max-width:400px;width:100%;border:0;border-radius:20px;overflow:hidden;
    box-shadow:0 18px 50px rgba(0,0,0,.28)}
  .card-head{background:linear-gradient(135deg,#0f4023,#1f6d3c);color:#fff;padding:30px 24px;text-align:center}
  .card-head .icon{font-size:44px;line-height:1}
  .card-head h4{margin:10px 0 2px;font-weight:700}
  .card-head p{margin:0;font-size:13px;opacity:.85}
  .card-body{padding:28px 24px}
  .form-label{font-weight:600;font-size:13px;color:#374151}
  .form-control{min-height:50px;font-size:16px;border-radius:12px;border-color:#dfe6df}
  .form-control:focus{box-shadow:0 0 0 .2rem rgba(20,83,45,.12);border-color:#1f6d3c}
  .btn-login{min-height:50px;font-size:16px;font-weight:700;border-radius:12px;
    background:linear-gradient(135deg,#14532d,#1f6d3c);border:0}
  .btn-login:active{transform:scale(.98)}
</style>
</head>
<body>
  <div class="card card-login">
    <div class="card-head">
      <div class="icon">📘</div>
      <h4>Buku C Pertanahan</h4>
      <p>Desa Sidamulya · Kec. Wanasari · Kab. Brebes</p>
    </div>
    <div class="card-body">
      <?php if ($err = flash_get('error')): ?>
        <div class="alert alert-danger py-2 small"><?= e($err) ?></div>
      <?php endif; ?>
      <form method="post" action="<?= BASE_URL ?>/login" autocomplete="on">
        <?= csrf_field() ?>
        <div class="mb-3">
          <label class="form-label" for="u">Username</label>
          <input id="u" name="username" class="form-control" required autocomplete="username" placeholder="Masukkan username">
        </div>
        <div class="mb-4">
          <label class="form-label" for="p">Password</label>
          <input id="p" name="password" type="password" class="form-control" required autocomplete="current-password" placeholder="••••••••">
        </div>
        <button type="submit" class="btn btn-success btn-login w-100">Masuk</button>
      </form>
      <p class="text-center text-muted small mt-3 mb-0">Default: admin / admin123</p>
    </div>
  </div>
  <script>
    (function(){
      // fokus otomatis pada kolom kosong pertama + hindari zoom berlebih di HP
      var u=document.getElementById('u'); if(u) u.focus();
    })();
  </script>
</body>
</html>
