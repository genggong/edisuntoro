<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="theme-color" content="#14532d">
<title>Masuk · Buku C Pertanahan</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
  body{min-height:100vh;background:linear-gradient(135deg,#14532d 0%,#1f6d3c 55%,#2f8f54 100%);display:flex;align-items:center;justify-content:center;padding:20px}
  .card-login{max-width:400px;width:100%;border:0;border-radius:18px;overflow:hidden;box-shadow:0 18px 50px rgba(0,0,0,.28)}
  .card-head{background:linear-gradient(135deg,#14532d,#1f6d3c);color:#fff;padding:26px 24px;text-align:center}
  .card-head .icon{font-size:40px}
  .card-head h4{margin:8px 0 2px;font-weight:700}
  .card-head p{margin:0;font-size:13px;opacity:.85}
  .card-body{padding:26px 24px}
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
      <form method="post" action="<?= BASE_URL ?>/login">
        <?= csrf_field() ?>
        <div class="mb-3">
          <label class="form-label" for="u">Username</label>
          <input id="u" name="username" class="form-control form-control-lg" required autocomplete="username" placeholder="username">
        </div>
        <div class="mb-4">
          <label class="form-label" for="p">Password</label>
          <input id="p" name="password" type="password" class="form-control form-control-lg" required autocomplete="current-password" placeholder="••••••••">
        </div>
        <button type="submit" class="btn btn-success btn-lg w-100">Masuk</button>
      </form>
      <p class="text-center text-muted small mt-3 mb-0">Default: admin / admin123</p>
    </div>
  </div>
</body>
</html>
