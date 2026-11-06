<?php
    $contactInfo = $content['contact'];
    $myEmail     = trim((string) ($contactInfo['email'] ?? ''));
    ?>
    <section id="home" class="section hero-section" aria-labelledby="home-title">
        <div class="container hero">

            <p class="section-num" data-reveal style="--n:0"><?= $sectionNum ?> &mdash; <?= htmlspecialchars($sectionLabel) ?></p>
            <p class="hero-greeting" data-reveal style="--n:0">Hello, I'm</p>
            <h1 class="hero-name" id="home-title" data-reveal style="--n:1"><?= htmlspecialchars($site['fullName']) ?></h1>

            <p class="hero-about" data-reveal style="--n:2"><?= htmlspecialchars($site['about']) ?></p>

            <?php if (!empty($site['marquee'])): ?>
            <div class="marquee" data-reveal style="--n:3" role="group" aria-label="<?= htmlspecialchars(implode(', ', $site['marquee']), ENT_QUOTES) ?>">
                <div class="marquee-track" aria-hidden="true">
                <?php for ($g = 0; $g < 2; $g++): ?>
                    <ul class="marquee-group"<?= $g ? ' data-clone' : '' ?>>
                    <?php $last = count($site['marquee']) - 1;
                    for ($rep = 0; $rep < 2; $rep++): foreach (array_values($site['marquee']) as $k => $word): ?>
                        <li<?= $rep ? ' data-rep' : '' ?><?= (!$rep && $k === $last) ? ' data-end' : '' ?>><?= htmlspecialchars($word) ?></li>
                    <?php endforeach; endfor; ?>
                    </ul>
                <?php endfor; ?>
                </div>
            </div>
            <?php endif; ?>

            <?php if (!empty($site['facts'])): ?>
            <ul class="facts" aria-label="About me">
                <?php foreach ($site['facts'] as $i => $f): ?>
                    <li class="fact" data-reveal style="--n:<?= 4 + $i ?>">
                        <span class="fact-label"><?= htmlspecialchars($f['label']) ?></span>
                            <span class="fact-value"><?= htmlspecialchars($f['value']) ?></span>
                        <?php if (!empty($f['email']) && $myEmail !== ''): ?>
                            <a class="fact-link" href="mailto:<?= htmlspecialchars($myEmail, ENT_QUOTES) ?>"><?= htmlspecialchars($myEmail) ?></a>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>

            <div class="hero-actions" data-reveal style="--n:<?= 4 + count($site['facts'] ?? []) ?>">
                <a class="btn btn-primary" href="#projects">
                    View Projects
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                </a>
                <a class="btn btn-primary" href="#visual-content">
                    View Visual Contents
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                </a>
                <a class="btn btn-ghost" href="#contact">
                    Hire Me
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/></svg>
                </a>
            </div>
        </div>
</section>
