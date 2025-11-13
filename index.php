<?php
$name = 'Leonel Popatco';
$title = 'E‑Portfolio';
$profileImage = file_exists(__DIR__ . '/assets/nel.jfif') ? 'assets/nel.jfif' : (file_exists(__DIR__ . '/assets/profile.jpg') ? 'assets/profile.jpg' : 'https://via.placeholder.com/240x240.png?text=Leonel+Popatco');
$skills = [
  ['label' => 'HTML', 'value' => 50],
  ['label' => 'C++', 'value' => 55],
  ['label' => 'PHP', 'value' => 50],
  ['label' => 'Python', 'value' => 40],
  ['label' => 'JavaScript', 'value' => 30],
];
$projects = [
  ['name' => 'AIESCCS.COM', 'desc' => 'This official system portal at AIESCCS.com streamlines student access, attendance, and laboratory management for BSIS students at Santa Rita College. It ensures secure, accurate, and efficient tracking of lab entry and exit, reduces manual work, and provides faculty with tools for easy monitoring and reporting.', 'link' => 'https://AIESCCS.COM'],
  ['name' => 'Project Two', 'desc' => 'Short description of the project and the technologies used.', 'link' => '#'],
  ['name' => 'Project Three', 'desc' => 'Short description of the project and the technologies used.', 'link' => '#'],
];
// Build certificates dynamically from multiple locations (case-insensitive)
$certificates = [];
$allowed = ['jpg','jpeg','png','webp','gif'];
$scanRoots = [
  ['dir' => __DIR__ . '/assets/certificates', 'web' => 'assets/certificates'],
  ['dir' => __DIR__ . '/public/assets/certificates', 'web' => 'public/assets/certificates'],
];
// temp debug info
$__cert_debug = [];
foreach ($scanRoots as $root) {
  $dir = $root['dir'];
  $webBase = $root['web'];
  $paths = [];
  if (is_dir($dir)) {
    try {
      $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS));
      foreach ($it as $fileInfo) {
        if (!$fileInfo->isFile()) continue;
        $ext = strtolower($fileInfo->getExtension());
        if (!in_array($ext, $allowed, true)) continue;
        $paths[] = str_replace('\\', '/', $fileInfo->getPathname());
      }
    } catch (Throwable $e) { /* ignore */ }
    if (empty($paths)) {
      $patterns = ['*.jpg','*.jpeg','*.png','*.webp','*.gif','*.JPG','*.JPEG','*.PNG','*.WEBP','*.GIF'];
      foreach ($patterns as $pat) {
        $paths = array_merge($paths, array_map(function($p){return str_replace('\\','/',$p);}, glob($dir . '/' . $pat, GLOB_NOSORT) ?: []));
      }
    }
    sort($paths, SORT_NATURAL | SORT_FLAG_CASE);
    foreach ($paths as $abs) {
      $relFromDir = substr($abs, strlen(str_replace('\\','/',$dir)) + 1);
      $webPath = $webBase . '/' . $relFromDir;
      $base = pathinfo($abs, PATHINFO_FILENAME);
      $name = ucwords(str_replace(['-','_'], ' ', $base));
      $certificates[] = [
        'name' => $name,
        'issuer' => 'Certificate',
        'year' => date('Y'),
        'link' => $webPath,
        'image' => $webPath,
      ];
    }
  }
  $__cert_debug[] = ['dir' => $dir, 'count' => count($paths)];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo htmlspecialchars($name . ' — ' . $title); ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="public/css/styles.css">
