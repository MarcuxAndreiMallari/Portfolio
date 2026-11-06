<?php
    $root     = dirname(__DIR__, 2);
    $projects = $content['projects'];
    $imgUrl   = 'assets/img/projects/';

    $imgPath = function ($file) use ($root) {
        $file = ltrim(str_replace('\\', '/', trim((string) $file)), '/');
        if ($file === '' || preg_match('#(^|/)\.\.?(/|$)#', $file)) return null;
        return is_file("$root/assets/img/projects/$file") ? $file : null;
    };
    $imgSrc = function ($file) use ($imgUrl) {
        return $imgUrl . implode('/', array_map('rawurlencode', explode('/', $file)));
    };

    // Prepare every card first (image checks + the code excerpt)
    $cards = [];
    foreach ($projects as $p) {
        $title = $p['title'] ?? 'Untitled project';

        $items = [];
        foreach (($p['images'] ?? []) as $n => $img) {
            $file    = is_array($img) ? ($img['file'] ?? '') : $img;
            $label   = is_array($img) ? trim((string) ($img['label'] ?? '')) : '';
            $caption = is_array($img) ? trim((string) ($img['caption'] ?? '')) : '';
            $f = $imgPath($file);
            if ($f !== null) {
                $items[] = [
                    'src'     => $imgSrc($f),
                    'alt'     => $label !== '' ? $title . ': ' . $label : $title . ' (image ' . ($n + 1) . ')',
                    'label'   => $label,
                    'caption' => $caption,
                ];
            }
        }

        // Full description 
        $overview = $p['overview'] ?? [];
        if (is_string($overview)) $overview = [$overview];
        $overview = array_values(array_filter(array_map('trim', array_map('strval', $overview)), 'strlen'));
        $users    = array_values(array_filter($p['users'] ?? [], function ($u) { return is_array($u) && !empty($u['role']); }));
        $features = [];
        foreach (($p['features'] ?? []) as $g) {
            if (is_string($g)) { $features[] = ['group' => '', 'items' => [$g]]; continue; }   // a plain bullet
            if (is_array($g) && !empty($g['items'])) $features[] = ['group' => (string) ($g['group'] ?? ''), 'items' => (array) $g['items']];
        }

        $thumb = null;
        $t = !empty($p['thumb']) ? $imgPath($p['thumb']) : null;
        if ($t !== null) {
            $thumb = $imgSrc($t);
        } elseif ($items) {
            $thumb = $items[0]['src'];
        }

        // Code preview
        $code = null;
        if (!empty($p['code']['file'])) {
            $path = "$root/data/code/" . basename($p['code']['file']);
            if (is_file($path)) {
                $raw   = (string) file_get_contents($path);
                $raw   = preg_replace('/^\xEF\xBB\xBF/', '', $raw);
                $raw   = str_replace(["\r\n", "\r", "\t"], ["\n", "\n", '    '], $raw);
                $code  = [
                    'name' => $p['code']['name'] ?? basename($path),
                    'lang' => $p['code']['lang'] ?? '',
                    'text' => rtrim($raw),
                ];
            }
        }

        $words = preg_split('/\s+/', trim($title));
        $cards[] = [
            'title'    => $title,
            'summary'  => $p['summary'] ?? '',
            'tags'     => $p['tags'] ?? [],
            'thumb'    => $thumb,
            'count'    => count($items),
            'overview' => $overview,
            'users'    => $users,
            'features' => $features,
            'hasDetail'=> (bool) ($overview || $users || $features),
            'code'     => (bool) $code,
            'initials' => strtoupper(mb_substr($words[0], 0, 1) . (count($words) > 1 ? mb_substr(end($words), 0, 1) : '')),
            'json'     => json_encode([
                'title' => $title,
                'items' => $items ?: [['src' => null, 'alt' => $title]],
                'code'  => $code,
            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE),
        ];
    }
    ?>
    <section id="projects" class="section" aria-labelledby="projects-title">
        <div class="container">
            <div class="section-head center" data-inview>
                <p class="section-num"><?= $sectionNum ?> &mdash; <?= htmlspecialchars($sectionLabel) ?></p>
                    <h2 id="projects-title">SELECTED WORK</h2>
                <p class="section-sub">Here are some of the projects I've worked on. The whole system, BUILT.</p>
            </div>

            <?php if (!$cards): ?>
                <p class="placeholder" style="text-align:center;margin-inline:auto">No projects yet.</p>
            <?php endif; ?>
        </div>

        <?php if ($cards): ?>
            <div class="pdof" data-inview tabindex="0" role="region" aria-roledescription="carousel" aria-label="Project carousel. Use the left and right arrow keys.">
                <div class="projects-grid pdof-track">
                <?php foreach ($cards as $i => $c): ?>
                    <article class="project" data-project="<?= htmlspecialchars($c['json'], ENT_QUOTES) ?>">
                        <button class="project-thumb" type="button" data-open="images" aria-label="View a Demo <?= htmlspecialchars($c['title'], ENT_QUOTES) ?>">
                        <?php if ($c['thumb']): ?>
                            <img src="<?= htmlspecialchars($c['thumb']) ?>" alt="" loading="lazy" decoding="async">
                        <?php else: ?>
                            <span class="ph"><strong><?= htmlspecialchars($c['initials']) ?></strong><span>No images yet.</span></span>
                        <?php endif; ?>
                            <?php if ($c['count'] > 1): ?><span class="thumb-count"><?= $c['count'] ?> images</span><?php endif; ?>
                            <span class="thumb-hint"><span>Click to zoom</span></span>
                        </button>

                        <div class="project-body">
                            <h3><?= htmlspecialchars($c['title']) ?></h3>
                            <?php if ($c['summary']): ?><p class="project-summary"><?= htmlspecialchars($c['summary']) ?></p><?php endif; ?>

                            <?php if ($c['hasDetail']): ?>
                            <!-- Pop-over: floats over the lower part of the card (so the card never changes size). Opens on hover, or on tap/Enter. See PROJECTS in assets/js/app.js -->
                            <div class="project-peek" id="project-peek-<?= $i ?>" role="region" aria-label="Full description of <?= htmlspecialchars($c['title'], ENT_QUOTES) ?>">
                                <div class="pp-bar">
                                    <span class="pp-title">Full description</span>
                                    <button class="pp-close" type="button" aria-label="Close description">
                                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M6 6l12 12M18 6L6 18"/></svg>
                                    </button>
                                </div>
                                <div class="pp-body" tabindex="0">
                                <div class="pd-content">
                                    <?php if ($c['overview']): ?>
                                    <div class="pd-block">
                                            <h4 class="pd-heading">About the system</h4>
                                        <?php foreach ($c['overview'] as $para): ?><p><?= htmlspecialchars($para) ?></p><?php endforeach; ?>
                                    </div>
                                    <?php endif; ?>

                                    <?php if ($c['users']): ?>
                                    <div class="pd-block">
                                            <h4 class="pd-heading">Who uses it</h4>
                                        <ul class="pd-users">
                                        <?php foreach ($c['users'] as $u): ?>
                                            <li><strong class="pd-role"><?= htmlspecialchars($u['role']) ?></strong><span><?= htmlspecialchars($u['desc'] ?? '') ?></span></li>
                                        <?php endforeach; ?>
                                        </ul>
                                    </div>
                                    <?php endif; ?>

                                    <?php if ($c['features']): ?>
                                    <div class="pd-block">
                                            <h4 class="pd-heading">What the system does</h4>
                                        <?php foreach ($c['features'] as $g): ?>
                                            <?php if ($g['group'] !== ''): ?><h5 class="pd-group"><?= htmlspecialchars($g['group']) ?></h5><?php endif; ?>
                                            <ul class="pd-list">
                                            <?php foreach ($g['items'] as $item): ?><li><?= htmlspecialchars((string) $item) ?></li><?php endforeach; ?>
                                            </ul>
                                        <?php endforeach; ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                </div>
                            </div>
                            <?php endif; ?>
                            <?php if ($c['tags']): ?>
                            <ul class="tags">
                                <?php foreach ($c['tags'] as $tag): ?><li><?= htmlspecialchars($tag) ?></li><?php endforeach; ?>
                            </ul>
                            <?php endif; ?>
                        </div>

                        <div class="project-actions">
                            <button class="btn btn-ghost btn-sm" type="button" data-open="images">
                                <svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3M11 8v6M8 11h6"/></svg>
                                Explore System
                            </button>
                            <?php if ($c['hasDetail']): ?>
                            <button class="btn btn-ghost btn-sm project-more" type="button" aria-expanded="false" aria-controls="project-peek-<?= $i ?>">
                                <svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 3h9l4 4v14H6z"/><path d="M14 3v5h5M9 13h6M9 17h6"/></svg>
                                Full Description
                            </button>
                            <?php endif; ?>
                            <?php if ($c['code']): ?>
                            <button class="btn btn-ghost btn-sm" type="button" data-open="code">
                                <svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M8 7l-5 5 5 5M16 7l5 5-5 5M14 4l-4 16"/></svg>
                                View Code
                            </button>
                            <?php endif; ?>
                        </div>
                    </article>
                <?php endforeach; ?>
                </div>

                <div class="dof-info pdof-info">
                    <button class="dof-nav pdof-prev" type="button" aria-label="Previous project">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 5l-7 7 7 7"/></svg>
                    </button>
                    <div class="dof-caption" aria-live="polite">
                        <span class="photo-no" data-pdof-no></span>
                        <span class="pdof-dots" data-pdof-dots></span>
                    </div>
                    <button class="dof-nav pdof-next" type="button" aria-label="Next project">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            </div>
    <?php endif; ?>
</section>
