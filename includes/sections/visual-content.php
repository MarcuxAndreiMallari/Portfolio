<?php
    $root   = dirname(__DIR__, 2);
    $photos = $content['photography'];
    $dir    = 'assets/img/photography/';

    $cards = []; $categorize = [];
    foreach ($photos as $i => $p) {
        $title      = $p['title'] ?? 'Untitled';
        $categories = $p['category'] ?? 'Photography';
        $file       = basename($p['file'] ?? '');
        $src        = ($file !== '' && is_file("$root/assets/img/photography/$file")) ? $dir . rawurlencode($file) : null;

        $categorize[$categories] = ($categorize[$categories] ?? 0) + 1;
        $cards[] = [
            'title' => $title, 'categories' => $categories, 'src' => $src,
            'initials' => strtoupper(mb_substr($title, 0, 1)),
            'json' => json_encode([
                'src' => $src, 'title' => $title, 'caption' => $p['caption'] ?? '',
                'alt' => $title,
            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE),
        ];
    }
    ?>
    <section id="visual-content" class="section" aria-labelledby="visual-content-title">
        <div class="container">
            <div class="section-head center" data-inview>
                <p class="section-num"><?= $sectionNum ?> &mdash; <?= htmlspecialchars($sectionLabel) ?></p>
                    <h2 id="visual-content-title">GALLERY</h2>
                <p class="section-sub">A collection of original photography, composite edits, and visual experiments.</p>
            </div>

            <?php if (count($categorize) > 1): ?>
            <div class="photo-filters" role="group" aria-label="Filter photos" data-inview>
                <button class="photo-filter is-active" type="button" data-filter="all" aria-pressed="true">All <span><?= count($cards) ?></span></button>
                <?php foreach ($categorize as $name => $n): ?>
                <button class="photo-filter" type="button" data-filter="<?= htmlspecialchars($name, ENT_QUOTES) ?>" aria-pressed="false"><?= htmlspecialchars($name) ?> <span><?= $n ?></span></button>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <?php if (!$cards): ?>
                <p class="placeholder" style="text-align:center;margin-inline:auto">No photos yet.</p>
            <?php endif; ?>
        </div>

        <?php if ($cards): ?>
        <!-- Carousel sits OUTSIDE .container on purpose, so it spans the full width of the screen -->
        <div class="dof" data-inview tabindex="0" role="region" aria-roledescription="carousel" aria-label="Photo carousel. Use the left and right arrow keys.">
            <div class="dof-track">
            <?php foreach ($cards as $i => $c): ?>
                <figure class="photo" data-categories="<?= htmlspecialchars($c['categories'], ENT_QUOTES) ?>" data-photo="<?= htmlspecialchars($c['json'], ENT_QUOTES) ?>">
                    <button class="photo-btn" type="button" aria-label="View <?= htmlspecialchars($c['title'], ENT_QUOTES) ?>">
                    <?php if ($c['src']): ?>
                        <span class="dof-frame" style="--img:url('<?= htmlspecialchars($c['src'], ENT_QUOTES) ?>')">
                            <img src="<?= htmlspecialchars($c['src']) ?>" alt="" draggable="false" decoding="async"<?= $i > 6 ? ' loading="lazy"' : '' ?>>
                        </span>
                    <?php else: ?>
                        <span class="dof-frame"><span class="ph"><strong><?= htmlspecialchars($c['initials']) ?></strong><span>Photo placeholder</span></span></span>
                    <?php endif; ?>
                    </button>
                </figure>
            <?php endforeach; ?>
            </div>

            <div class="dof-info">
                <button class="dof-nav dof-prev" type="button" aria-label="Previous photo">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 5l-7 7 7 7"/></svg>
                </button>
                <div class="dof-caption" aria-live="polite">
                    <span class="photo-no" data-dof-no></span>
                    <strong class="photo-title" data-dof-title></strong>
                    <span class="photo-categories" data-dof-categories></span>
                </div>
                <button class="dof-nav dof-next" type="button" aria-label="Next photo">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
        </div>
        <?php endif; ?>
</section>