</head>
<body>
  <header class="site-header">
    <div class="container header-inner">
      <div class="brand">
        <div class="logo-dot" aria-hidden="true"></div>
        <span class="brand-name"><?php echo htmlspecialchars($name); ?></span>
      </div>
      <nav class="nav">
        <a href="#about">About</a>
        <a href="#skills">Skills</a>
        <a href="#projects">Projects</a>
        <a href="#certificates">Certificates</a>
        <a href="#contact">Contact</a>
      </nav>
      <button class="nav-toggle" aria-label="Toggle navigation" aria-expanded="false">☰</button>
    </div>
  </header>

  <main>
    <section class="hero">
      <div class="container hero-grid">
        <div class="hero-text">
          <h1><?php echo htmlspecialchars($name); ?></h1>
          <p class="subtitle">Aspiring Developer • Problem Solver • Lifelong Learner</p>
          <div class="cta-row">
            <a class="btn primary" href="#projects">View Projects</a>
            <a class="btn ghost" href="#contact">Contact</a>
          </div>
        </div>
        <div class="hero-photo">
          <img src="<?php echo htmlspecialchars($profileImage); ?>" alt="Portrait of <?php echo htmlspecialchars($name); ?>">
        </div>
      </div>
    </section>

    <section id="about" class="section">
      <div class="container">
        <h2>About</h2>
        <p>
          Motivated and detail-oriented professional with a strong commitment to excellence and continuous learning. 
          Seeking to contribute my expertise and enthusiasm to a dynamic organization where I can grow and add value.
        </p>
      </div>
    </section>

    <section id="skills" class="section">
      <div class="container">
        <h2>Skills</h2>
        <div class="skills-list">
          <?php foreach ($skills as $s): ?>
            <div class="skill-item">
              <div class="skill-top">
                <span class="skill-label"><?php echo htmlspecialchars($s['label']); ?></span>
                <span class="skill-value"><?php echo (int)$s['value']; ?>%</span>
              </div>
              <div class="progress">
                <div class="bar" style="--val: <?php echo (int)$s['value']; ?>%"></div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <section id="projects" class="section">
      <div class="container">
        <h2>Projects</h2>
        <div class="projects-grid">
          <?php foreach ($projects as $p): ?>
            <article class="card">
              <div class="card-body">
                <h3><?php echo htmlspecialchars($p['name']); ?></h3>
                <p><?php echo htmlspecialchars($p['desc']); ?></p>
              </div>
              <div class="card-footer">
                <a class="btn small" href="<?php echo htmlspecialchars($p['link']); ?>">View</a>
              </div>
            </article>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <section id="certificates" class="section">
      <div class="container">
        <h2>Certificates</h2>
        <p style="margin-top:-6px;color:var(--muted);font-size:.95rem;">Found <?php echo count($certificates); ?> certificate image(s) in <code>assets/certificates</code>.</p>
        <?php if (count($certificates) === 0): ?>
          <details style="margin:8px 0 16px;">
            <summary style="cursor:pointer;color:var(--muted);">Show scan debug</summary>
            <pre style="white-space:pre-wrap;color:var(--muted);background:rgba(255,255,255,.03);padding:10px;border-radius:10px;border:1px solid rgba(255,255,255,.08);">
Scanned directories and counts:
<?php foreach ($__cert_debug as $d) { echo htmlspecialchars($d['dir'] . ' => ' . $d['count'] . ' file(s)') . "\n"; } ?>

Exists checks for common filenames:
<?php 
  $checkList = [
    __DIR__ . '/assets/certificates/ENGAGING STAKEHOLDERS.PNG',
    __DIR__ . '/assets/certificates/INTRODUCTION TO CYBERSECURITY.PNG',
__DIR__ . '/assets/certificates/PMI.PNG',];
  foreach ($checkList as $p) { echo htmlspecialchars($p . ' : ' . (file_exists($p) ? 'FOUND' : 'MISSING')) . "\n"; }
?>
            </pre>
          </details>
        <?php endif; ?>
        <div class="certs-grid">
          <?php if (empty($certificates)): ?>
            <p style="color: var(--muted);">No certificates found in <code>assets/certificates</code>. Add JPG/PNG/WEBP/GIF files and refresh.</p>
          <?php endif; ?>
          <?php foreach ($certificates as $c): ?>
            <?php 
              $imgPath = isset($c['image']) ? $c['image'] : '';
              $resolved = ($imgPath && file_exists(__DIR__ . '/' . $imgPath)) ? $imgPath : 'https://via.placeholder.com/1200x800.png?text=Certificate';
            ?>
            <article class="card">
              <a class="cert-thumb" href="<?php echo htmlspecialchars($c['link'] ?: $resolved); ?>" target="_blank" rel="noopener">
                <img src="<?php echo htmlspecialchars($resolved); ?>" alt="<?php echo htmlspecialchars($c['name']); ?>">
              </a>
              <div class="card-body">
                <h3><?php echo htmlspecialchars($c['name']); ?></h3>
                <p><?php echo htmlspecialchars($c['issuer'] . ' • ' . $c['year']); ?></p>
              </div>
              <div class="card-footer">
                <a class="btn small" href="<?php echo htmlspecialchars($c['link'] ?: $resolved); ?>" target="_blank" rel="noopener">Open</a>
              </div>
            </article>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <section id="contact" class="section">
      <div class="container">
        <h2>Contact</h2>
        <div class="contact-box">
          <p>Email: <a href="mailto:leonelpopatc16@gmail.com">leonelpopatco16@gmail.com</a></p>
          <p>Facebook: <a href="https://www.facebook.com/leonel.popatco.2024" target="_blank" rel="noopener">facebook.com/leonelpopatco</a></p>
          <p>Phone Number: <a href="https://instagram.com/leonelpopatco" target="_blank" rel="noopener">09069329185</a></p>
          <p>Location: Philippines</p>
        </div>
      </div>
    </section>
  </main>

  <footer class="site-footer">
    <div class="container">
      <p>© <?php echo date('Y'); ?> <?php echo htmlspecialchars($name); ?>. All rights reserved.</p>
    </div>
  </footer>

  <script>
    const btn = document.querySelector('.nav-toggle');
    const nav = document.querySelector('.nav');
    btn.addEventListener('click', () => {
      const expanded = btn.getAttribute('aria-expanded') === 'true' || false;
      btn.setAttribute('aria-expanded', !expanded);
      nav.classList.toggle('open');
    });
  </script>
</body>
</html>
