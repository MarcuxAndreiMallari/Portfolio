<?php
    $tiers = $content['skills'];
    $total = count($tiers);
    ?>
    <section id="skillset" class="section" aria-labelledby="skillset-title">
        <div class="container">
            <div class="section-head center" data-inview>
                <p class="section-num"><?= $sectionNum ?> &mdash; <?= htmlspecialchars($sectionLabel) ?></p>
                    <h2 id="skillset-title">STACK</h2>
                <p class="section-sub">Explore my arsenal of skills and technical knowledge, along with the proficiency I've developed through practice and experience.</p>
            </div>

            <div class="skills-grid">
            <?php $n = 0; foreach ($tiers as $tier): $n++;
                $strength = $total > 1 ? round(25 + 75 * ($n - 1) / ($total - 1)) : 100; 
                $glow     = round($n / $total, 2);                                        
                $skills   = $tier['skills'] ?? [];
            ?>
                <article class="tier<?= $n === $total ? ' is-top' : '' ?>" data-inview style="--i:<?= $n - 1 ?>; --tier:<?= $strength ?>%; --o:<?= $glow ?>">
                    <div class="tier-head">
                        <h3 class="tier-title"><?= htmlspecialchars($tier['label']) ?></h3>
                        <span class="level" role="img" aria-label="Level <?= $n ?> of <?= $total ?>">
                            <?php for ($k = 1; $k <= $total; $k++): ?><i<?= $k <= $n ? ' class="on"' : '' ?>></i><?php endfor; ?>
                        </span>
                    </div>
                    <?php if (!empty($tier['blurb'])): ?><p class="tier-blurb"><?= htmlspecialchars($tier['blurb']) ?></p><?php endif; ?>

                    <?php if ($skills): ?>
                    <ul class="chips">
                        <?php foreach ($skills as $k => $skill): ?>
                        <li class="chip" style="--i:<?= $k ?>"><?= htmlspecialchars($skill) ?></li>
                        <?php endforeach; ?>
                    </ul>

                    <p class="tier-count"><?= count($skills) ?> <?= count($skills) === 1 ? 'skill' : 'skills' ?></p>
                        <?php else: ?>
                    <p class="tier-empty">Nothing here yet.</p>
                        <?php endif; ?>
                </article>
            <?php endforeach; ?>
            </div>
        </div>
    </section>
