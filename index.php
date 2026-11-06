<?php
    $site = [
        'name'        => 'MM.',   // header + footer text
        'title'       => 'Marcux Andrei C. Mallari | Personal Portfolio',   // browser tab
        'description' => 'Personal IT portfolio: skills, projects, photography, and certifications.',

        // ----- Home section (edit these) -----
        'fullName'   => 'Marcux Andrei C. Mallari',
        'about'       => 'I build practical, well-crafted software and capture the world through a lens. This portfolio brings together my technical skills, projects, photography, and certifications.',

        // The sliding words under the paragraph (right to left, endless). Edit, add, remove or reorder the words.
        'marquee' => ['IT Student', 'Web Developer', 'Aspiring Photographer', 'Photo Editor', 'Product Designer'],

        // The "about me" cards under the paragraph. Edit the text, reorder, add or delete a card.
        // The Contact card shows your name and the email address from the 'contact' block of data/content.php (one place to edit).
        'facts' => [
            ['label' => 'Focus',     'value' => 'Web Development and systems, photography, and photo editing.'],
            ['label' => 'Education', 'value' => 'BS Information Technology-in PLV (expected to graduate in 2028)'],
            ['label' => 'Location',  'value' => 'Valenzuela City, Philippines'],
            ['label' => 'Main Contact',   'value' => 'Marcux Andrei C. Mallari', 'email' => true]
        ],
    ];

    // Initials for the intro screen
    $words = preg_split('/\s+/', trim($site['fullName']));
    $site['initials'] = strtoupper(mb_substr($words[0], 0, 1) . mb_substr(end($words), 0, 1));


    // All the text of the portfolio (sections, skills, projects, photos, certifications, contact)
    $content  = require __DIR__ . '/data/content.php';
    $sections = $content['sections'];
    ?>
    <!-- ====================== PAGE TOP: head, intro, header, menus ====================== -->
    <!DOCTYPE html>
    <html lang="en" data-theme="dark">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
                <title><?= htmlspecialchars($site['title']) ?></title>
                    <meta name="description" content="<?= htmlspecialchars($site['description']) ?>">
                    <meta name="theme-color" content="#05060a">
                    <meta property="og:type" content="website">
                    <meta property="og:title" content="<?= htmlspecialchars($site['title']) ?>">
                    <meta property="og:description" content="<?= htmlspecialchars($site['description']) ?>">
                    <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 64'%3E%3Crect width='64' height='64' rx='14' fill='%2305060a'/%3E%3Ctext x='32' y='43' font-family='Arial,sans-serif' font-size='28' font-weight='700' text-anchor='middle' fill='%234f8cff'%3E<?= rawurlencode($site['initials']) ?>%3C/text%3E%3C/svg%3E">
                    <link rel="preconnect" href="https://fonts.googleapis.com">
                    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter+Tight:wght@400;500;600&family=Space+Grotesk:wght@500;600;700&display=swap">
                    <link rel="stylesheet" href="assets/css/style.css">
            <script>
            /* Before first paint: apply the saved theme (default dark) and play the intro once per visit. */
            /* Before first paint: apply the saved theme (default dark). The intro plays every time the page loads or is refreshed. */
            (function () {
                var t = null, r = document.documentElement;
                try {
                    t = localStorage.getItem('portfolio-theme');
                } catch (e) {}
                r.setAttribute('data-theme', t === 'light' ? 'light' : 'dark');
                r.classList.add('js');
            })();
            </script>
        </head>
            <body>
                <canvas id="starfield" aria-hidden="true"></canvas>

        <!-- Page-load intro (plays once per visit; hides itself) -->
                    <div class="intro" aria-hidden="false">
                        <div class="intro-mark">
                            <svg viewBox="0 0 100 100"><circle cx="50" cy="50" r="46"/></svg>
                            <span>MM</span>
                        </div>
                    </div>

                    <a class="skip-link" href="#main">Skip to content</a>

                    <header class="site-header" id="siteHeader">
                        <a class="brand" href="#home"><?= htmlspecialchars($site['name']) ?></a>

                        <!-- Desktop menu (same list as the footer and mobile menus: the 'sections' block of data/content.php) -->
                        <nav class="nav" id="primaryNav" aria-label="Primary">
                            <ul class="nav-list">
                            <?php foreach ($sections as $s): ?>
                                <li><a href="#<?= $s['id'] ?>" data-section="<?= $s['id'] ?>"><?= htmlspecialchars($s['label']) ?></a></li>
                            <?php endforeach; ?>
                            </ul>
                            <span class="nav-indicator" aria-hidden="true"></span>
                        </nav>

                        <div class="header-actions">
                            <button class="theme-toggle" id="themeToggle" type="button" aria-label="Switch to light mode" title="Switch to light mode">
                                <svg class="icon-sun" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true">
                                    <circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4"/>
                                </svg>
                                <svg class="icon-moon" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8z"/>
                                </svg>
                            </button>
                            <button class="menu-btn" id="menuBtn" type="button" aria-label="Open menu" aria-expanded="false" aria-controls="mobileMenu">
                                <span></span><span></span><span></span>
                            </button>
                        </div>
                    </header>

                    <!-- Mobile full-screen menu -->
                    <div class="mobile-menu" id="mobileMenu">
                        <nav aria-label="Mobile">
                            <ul>
                            <?php foreach ($sections as $i => $s): ?>
                                <li style="--i:<?= $i ?>"><a href="#<?= $s['id'] ?>" data-section="<?= $s['id'] ?>"><?= htmlspecialchars($s['label']) ?></a></li>
                            <?php endforeach; ?>
                            </ul>
                        </nav>
                    </div>

                    <!-- ====================== SECTIONS ====================== -->
                    <main id="main">
                    <?php foreach ($sections as $i => $s):
                        // Each section lives in includes/sections/<id>.php
                        // $sectionNum / $sectionLabel make the small "01 — Home" label above each heading. They follow the order and labels in the 'sections' block of data/content.php.
                        $sectionNum   = sprintf('%02d', $i + 1);
                        $sectionLabel = $s['label'];
                        $partial = __DIR__ . '/includes/sections/' . $s['id'] . '.php';
                        if (is_file($partial)) include $partial;
                    endforeach; ?>
                    </main>

                    <!-- ====================== PAGE BOTTOM: footer, back-to-top, viewer ====================== -->
                    <footer class="site-footer">
                        <nav class="footer-nav" aria-label="Footer">
                            <ul>
                            <?php foreach ($sections as $s): ?>
                                <li><a href="#<?= $s['id'] ?>" data-section="<?= $s['id'] ?>"><?= htmlspecialchars($s['label']) ?></a></li>
                            <?php endforeach; ?>
                            </ul>
                        </nav>
                        <p class="copyright">&copy; 2026 Mallari is keeping it simple. All rights reserved.</p>
                    </footer>

                    <button class="to-top" id="toTop" type="button" aria-label="Back to top">
                        <svg class="ring" viewBox="0 0 48 48" aria-hidden="true"><circle cx="24" cy="24" r="22"/></svg>
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 19V5M5 12l7-7 7 7"/></svg>
                    </button>

                    <!-- Shared viewer: project images, code preview (and later photos + certificates). Filled in by the VIEWER code in assets/js/app.js -->
                    <div class="lb" id="lightbox" role="dialog" aria-modal="true" aria-labelledby="lbTitle">
                        <div class="lb-backdrop" data-lb-close></div>
                        <div class="lb-dialog">
                            <div class="lb-bar">
                                <h3 class="lb-title" id="lbTitle"></h3>
                                    <span class="lb-counter" id="lbCounter" aria-live="polite"></span>
                                <button class="lb-btn" id="lbClose" type="button" data-lb-close aria-label="Close viewer">
                                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M6 6l12 12M18 6L6 18"/></svg>
                                </button>
                            </div>

                            <div class="lb-stage" id="lbStage">
                                <button class="lb-btn lb-arrow lb-prev" id="lbPrev" type="button" aria-label="Previous image">
                                    <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 5l-7 7 7 7"/></svg>
                                </button>
                                    <figure class="lb-media" id="lbMedia"></figure>
                                <button class="lb-btn lb-arrow lb-next" id="lbNext" type="button" aria-label="Next image">
                                    <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 5l7 7-7 7"/></svg>
                                </button>
                            </div>
                            <p class="lb-caption" id="lbCaption" hidden></p>

                            <div class="lb-code" id="lbCode" hidden>
                                <div class="code-bar"><i></i><i></i><i></i><span class="code-name" id="lbCodeName"></span><span class="code-lang" id="lbCodeLang"></span></div>
                                    <pre class="code-body" id="lbCodeBody" tabindex="0"></pre>
                                <div class="code-lock" id="lbLock">
                                    <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="4" y="11" width="16" height="10" rx="2"/><path d="M8 11V8a4 4 0 0 1 8 0v3"/></svg>
                                        <p>Want to unlock the rest?</p>
                                    <a class="btn btn-primary btn-sm" href="#contact" data-lb-close data-lb-contact>Contact me for the full code.</a>
                                </div>
                            </div>

                            <div class="lb-foot">
                                <div class="lb-thumbs" id="lbThumbs"></div>
                                <button class="btn btn-ghost btn-sm lb-switch" id="lbSwitch" type="button" hidden>
                                    <svg class="sw-code" viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M8 7l-5 5 5 5M16 7l5 5-5 5M14 4l-4 16"/></svg>
                                    <svg class="sw-img" viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="18" height="16" rx="2"/><circle cx="9" cy="10" r="2"/><path d="M21 16l-5-5-8 9"/></svg>
                                    <span id="lbSwLabel">View code</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <script src="assets/js/app.js"></script>
                </body>
    </html>
