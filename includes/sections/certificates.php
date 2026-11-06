<?php
$root  = dirname(__DIR__, 2);
$certs = $content['certificates'];
$dir   = 'assets/img/certificates/';

$rows = [];
foreach ($certs as $c) {
    $name   = $c['name'] ?? 'Untitled certificate';
    $issuer = $c['issuer'] ?? '';
    $date   = $c['date'] ?? '';
    $file   = basename($c['image'] ?? '');
    $src    = ($file !== '' && is_file("$root/assets/img/certificates/$file")) ? $dir . rawurlencode($file) : null;

    $rows[] = [
        'name' => $name, 'issuer' => $issuer, 'date' => $date,
        'json' => json_encode([
            'src'     => $src,
            'title'   => $name,
            'caption' => $issuer . ($issuer !== '' && $date !== '' ? ' · ' : '') . $date,
            'alt'     => 'Certification: ' . $name,
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE),
    ];
}
?>
<section id="certificates" class="section" aria-labelledby="certificates-title">
    <div class="container">
        <div class="section-head center" data-inview>
            <p class="section-num"><?= $sectionNum ?> &mdash; <?= htmlspecialchars($sectionLabel) ?></p>
                <h2 id="certificates-title">CERTIFIED</h2>
            <p class="section-sub">Courses and credentials I've completed.</p>
        </div>

        <?php if (!$rows): ?>
            <p class="placeholder" style="text-align:center;margin-inline:auto">No certifications yet.</p>
        <?php endif; ?>

        <ul class="cert-list">
        <?php foreach ($rows as $i => $c):
            $sub = $c['issuer'] . ($c['issuer'] !== '' && $c['date'] !== '' ? ' · ' : '') . $c['date'];
        ?>
            <li data-inview style="--i:<?= $i % 4 ?>">
                <button class="cert-row" type="button" data-cert="<?= htmlspecialchars($c['json'], ENT_QUOTES) ?>">
                    <span class="cert-num" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12.5l4.5 4.5L19 7.5"/></svg></span>
                    <span class="cert-main">
                        <span class="cert-name"><?= htmlspecialchars($c['name']) ?></span>
                        <?php if ($sub !== ''): ?><span class="cert-sub"><?= htmlspecialchars($sub) ?></span><?php endif; ?>
                    </span>
                    <svg class="cert-arrow" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                </button>
            </li>
        <?php endforeach; ?>
        </ul>
    </div>
</section>
