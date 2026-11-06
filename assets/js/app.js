/* 
    1. HAIRLINE
    2. THEME
    3. STARFIELD
    4. NAVIGATION
    5. REVEAL
    6. CODE HIGHLIGHT
    7. VIEWER
    8. PROJECTS
    9. VISUAL CONTENT
    10. CERTIFICATIONS
    11. CONTACT */

/*  HAIRLINE  - keeps the section divider line visible when zoomed out */

(function () {
    var root = document.documentElement;
        function update() {
            var dpr = window.devicePixelRatio || 1;
            root.style.setProperty('--line', Math.max(1, Math.round(1.4 / dpr)) + 'px');
        }
            update();
            window.addEventListener('resize', update);   // zooming fires a resize
        })();

        /*THEME  - dark / light mdoe*/
        (function () {
            var storageKey = 'portfolio-theme';
            var root = document.documentElement;
            var btn = document.getElementById('themeToggle');

            function label(theme) {
                if (!btn) return;
                var next = theme === 'dark' ? 'light' : 'dark';
                btn.setAttribute('aria-label', 'Switch to ' + next + ' mode');
                btn.setAttribute('title', 'Switch to ' + next + ' mode');
            }

            function apply(theme, animate) {
                if (animate) {
                    root.classList.add('theme-fade');
                    setTimeout(function () { root.classList.remove('theme-fade'); }, 450);
                }
                root.setAttribute('data-theme', theme);
                try { localStorage.setItem(storageKey, theme); } catch (e) {}
                label(theme);
                document.dispatchEvent(new CustomEvent('themechange', { detail: theme }));
            }

            label(root.getAttribute('data-theme'));

            if (btn) {
                btn.addEventListener('click', function () {
                    apply(root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark', true);
                });
            }
        })();

        /*STARFIELD*/

        (function () {
            var canvas = document.getElementById('starfield');
            if (!canvas) return;
            var ctx = canvas.getContext('2d');
            var root = document.documentElement;
            var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            var stars = [], w = 0, h = 0, dpr = 1;
            var rgb = '255,255,255', strength = 1, size = 1, dust = 0;
            var mx = 0, my = 0, tx = 0, ty = 0;
            var raf = null;

            function readTheme() {
                var cs = getComputedStyle(root);
                rgb = cs.getPropertyValue('--star-rgb').trim() || '255,255,255';
                strength = parseFloat(cs.getPropertyValue('--star-strength')) || 1;
                size = parseFloat(cs.getPropertyValue('--star-size')) || 1;
                dust = parseFloat(cs.getPropertyValue('--star-dust')) || 0;
            }

            function build() {
                dpr = Math.min(window.devicePixelRatio || 1, 2);
                w = window.innerWidth; h = window.innerHeight;
                canvas.width = w * dpr; canvas.height = h * dpr;
                ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
                var count = Math.round(Math.min(Math.max(w * h / 9000, 50), w < 700 ? 90 : 200));
                stars = [];
                for (var i = 0; i < count; i++) {
                    var depth = Math.random();
                    stars.push({
                        x: Math.random() * w, y: Math.random() * h,
                        r: 0.3 + depth * 1.1,
                        a: 0.35 + Math.random() * 0.65,
                        speed: 0.4 + Math.random() * 1.2,
                        phase: Math.random() * 6.28,
                        depth: 0.2 + depth * 0.8
                    });
                }
                /* Fine dust clustered along a diagonal band*/
                if (dust > 0) {
                    var n = Math.round(Math.min(w * h / 5000, w < 700 ? 260 : 650) * dust);
                    var spread = w * 0.13;
                    for (var j = 0; j < n; j++) {
                        var u = Math.random();
                        var off = (Math.random() + Math.random() + Math.random() - 1.5) * 2 * spread;
                        stars.push({
                            x: w * (0.05 + 0.75 * u) + off * 0.45, y: h * (1.02 - 1.04 * u) - off * 0.9,
                            r: 0.25 + Math.random() * 0.4, a: 0.25 + Math.random() * 0.5,
                            speed: 0.3 + Math.random(), phase: Math.random() * 6.28,
                            depth: 0.3, d: true
                        });
                    }
                }
            }

            function draw(t) {
                ctx.clearRect(0, 0, w, h);
                mx += (tx - mx) * 0.05; my += (ty - my) * 0.05;
                var sy = window.scrollY;
                for (var i = 0; i < stars.length; i++) {
                    var s = stars[i];
                    var tw = reduce ? 1 : 0.55 + 0.45 * Math.sin(t * 0.001 * s.speed + s.phase);
                    var x = s.x + mx * s.depth * 14;
                    var y = ((s.y - sy * s.depth * 0.06 + my * s.depth * 14) % h + h) % h;
                    ctx.beginPath();
                    ctx.arc(x, y, s.d ? s.r : s.r * size, 0, 6.283);
                    ctx.fillStyle = 'rgba(' + rgb + ',' + (s.a * tw * strength).toFixed(3) + ')';
                    ctx.fill();
                }
                if (!reduce) raf = requestAnimationFrame(draw);
            }

            function start() { if (!raf && !reduce) raf = requestAnimationFrame(draw); }
            function stop()  { if (raf) { cancelAnimationFrame(raf); raf = null; } }

            window.addEventListener('mousemove', function (e) {
                tx = (e.clientX / w - 0.5) * -1; ty = (e.clientY / h - 0.5) * -1;
            }, { passive: true });
            window.addEventListener('resize', function () { build(); if (reduce) draw(0); });
            document.addEventListener('visibilitychange', function () { document.hidden ? stop() : start(); });
            document.addEventListener('themechange', function () {
                var prev = dust; readTheme();
                if (dust !== prev) build();
                if (reduce) draw(0);
            });

            readTheme(); build();
            reduce ? draw(0) : start();
        })();

        /*NAVIGATION*/

        (function () {
            var root = document.documentElement;
            var header = document.getElementById('siteHeader');
            var menuBtn = document.getElementById('menuBtn');
            var menu = document.getElementById('mobileMenu');
            var toTop = document.getElementById('toTop');
            var ring = toTop ? toTop.querySelector('.ring circle') : null;
            var navList = document.querySelector('.nav-list');
            var indicator = document.querySelector('.nav-indicator');
            var links = document.querySelectorAll('[data-section]');
            var breakpoint = 960, circumference = 138.23;
            var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            var sections = [];
            document.querySelectorAll('.nav-list a').forEach(function (a) {
                var el = document.getElementById(a.dataset.section);
                if (el) sections.push(el);
            });

            var current = null, ticking = false;

            /* sliding underline in nav */
            function moveIndicator() {
                if (!indicator || !navList) return;
                var a = navList.querySelector('a.is-active');
                if (!a || window.innerWidth < breakpoint) { indicator.style.opacity = 0; return; }
                var pl = parseFloat(getComputedStyle(a).paddingLeft) || 0;
                indicator.style.width = (a.offsetWidth - pl * 2) + 'px';
                indicator.style.transform = 'translateX(' + (a.offsetLeft + pl) + 'px)';
                indicator.style.opacity = 1;
            }

            /*highlight current section*/
            function setActive(id) {
                if (id === current) return;
                current = id;
                links.forEach(function (a) {
                    var on = a.dataset.section === id;
                    a.classList.toggle('is-active', on);
                    if (on) a.setAttribute('aria-current', 'true'); else a.removeAttribute('aria-current');
                });
                moveIndicator();
            }

            /*one throttled scroll handler */
            function onScroll() {
                ticking = false;
                var y = window.scrollY;
                var max = root.scrollHeight - window.innerHeight;

                header.classList.toggle('is-scrolled', y > 20);
                if (toTop) toTop.classList.toggle('is-visible', y > 600);
                if (ring) ring.style.strokeDashoffset = circumference * (1 - (max > 0 ? Math.min(y / max, 1) : 0));

                if (!sections.length) return;
                var id = sections[0].id;
                sections.forEach(function (s) {
                    if (s.getBoundingClientRect().top <= window.innerHeight * 0.4) id = s.id;
                });
                if (window.innerHeight + y >= root.scrollHeight - 2) id = sections[sections.length - 1].id;
                setActive(id);
            }
            function requestTick() { if (!ticking) { ticking = true; requestAnimationFrame(onScroll); } }

            /* mobile menu*/
            function openMenu() {
                root.classList.add('menu-open');
                menuBtn.setAttribute('aria-expanded', 'true');
                menuBtn.setAttribute('aria-label', 'Close menu');
                var first = menu.querySelector('a');
                if (first) setTimeout(function () { first.focus({ preventScroll: true }); }, 60);
            }
            function closeMenu(returnFocus) {
                root.classList.remove('menu-open');
                menuBtn.setAttribute('aria-expanded', 'false');
                menuBtn.setAttribute('aria-label', 'Open menu');
                if (returnFocus) menuBtn.focus({ preventScroll: true });
            }
            menuBtn.addEventListener('click', function () {
                root.classList.contains('menu-open') ? closeMenu(false) : openMenu();
            });
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && root.classList.contains('menu-open')) closeMenu(true);
            });

            /*smooth jump for any in-page link */
            document.addEventListener('click', function (e) {
                var a = e.target.closest('a[href^="#"]');
                if (!a) return;
                var id = a.getAttribute('href').slice(1);
                var target = id && document.getElementById(id);
                if (!target) return;
                e.preventDefault();
                if (root.classList.contains('menu-open')) closeMenu(false);
                requestAnimationFrame(function () {
                    target.scrollIntoView({ behavior: reduce ? 'auto' : 'smooth', block: 'start' });
                    if (history.replaceState) history.replaceState(null, '', '#' + id);
                });
            });

            if (toTop) toTop.addEventListener('click', function () {
                window.scrollTo({ top: 0, behavior: reduce ? 'auto' : 'smooth' });
                if (history.replaceState) history.replaceState(null, '', location.pathname + location.search);
            });

            window.addEventListener('scroll', requestTick, { passive: true });
            window.addEventListener('resize', function () {
                if (window.innerWidth >= breakpoint && root.classList.contains('menu-open')) closeMenu(false);
                moveIndicator(); requestTick();
            });
            if (document.fonts && document.fonts.ready) document.fonts.ready.then(moveIndicator);

            onScroll();
        })();

        /* REVEAL fade-in when sections scroll into view*/
        
        (function () {
            var els = document.querySelectorAll('[data-inview]');
            if (!els.length) return;
            if (!('IntersectionObserver' in window)) { els.forEach(function (e) { e.classList.add('is-in'); }); return; }
            var io = new IntersectionObserver(function (entries) {
                entries.forEach(function (en) {
                    if (en.isIntersecting) { en.target.classList.add('is-in'); io.unobserve(en.target); }
                });
            }, { threshold: 0.15, rootMargin: '0px 0px -8% 0px' });
            els.forEach(function (e) { io.observe(e); });
        })();

        /*CODE HIGHLIGHT*/

        (function () {
            var splitWords = function (s) { return s.split(' '); };
            var keywords = {
                php: splitWords('abstract and array as break case catch class clone const continue declare default do echo else elseif empty extends final finally fn for foreach function global if implements include include_once instanceof interface isset list match namespace new or print private protected public require require_once return static switch throw trait try unset use var while yield true false null'),
                javascript: splitWords('async await break case catch class const continue default delete do else export extends finally for function if import in instanceof let new of return static super switch this throw try typeof var void while yield true false null undefined'),
                python: splitWords('and as assert async await break class continue def del elif else except finally for from global if import in is lambda not or pass raise return try while with yield True False None self'),
                java: splitWords('abstract boolean break byte case catch char class const continue default do double else enum extends final finally float for if implements import instanceof int interface long new package private protected public return short static super switch this throw throws try void while true false null String'),
                c: splitWords('auto break case char const continue default do double else enum extern float for goto if int long register return short signed sizeof static struct switch typedef union unsigned void volatile while NULL'),
                cpp: splitWords('auto bool break case catch char class const continue default delete do double else enum explicit false float for friend if inline int long namespace new nullptr operator private protected public return short signed sizeof static struct switch template this throw true try typedef typename union unsigned using virtual void while string std cout cin endl'),
                csharp: splitWords('abstract async await bool break case catch char class const continue default delegate do double else enum event false finally float for foreach if in int interface internal is lock long namespace new null object out override private protected public readonly ref return sealed short static string struct switch this throw true try using var virtual void while'),
                sql: splitWords('select from where insert into values update set delete create table alter drop index join inner left right outer on group by order having limit as and or not null primary key foreign references default distinct union count sum avg min max like in between'),
                css: [], html: []
            };
            var aliases = { js: 'javascript', node: 'javascript', 'c++': 'cpp', 'c#': 'csharp', cs: 'csharp', py: 'python', htm: 'html', mysql: 'sql' };
            var cache = {};

            function esc(s) { return s.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;'); }
            function span(cls, s) { return '<span class="tk-' + cls + '">' + esc(s) + '</span>'; }

            function build(lang) {
                var cm = {
                    php: '\\/\\*[\\s\\S]*?\\*\\/|\\/\\/[^\\n]*|#[^\\n]*', python: '#[^\\n]*', sql: '--[^\\n]*|\\/\\*[\\s\\S]*?\\*\\/',
                    css: '\\/\\*[\\s\\S]*?\\*\\/', html: '<!--[\\s\\S]*?-->'
                }[lang] || '\\/\\*[\\s\\S]*?\\*\\/|\\/\\/[^\\n]*';
                var str = '"(?:\\\\.|[^"\\\\\\n])*"|\'(?:\\\\.|[^\'\\\\\\n])*\'' + (lang === 'javascript' ? '|`(?:\\\\.|[^`\\\\])*`' : '');
                var tag = lang === 'html' ? '<\\/?[A-Za-z][\\w-]*|\\/?>' : '(?!)';
                var src = '(' + cm + ')|(' + str + ')|(' + tag + ')|(\\b\\d+(?:\\.\\d+)?\\b)|(\\$[A-Za-z_]\\w*)|([A-Za-z_][\\w-]*)';
                return new RegExp(src, 'g');
            }

            window.highlightCode = function (text, language) {
                var lang = String(language || '').toLowerCase();
                lang = aliases[lang] || lang;
                if (!(lang in keywords)) return esc(text);
                var re = cache[lang] || (cache[lang] = build(lang));
                var words = {}, ci = lang === 'sql';
                keywords[lang].forEach(function (w) { words[ci ? w.toLowerCase() : w] = 1; });

                var out = '', last = 0, m;
                re.lastIndex = 0;
                while ((m = re.exec(text)) !== null) {
                    if (m[0] === '') { re.lastIndex++; continue; }
                    out += esc(text.slice(last, m.index));
                    if (m[1])      out += span('c', m[0]);
                    else if (m[2]) out += span('s', m[0]);
                    else if (m[3]) out += span('k', m[0]);
                    else if (m[4]) out += span('n', m[0]);
                    else if (m[5]) out += span('v', m[0]);
                    else if (words[ci ? m[6].toLowerCase() : m[6]]) out += span('k', m[0]);
                    else if (text.charAt(re.lastIndex) === '(') out += span('f', m[0]);
                    else out += esc(m[0]);
                    last = re.lastIndex;
                }
                return out + esc(text.slice(last));
            };
        })();

        /*VIEWER  - the shared zoom window*/

        (function () {
            var root = document.documentElement;
            var box = document.getElementById('lightbox');
            if (!box) return;
            function $(id) { return document.getElementById(id); }
            var el = {
                title: $('lbTitle'), counter: $('lbCounter'), stage: $('lbStage'), media: $('lbMedia'), caption: $('lbCaption'),
                prev: $('lbPrev'), next: $('lbNext'), thumbs: $('lbThumbs'), code: $('lbCode'), codeName: $('lbCodeName'),
                codeLang: $('lbCodeLang'), codeBody: $('lbCodeBody'), lock: $('lbLock'),
                sw: $('lbSwitch'), swLabel: $('lbSwLabel'), close: $('lbClose')
            };
            var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            var st = { items: [], i: 0, code: null, view: 'images', opener: null, title: '' };
            box.inert = true;

            function initials(t) {
                var w = String(t || '').trim().split(/\s+/);
                return ((w[0] || '').charAt(0) + (w.length > 1 ? w[w.length - 1].charAt(0) : '')).toUpperCase();
            }
            function node(item, big) {
                if (item.src) {
                    var img = new Image();
                    img.src = item.src; img.alt = item.alt || ''; img.draggable = false;
                    return img;
                }
                var d = document.createElement('div'); d.className = 'ph';
                var s = document.createElement('strong'); s.textContent = initials(item.title || st.title); d.appendChild(s);
                if (big) { var p = document.createElement('span'); p.textContent = 'No image added yet'; d.appendChild(p); }
                return d;
            }

            /* images */
            function render(i) {
                var n = st.items.length;
                    st.i = (i + n) % n;
                var item = st.items[st.i];
                    el.title.textContent = item.title || st.title;
                    el.media.replaceChildren(node(item, true));
                    /* caption = optional bold label + a sentence about what is shown and what can be done */
                    el.caption.replaceChildren();
                    if (item.label) { var lab = document.createElement('strong'); lab.textContent = item.label; el.caption.appendChild(lab); }
                    if (item.caption) el.caption.appendChild(document.createTextNode(item.caption));
                    el.caption.hidden = !(item.label || item.caption) || st.view === 'code';
                    box.toggleAttribute('data-has-caption', !!(item.label || item.caption));
                    el.counter.textContent = n > 1 ? (st.i + 1) + ' / ' + n : '';
                Array.prototype.forEach.call(el.thumbs.children, function (b, k) {
                    var on = k === st.i;
                        b.classList.toggle('is-active', on);
                        if (on) { b.setAttribute('aria-current', 'true'); b.scrollIntoView({ inline: 'center', block: 'nearest', behavior: reduce ? 'auto' : 'smooth' }); }
                            else b.removeAttribute('aria-current');
                });
                [st.i - 1, st.i + 1].forEach(function (k) { var it = st.items[(k + n) % n]; if (it && it.src) new Image().src = it.src; });
            }
            function go(i, animate) {
                if (!animate || reduce) return render(i);
                    el.media.classList.add('is-swapping');
                setTimeout(function () { render(i); el.media.classList.remove('is-swapping'); }, 160);
            }
            function buildThumbs() {
                el.thumbs.replaceChildren();
                    if (st.items.length < 2) return;
                        st.items.forEach(function (item, k) {
                            var b = document.createElement('button');
                                b.type = 'button'; b.className = 'lb-thumb'; b.setAttribute('aria-label', 'Show ' + (item.label || 'image ' + (k + 1)));
                                b.appendChild(node(item, false));
                                b.addEventListener('click', function () { go(k, true); });
                                el.thumbs.appendChild(b);
                    });
            }

            /* code */
            function renderCode() {
                var c = st.code;
                if (!c) return;
                el.codeName.textContent = c.name || '';
                el.codeLang.textContent = c.lang ? String(c.lang).toUpperCase() : '';
                var fmt = function (t) { return window.highlightCode ? window.highlightCode(t, c.lang) : t.replace(/&/g, '&amp;').replace(/</g, '&lt;'); };
                /* The last 3 lines are shown blurred and fading out*/
                var lines = String(c.text || '').split('\n'), fadeLines = 3, html;
                if (lines.length > fadeLines + 2) {
                    html = fmt(lines.slice(0, -fadeLines).join('\n'));
                    lines.slice(-fadeLines).forEach(function (ln, k) {
                        html += '<span class="cl-fade cl-fade-' + (k + 1) + '" aria-hidden="true">' + fmt(ln) + '</span>';
                    });
                } else {
                    html = fmt(lines.join('\n'));
                }
                el.codeBody.innerHTML = '<code>' + html + '</code>';
            }

            /* view switch */
            function setView(v) {
                st.view = v;
                var inCode = v === 'code', multi = st.items.length > 1;
                box.setAttribute('data-view', v);
                el.stage.hidden = inCode;
                el.code.hidden = !inCode;
                el.thumbs.hidden = inCode || !multi;
                el.counter.hidden = inCode || !multi;
                el.prev.hidden = el.next.hidden = !multi;
                el.caption.hidden = inCode || !el.caption.textContent;
                el.sw.hidden = !st.code;
                el.swLabel.textContent = inCode ? 'View images' : 'View code';
            }
            el.sw.addEventListener('click', function () { setView(st.view === 'code' ? 'images' : 'code'); });
            el.prev.addEventListener('click', function () { go(st.i - 1, true); });
            el.next.addEventListener('click', function () { go(st.i + 1, true); });

            /* open / close */
            function open(o) {
                st.title = o.title || '';
                st.items = (o.items && o.items.length) ? o.items : [{ src: null }];
                st.code = o.code || null;
                st.opener = document.activeElement;
                el.title.textContent = st.title;
                buildThumbs(); renderCode();
                setView(o.view === 'code' && st.code ? 'code' : 'images');
                render(o.index || 0);
                box.inert = false;
                box.classList.add('is-open');
                root.classList.add('lb-open');
                setTimeout(function () { el.close.focus({ preventScroll: true }); }, 30);
            }
            function close(restoreFocus) {
                if (!box.classList.contains('is-open')) return;
                box.classList.remove('is-open');
                root.classList.remove('lb-open');
                box.inert = true;
                if (restoreFocus !== false && st.opener && st.opener.focus) st.opener.focus({ preventScroll: true });
            }
            box.addEventListener('click', function (e) {
                var c = e.target.closest('[data-lb-close]');
                if (!c) return;
                var toContact = c.hasAttribute('data-lb-contact');
                close(!toContact);
                /* "Contact me for the full code": tell the contact form which project this is about */
                if (toContact) document.dispatchEvent(new CustomEvent('portfolio:contact', { detail: { project: st.title } }));
            });

            /* keyboard + swipe */
            document.addEventListener('keydown', function (e) {
                if (!box.classList.contains('is-open')) return;
                if (e.key === 'Escape') { close(); return; }
                if (st.view === 'images' && st.items.length > 1) {
                    if (e.key === 'ArrowLeft') { go(st.i - 1, true); return; }
                    if (e.key === 'ArrowRight') { go(st.i + 1, true); return; }
                }
                if (e.key === 'Tab') {   // keep keyboard focus inside the viewer
                    var f = Array.prototype.filter.call(box.querySelectorAll('button, a[href], pre[tabindex]'), function (n) { return n.getClientRects().length; });
                    if (!f.length) return;
                    var first = f[0], last = f[f.length - 1];
                    if (e.shiftKey && document.activeElement === first) { e.preventDefault(); last.focus(); }
                    else if (!e.shiftKey && document.activeElement === last) { e.preventDefault(); first.focus(); }
                }
            });
            var x0 = null;
            el.stage.addEventListener('touchstart', function (e) { x0 = e.touches[0].clientX; }, { passive: true });
            el.stage.addEventListener('touchend', function (e) {
                if (x0 === null || st.items.length < 2) return;
                var dx = e.changedTouches[0].clientX - x0; x0 = null;
                if (Math.abs(dx) > 50) go(st.i + (dx < 0 ? 1 : -1), true);
            }, { passive: true });

            window.Lightbox = { open: open, close: close };
        })();

        /* PROJECTS  - opens the viewer + hover slideshow */

        /* Opens the shared viewer from a project card (Zoom, thumbnail, or View Code). */
        (function () {
            document.addEventListener('click', function (e) {
                var btn = e.target.closest('.project [data-open]');
                if (!btn || !window.Lightbox) return;
                var card = btn.closest('.project'), data;
                try { data = JSON.parse(card.getAttribute('data-project')); } catch (err) { return; }
                window.Lightbox.open({ title: data.title, items: data.items, code: data.code, view: btn.getAttribute('data-open') });
            });
        })();

        /* Full description */
        (function () {
            var canHover = window.matchMedia('(hover: hover) and (pointer: fine)').matches;

            document.querySelectorAll('.project').forEach(function (card) {
                var btn = card.querySelector('.project-more'), peek = card.querySelector('.project-peek');
                if (!btn || !peek) return;
                var actions = card.querySelector('.project-actions'), body = peek.querySelector('.pp-body'), x = peek.querySelector('.pp-close'), closeTimer = null;
                card.classList.add('pp-on');  
                peek.inert = true;

                function open() {
                    clearTimeout(closeTimer);
                    if (card.classList.contains('is-peek')) return;
                    peek.style.bottom = (actions ? actions.offsetHeight : 0) + 'px';   // leave the buttons row uncovered
                    peek.inert = false;
                    card.classList.add('is-peek');
                    btn.setAttribute('aria-expanded', 'true');
                    body.scrollTop = 0;
                }
                function close(returnFocus) {
                    clearTimeout(closeTimer);
                    if (!card.classList.contains('is-peek')) return;
                    card.classList.remove('is-peek');
                    peek.inert = true;
                    btn.setAttribute('aria-expanded', 'false');
                    if (returnFocus) btn.focus({ preventScroll: true });
                }

                btn.addEventListener('click', function () { card.classList.contains('is-peek') ? close() : open(); });
                x.addEventListener('click', function () { close(true); });
                if (canHover) {
                    btn.addEventListener('mouseenter', open);
                    card.addEventListener('mouseleave', function () { closeTimer = setTimeout(close, 160); });
                    card.addEventListener('mouseenter', function () { clearTimeout(closeTimer); });
                    /* moving on to Explore System or View Code closes it */
                    card.querySelectorAll('.project-actions .btn').forEach(function (b) {
                        if (b !== btn) b.addEventListener('mouseenter', function () { close(); });
                    });
                }
                card.addEventListener('keydown', function (e) { if (e.key === 'Escape') close(true); });
                window.addEventListener('resize', function () { close(); });
            });

            /* touch closes an open description */
            document.addEventListener('click', function (e) {
                document.querySelectorAll('.project.is-peek').forEach(function (card) {
                    if (!card.contains(e.target)) { var x = card.querySelector('.pp-close'); if (x) x.click(); }
                });
            });
        })();

        /* Hover slideshow */
        (function () {
            if (!window.matchMedia('(hover: hover) and (pointer: fine)').matches) return;
            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

            var firstDelay = 700;    // wait before the first change (ms)
            var slideDelay = 1600;  // time each image stays (ms)

            document.querySelectorAll('.project').forEach(function (card) {
                var thumb = card.querySelector('.project-thumb');
                var base = thumb && thumb.querySelector('img');
                if (!base) return;

                var data;
                try { data = JSON.parse(card.getAttribute('data-project')); } catch (err) { return; }
                var baseSrc = base.getAttribute('src');
                var srcs = (data.items || []).map(function (i) { return i.src; })
                    .filter(function (s) { return s && s !== baseSrc; });
                if (!srcs.length) return;

                var slides = null, dots = null, idx = 0, timer = null, built = false;

                function build() {
                    if (built) return;
                    built = true;
                    slides = [base];
                    srcs.forEach(function (src) {
                        var img = new Image();
                        img.className = 'slide';
                        img.alt = '';
                        img.decoding = 'async';
                        img.src = src;
                        base.insertAdjacentElement('afterend', img);
                        slides.push(img);
                    });
                    dots = document.createElement('span');
                    dots.className = 'thumb-dots';
                    dots.setAttribute('aria-hidden', 'true');
                    slides.forEach(function () { dots.appendChild(document.createElement('i')); });
                    thumb.appendChild(dots);
                }

                function show(n) {
                    idx = n % slides.length;
                    slides.forEach(function (el, i) { if (i) el.classList.toggle('is-on', i === idx); });
                    Array.prototype.forEach.call(dots.children, function (d, i) { d.classList.toggle('on', i === idx); });
                }

                function inCarouselSide() { return card.closest('.pdof') && !card.classList.contains('is-active'); }   // side cards of the carousel stay still

                function tick() {
                    if (inCarouselSide()) { stop(); return; }
                    show(idx + 1); timer = setTimeout(tick, slideDelay);
                }

                function start() {
                    if (inCarouselSide()) return;
                    build();
                    if (timer) return;
                    thumb.classList.add('is-playing');
                    show(0);
                    timer = setTimeout(tick, firstDelay);
                }

                function stop() {
                    if (!built) return;
                    clearTimeout(timer); timer = null;
                    thumb.classList.remove('is-playing');
                    show(0);
                }

                card.addEventListener('mouseenter', start);
                card.addEventListener('mouseleave', stop);
                card.addEventListener('focusin', start);
                card.addEventListener('focusout', stop);
            });
        })();

        /*PROJECTS CAROUSEL */
        /* The project in the middle is sharp and full size.*/
        (function () {
            var root = document.querySelector('.pdof');
            if (!root) return;

            var track = root.querySelector('.pdof-track');
            var all = Array.prototype.slice.call(track.querySelectorAll('.project'));
            var numberText = root.querySelector('[data-pdof-no]');
            var dotsBox = root.querySelector('[data-pdof-dots]');
            var captionBox = root.querySelector('.dof-caption');
            var prevBtn = root.querySelector('.pdof-prev');
            var nextBtn = root.querySelector('.pdof-next');
            var n = all.length;
            var active = 0;

            /* How each step away from the middle looks. Index 0 = the middle project.
            Add numbers to show more projects on each side (they only show if there are enough projects). */
            var scales = [1, 0.84, 0.7];
            var blurs  = [0, 3, 6];
            var fades  = [1, 0.7, 0.45];
            var gap = 26;                                   // space between projects in px

            function pad(v) { return v < 10 ? '0' + v : '' + v; }

            // dots (one per project, click to jump)
            var dots = all.map(function (p, i) {
                var d = document.createElement('button');
                d.type = 'button';
                d.setAttribute('aria-label', 'Show project ' + (i + 1));
                d.addEventListener('click', function () { go(i); });
                dotsBox.appendChild(d);
                return d;
            });

            function layout() {
                if (!n) return;
                var w = all[0].offsetWidth || 400;
                var maxSide = Math.min(scales.length - 1, Math.floor((n - 1) / 2));   // 4 projects => 1 on each side, 5+ => 2

                var x = [0];
                for (var d = 1; d < scales.length; d++) {
                    x.push(x[d - 1] + w * scales[d - 1] / 2 + gap + w * scales[d] / 2);
                }

                all.forEach(function (p, i) {
                    var o = i - active;
                    if (o > n / 2) o -= n; else if (o < -n / 2) o += n;
                    var dist = Math.abs(o);
                    var far = dist > maxSide;
                    var step = far ? maxSide : dist;
                    var side = o < 0 ? -1 : 1;

                    // a description that is open on a project leaving the middle closes first
                    if (dist !== 0 && p.classList.contains('is-peek')) {
                        var closeBtn = p.querySelector('.pp-close');
                        if (closeBtn) closeBtn.click();
                    }

                    p.style.transform = 'translateX(' + (side * x[step]).toFixed(1) + 'px) scale(' + scales[step] + ')';
                    p.style.filter = 'blur(' + blurs[step] + 'px) brightness(' + (1 - step * 0.1).toFixed(2) + ')';
                    p.style.opacity = far ? 0 : fades[step];
                    p.style.visibility = far ? 'hidden' : 'visible';
                    p.style.zIndex = 20 - step;
                    p.classList.toggle('is-active', dist === 0);

                    // only the middle project can be used with the keyboard / read by screen readers
                    Array.prototype.forEach.call(p.children, function (c) { c.inert = dist !== 0; });
                    if (dist === 0) p.setAttribute('aria-current', 'true'); else p.removeAttribute('aria-current');
                });

                numberText.textContent = 'No. ' + pad(active + 1) + ' / ' + pad(n);
                dots.forEach(function (d, i) {
                    d.classList.toggle('on', i === active);
                    if (i === active) d.setAttribute('aria-current', 'true'); else d.removeAttribute('aria-current');
                });
                prevBtn.hidden = nextBtn.hidden = n < 2;
                swapCaption();
            }

            function swapCaption() {
                if (!captionBox || !root.classList.contains('pdof-run')) return;
                captionBox.classList.remove('is-swap');
                void captionBox.offsetWidth;               // restart the animation
                captionBox.classList.add('is-swap');
            }

            function go(to) {
                if (n < 2) return;
                active = ((to % n) + n) % n;
                layout();
            }

            prevBtn.addEventListener('click', function () { go(active - 1); });
            nextBtn.addEventListener('click', function () { go(active + 1); });

            root.addEventListener('keydown', function (e) {
                if (e.target.closest('input, textarea')) return;
                if (e.key === 'ArrowLeft') { e.preventDefault(); go(active - 1); }
                else if (e.key === 'ArrowRight') { e.preventDefault(); go(active + 1); }
                else if (e.key === 'Home') { e.preventDefault(); go(0); }
                else if (e.key === 'End') { e.preventDefault(); go(n - 1); }
            });

            /* Swipe / drag */
            var startX = null, startY = null, dragged = false;
            root.addEventListener('pointerdown', function (e) {
                if (e.pointerType === 'mouse' && e.button !== 0) return;
                if (e.target.closest('.pp-body, .dof-nav, .pdof-dots')) return;   // scrolling a description or pressing arrows is not a swipe
                startX = e.clientX; startY = e.clientY;
            });
            window.addEventListener('pointerup', function (e) {
                if (startX === null) return;
                var dx = e.clientX - startX, dy = e.clientY - startY;
                startX = null;
                if (Math.abs(dx) > 55 && Math.abs(dx) > Math.abs(dy) * 1.4) {
                    dragged = true;                                  // so the click that follows is ignored
                    setTimeout(function () { dragged = false; }, 80);
                    go(active + (dx < 0 ? 1 : -1));
                }
            });
            window.addEventListener('pointercancel', function () { startX = null; });

            /* Clicking a side project brings it to the middle */
            track.addEventListener('click', function (e) {
                var card = e.target.closest('.project');
                if (!card) return;
                if (dragged) { e.preventDefault(); e.stopPropagation(); return; }
                var i = all.indexOf(card);
                if (i !== active) { e.preventDefault(); e.stopPropagation(); go(i); }
            }, true);

            var waiting = false;
            window.addEventListener('resize', function () {
                if (waiting) return;
                waiting = true;
                requestAnimationFrame(function () { waiting = false; layout(); });
            });

            /* Start: place the projects first, then switch the smooth movement on */
            root.classList.add('pdof-ready');
            layout();
            requestAnimationFrame(function () { requestAnimationFrame(function () { root.classList.add('pdof-run'); }); });
        })();

        /* VISUAL CONTENT  - depth-of-field carousel + category filter */

        /* Controls: arrow buttons, left/right keys, or swipe/drag. Click the middle photo to open the viewer. */
        (function () {
            var root = document.querySelector('.dof');
            if (!root) return;

            var track = root.querySelector('.dof-track');
            var all = Array.prototype.slice.call(track.querySelectorAll('.photo'));
            var filters = document.querySelectorAll('.photo-filter');
            var numberText = root.querySelector('[data-dof-no]');
            var titleText = root.querySelector('[data-dof-title]');
            var categoryText = root.querySelector('[data-dof-categories]');
            var prevBtn = root.querySelector('.dof-prev');
            var nextBtn = root.querySelector('.dof-next');

            var list = all.slice();     // the photos currently shown 
            var filterTimer = null;
            var active = 0;             // which one is in the middle

            /* How each step away from the middle looks. Index 0 = the middle photo.
            Add or remove numbers to show more or fewer photos on each side. */
            var scales  = [1, 0.82, 0.66, 0.52, 0.42, 0.34];   // size
            var blurs   = [0, 2.5, 5, 7.5, 9, 10];             // blur
            var fades   = [1, 0.85, 0.62, 0.42, 0.28, 0.18];   // opacity
            var gap = 14;                                      // space between photos in px

            function pad(n) { return n < 10 ? '0' + n : '' + n; }
            function parse(p) { try { return JSON.parse(p.getAttribute('data-photo')); } catch (err) { return { src: null }; } }

            function layout() {
                var n = list.length;
                if (!n) return;
                var w = list[0].offsetWidth || 300;

                // distance from the middle to the centre of each step
                var x = [0];
                for (var d = 1; d < scales.length; d++) {
                    x.push(x[d - 1] + w * scales[d - 1] / 2 + gap + w * scales[d] / 2);
                }
                var last = scales.length - 1;

                list.forEach(function (p, i) {
                    var o = i - active;                         // steps from the middle (wraps around)
                    if (o > n / 2) o -= n; else if (o < -n / 2) o += n;
                    var dist = Math.abs(o);
                    var far = dist > last;
                    var step = far ? last : dist;
                    var side = o < 0 ? -1 : 1;

                    p.style.transform = 'translateX(' + (side * x[step]).toFixed(1) + 'px) scale(' + scales[step] + ')';
                    p.style.filter = 'blur(' + blurs[step] + 'px) brightness(' + (1 - step * 0.07).toFixed(2) + ')';
                    p.style.opacity = far ? 0 : fades[step];
                    p.style.visibility = far ? 'hidden' : 'visible';
                    p.style.zIndex = 20 - step;
                    p.style.setProperty('--step', step);          // used for the staggered movement when switching filters
                    p.removeAttribute('aria-hidden');
                    p.classList.toggle('is-active', dist === 0);

                    var btn = p.querySelector('.photo-btn');
                    btn.tabIndex = dist === 0 ? 0 : -1;
                    if (dist === 0) p.setAttribute('aria-current', 'true'); else p.removeAttribute('aria-current');

                    if (dist <= 3) {                            // make sure nearby photos are loaded
                        var img = p.querySelector('img');
                        if (img && img.loading === 'lazy') img.loading = 'eager';
                    }
                });

                // Photos that are filtered out are NOT removed from the page (display:none cannot be animated).
                // They shrink, blur and fade into the middle, and fan back out when their category comes back.
                all.forEach(function (p) {
                    if (list.indexOf(p) !== -1) return;
                    p.style.transform = 'translateX(0px) scale(.5)';
                    p.style.filter = 'blur(12px) brightness(.8)';
                    p.style.opacity = 0;
                    p.style.visibility = 'hidden';
                    p.style.zIndex = 0;
                    p.style.setProperty('--step', 0);
                    p.classList.remove('is-active');
                    p.removeAttribute('aria-current');
                    p.setAttribute('aria-hidden', 'true');
                    p.querySelector('.photo-btn').tabIndex = -1;
                });

                var current = parse(list[active]);
                numberText.textContent = 'No. ' + pad(active + 1) + ' / ' + pad(n);
                titleText.textContent = current.title || '';
                categoryText.textContent = list[active].getAttribute('data-categories') || '';
                prevBtn.hidden = nextBtn.hidden = n < 2;
                swapCaption();
            }

            /* Replay a small fade/slide on the caption every time the middle photo changes */
            var captionBox = root.querySelector('.dof-caption');
            function swapCaption() {
                if (!captionBox || !root.classList.contains('dof-run')) return;
                captionBox.classList.remove('is-swap');
                void captionBox.offsetWidth;            // restart the animation
                captionBox.classList.add('is-swap');
            }

            function go(to) {
                var n = list.length;
                if (n < 2) return;
                active = ((to % n) + n) % n;
                layout();
            }

            prevBtn.addEventListener('click', function () { go(active - 1); });
            nextBtn.addEventListener('click', function () { go(active + 1); });

            /* Keyboard: left and right arrows, Home, End */
            root.addEventListener('keydown', function (e) {
                if (e.key === 'ArrowLeft') { e.preventDefault(); go(active - 1); }
                else if (e.key === 'ArrowRight') { e.preventDefault(); go(active + 1); }
                else if (e.key === 'Home') { e.preventDefault(); go(0); }
                else if (e.key === 'End') { e.preventDefault(); go(list.length - 1); }
            });

            /* Swipe / drag */
            var startX = null, dragged = false;
            root.addEventListener('pointerdown', function (e) {
                if (e.pointerType === 'mouse' && e.button !== 0) return;
                startX = e.clientX;
            });
            window.addEventListener('pointerup', function (e) {
                if (startX === null) return;
                var dx = e.clientX - startX;
                startX = null;
                if (Math.abs(dx) > 45) {
                    dragged = true;                                   // so the click that follows is ignored
                    setTimeout(function () { dragged = false; }, 80);
                    go(active + (dx < 0 ? 1 : -1));
                }
            });
            window.addEventListener('pointercancel', function () { startX = null; });

            /* Click a side photo to bring it to the middle; click the middle photo to open the viewer */
            track.addEventListener('click', function (e) {
                if (dragged) return;
                var btn = e.target.closest('.photo-btn');
                if (!btn) return;
                var i = list.indexOf(btn.closest('.photo'));
                if (i < 0) return;
                if (i !== active) { go(i); return; }
                if (!window.Lightbox) return;
                window.Lightbox.open({ title: 'Visual Content', items: list.map(parse), index: i, view: 'images' });
            });

            /* Category filter */
            filters.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var cat = btn.getAttribute('data-filter');
                    filters.forEach(function (b) {
                        var on = b === btn;
                        b.classList.toggle('is-active', on);
                        b.setAttribute('aria-pressed', on ? 'true' : 'false');
                    });
                    list = all.filter(function (p) {
                        return cat === 'all' || p.getAttribute('data-categories') === cat;
                    });
                    active = 0;
                    root.classList.add('dof-filtering');        // staggers the movement so the photos fan in and out
                    layout();
                    clearTimeout(filterTimer);
                    filterTimer = setTimeout(function () { root.classList.remove('dof-filtering'); }, 1100);
                });
            });

            /* Re-measure when the window changes size (rotating a phone, resizing the browser) */
            var waiting = false;
            window.addEventListener('resize', function () {
                if (waiting) return;
                waiting = true;
                requestAnimationFrame(function () { waiting = false; layout(); });
            });

            /* Start: place the photos first, then switch the smooth movement on */
            root.classList.add('dof-ready');
            layout();
            requestAnimationFrame(function () { requestAnimationFrame(function () { root.classList.add('dof-run'); }); });
        })();

        /*CERTIFICATION */
        
        (function () {
            var list = document.querySelector('.cert-list');
            if (!list) return;
            var rows = Array.prototype.slice.call(list.querySelectorAll('.cert-row'));

            list.addEventListener('click', function (e) {
                var row = e.target.closest('.cert-row');
                if (!row || !window.Lightbox) return;
                var items = rows.map(function (r) {
                    try { return JSON.parse(r.getAttribute('data-cert')); } catch (err) { return { src: null }; }
                });
                window.Lightbox.open({ title: 'Certifications', items: items, index: rows.indexOf(row), view: 'images' });
            });
        })();

        /*CONTACT */

        /* Contact: builds the email links from the chosen intent + details. */
        (function () {
            var form = document.getElementById('contactForm');
            if (!form) return;

            var to = form.getAttribute('data-to') || '',
                details = document.getElementById('cDetails'),
                count = document.getElementById('cCount'),
                mail = document.getElementById('cMail'),
                gmail = document.getElementById('cGmail'),
                copy = document.getElementById('cCopy'),
                copyLabel = document.getElementById('cCopyLabel'),
                status = document.getElementById('cStatus'),
                radios = form.querySelectorAll('input[name="intent"]'),
                maxChars = 1500,
                project = '',                 // set when the visitor comes from a project's "Contact me for the full code"
                autoText = '';                // the text thats in the box

            function intent() {
                for (var i = 0; i < radios.length; i++) if (radios[i].checked) return radios[i];
                return radios[0];
            }
            function enc(s) { return encodeURIComponent(s); }

            function message() {
                var r = intent();
                var subject = r.getAttribute('data-subject') || 'Hello';
                if (project && r.value === 'fullCode') subject += ': ' + project;
                var body = details.value.trim() || r.getAttribute('data-starter') || '';
                return { subject: subject, body: body };
            }

            /* keep both links up to date, so a normal click, middle-click or "open in new tab" all just work */
            function refresh() {
                var m = message();
                mail.href = 'mailto:' + to + '?subject=' + enc(m.subject) + '&body=' + enc(m.body);
                gmail.href = 'https://mail.google.com/mail/?view=cm&fs=1&to=' + enc(to) + '&su=' + enc(m.subject) + '&body=' + enc(m.body);
                count.textContent = details.value.length + ' / ' + maxChars;
                count.classList.toggle('is-near', details.value.length > maxChars - 100);
            }

            function onIntent() {
                details.placeholder = intent().getAttribute('data-placeholder') || '';
                refresh();
            }
            radios.forEach(function (r) { r.addEventListener('change', onIntent); });
            details.addEventListener('input', refresh);
            onIntent();

            /* ----- copy ----- */
            function say(msg) {
                status.textContent = msg;
                copyLabel.textContent = msg;
                copy.classList.add('is-done');
                clearTimeout(say.t);
                say.t = setTimeout(function () { copyLabel.textContent = 'Copy details'; copy.classList.remove('is-done'); status.textContent = ''; }, 2000);
            }
            copy.addEventListener('click', function () {
                var m = message();
                var text = 'To: ' + to + '\nSubject: ' + m.subject + '\n\n' + m.body;
                function fallback() {
                    var t = document.createElement('textarea');
                    t.value = text; t.setAttribute('readonly', ''); t.style.cssText = 'position:fixed;top:0;left:-9999px';
                    document.body.appendChild(t); t.select();
                    var ok = false;
                    try { ok = document.execCommand('copy'); } catch (e) {}
                    document.body.removeChild(t);
                    say(ok ? 'Copied!' : 'Press Ctrl+C to copy');
                }
                if (navigator.clipboard && window.isSecureContext) {
                    navigator.clipboard.writeText(text).then(function () { say('Copied!'); }, fallback);
                } else { fallback(); }
            });

            /*"Contact me for the full code" */
            document.addEventListener('portfolio:contact', function (e) {
                var p = e.detail && e.detail.project;
                    if (!p) return;
                        project = p;
                            radios.forEach(function (r) { if (r.value === 'fullCode') r.checked = true; });
                                var text = 'Hi, I would like to see the full code for "' + p + '". ';
                                    if (!details.value.trim() || details.value === autoText) { details.value = text; autoText = text; }
                                        onIntent();
                setTimeout(function () {                      // after the page has scrolled down
                    details.focus({ preventScroll: true });
                        details.setSelectionRange(details.value.length, details.value.length);
                }, 800);
            });
            /* choosing another intent by hand drops the project name from the subject */
            radios.forEach(function (r) { r.addEventListener('change', function () { if (r.value !== 'fullCode') project = ''; refresh(); }); });
    })();
