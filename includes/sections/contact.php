<?php
    $info    = $content['contact'];
    $to      = trim((string) ($info['email'] ?? ''));
    $intents = $info['intents'] ?? [];
    $first   = $intents[0] ?? ['id' => '', 'subject' => 'Hello', 'starter' => '', 'placeholder' => ''];

    // Starting links (used before JavaScript takes over, and when it is off)
    $mailQuery = 'subject=' . rawurlencode($first['subject']) . '&body=' . rawurlencode($first['starter']);
    $mailLink  = 'mailto:' . $to . '?' . $mailQuery;
    $gmailLink = 'https://mail.google.com/mail/?view=cm&fs=1&to=' . rawurlencode($to) . '&su=' . rawurlencode($first['subject']) . '&body=' . rawurlencode($first['starter']);

    // Icons for the links (simple outline style)
    $icons = [
        'mail'      => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/>',
        'github'    => '<path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"/>',
        'linkedin'  => '<path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/>',
        'facebook'  => '<path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>',
        'instagram' => '<rect x="2" y="2" width="20" height="20" rx="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><path d="M17.5 6.5h.01"/>',
        'link'      => '<path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>',
    ];
    $icon = function ($name) use ($icons) {
        return '<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">'
            . ($icons[$name] ?? $icons['link']) . '</svg>';
    };
    $socials = array_values(array_filter($info['socials'] ?? [], function ($s) { return !empty($s['url']); }));
    ?>
    <section id="contact" class="section" aria-labelledby="contact-title">
        <div class="container">
            <div class="section-head center" data-inview>
                <p class="section-num"><?= $sectionNum ?> &mdash; <?= htmlspecialchars($sectionLabel) ?></p>
                    <h2 id="contact-title">LET'S BUILD SOMETHING TOGETHER</h2>
                <p class="section-sub"><?= htmlspecialchars($info['intro'] ?? '') ?></p>
            </div>

            <div class="contact-grid">
                <aside class="contact-info" data-inview style="--i:0" aria-label="Contact details">
                    <h3>Get in touch</h3>
                        <?php if (!empty($info['blurb'])): ?><p class="ci-blurb"><?= htmlspecialchars($info['blurb']) ?></p><?php endif; ?>

                        <ul class="contact-links">
                        <?php if ($to !== '' && !empty($info['showEmail'])): ?>
                            <li>
                                <a href="mailto:<?= htmlspecialchars($to, ENT_QUOTES) ?>">
                                    <span class="ci-ico"><?= $icon('mail') ?></span>
                                    <span class="ci-text"><small>Email</small><span><?= htmlspecialchars($to) ?></span></span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php foreach ($socials as $s): ?>
                            <li>
                                <a href="<?= htmlspecialchars($s['url'], ENT_QUOTES) ?>" target="_blank" rel="noopener noreferrer">
                                    <span class="ci-ico"><?= $icon($s['icon'] ?? 'link') ?></span>
                                    <span class="ci-text"><small><?= htmlspecialchars($s['label'] ?? 'Link') ?></small><span><?= htmlspecialchars(preg_replace('~^https?://(www\.)?~i', '', rtrim($s['url'], '/'))) ?></span></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                        </ul>

                        <?php if (!empty($info['reply'])): ?><p class="ci-reply"><?= htmlspecialchars($info['reply']) ?></p><?php endif; ?>
                </aside>

                <div class="contact-card" data-inview style="--i:1">
                    <form class="cform" id="contactForm" data-to="<?= htmlspecialchars($to, ENT_QUOTES) ?>" onsubmit="return false">
                        <fieldset class="cform-group">
                            <legend class="cform-label">Intent</legend>
                            <div class="intents">
                                <?php foreach ($intents as $n => $it): ?>
                                    <label class="intent">
                                        <input type="radio" name="intent" value="<?= htmlspecialchars($it['id'], ENT_QUOTES) ?>"
                                            data-subject="<?= htmlspecialchars($it['subject'], ENT_QUOTES) ?>"
                                            data-placeholder="<?= htmlspecialchars($it['placeholder'] ?? '', ENT_QUOTES) ?>"
                                            data-starter="<?= htmlspecialchars($it['starter'] ?? '', ENT_QUOTES) ?>"<?= $n === 0 ? ' checked' : '' ?>>
                                        <span><?= htmlspecialchars($it['label']) ?></span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </fieldset>

                        <div class="cform-group">
                            <label class="cform-label" for="cDetails">Details</label>
                            <textarea id="cDetails" name="details" rows="6" maxlength="1500" placeholder="<?= htmlspecialchars($first['placeholder'] ?? '', ENT_QUOTES) ?>"></textarea>
                            <span class="counter" id="cCount" aria-hidden="true">0 / 1500</span>
                        </div>

                        <div class="cform-actions">
                            <a class="btn btn-primary" id="cMail" href="<?= htmlspecialchars($mailLink, ENT_QUOTES) ?>">
                                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><?= $icons['mail'] ?></svg>
                                Compose email
                            </a>
                            <a class="btn btn-ghost" id="cGmail" href="<?= htmlspecialchars($gmailLink, ENT_QUOTES) ?>" target="_blank" rel="noopener noreferrer">
                                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 3h7v7M21 3l-9 9M19 14v5a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h5"/></svg>
                                Gmail
                            </a>
                            <button class="btn btn-ghost" id="cCopy" type="button">
                                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="9" y="9" width="12" height="12" rx="2"/><path d="M5 15V5a2 2 0 0 1 2-2h10"/></svg>
                                <span id="cCopyLabel">Copy details</span>
                            </button>
                        </div>
                        <p class="cform-note" id="cNote">marcuxcauagas@gmail.com</p>
                        <p class="sr-only" id="cStatus" role="status" aria-live="polite"></p>
                    </form>
                </div>
            </div>
        </div>
    </section>
