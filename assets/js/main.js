/* ============================================================
   ЛАЗЕР · 7 — front-end behaviour (vanilla, no deps)
   Replaces the React prototype interactions 1:1:
   language toggle · mobile drawer · FAQ accordion ·
   portfolio filter + show-more + lightbox · quick contact ·
   scroll-to-top · testimonial video overlay.
   ============================================================ */
(function () {
  'use strict';

  function ready(fn) {
    if (document.readyState !== 'loading') fn();
    else document.addEventListener('DOMContentLoaded', fn);
  }

  ready(function () {
    var html = document.documentElement;

    /* ---------------- language toggle ---------------- */
    function currentLang() {
      var l = html.getAttribute('data-lang');
      return (l === 'en') ? 'en' : 'ua';
    }
    function setLang(l) {
      l = (l === 'en') ? 'en' : 'ua';
      html.setAttribute('data-lang', l);
      try { localStorage.setItem('laser7_lang', l); } catch (e) {}
      // active state on toggles
      document.querySelectorAll('[data-set-lang]').forEach(function (b) {
        b.classList.toggle('is-active', b.getAttribute('data-set-lang') === l);
      });
      // bilingual placeholders / titles via data-*-ua / data-*-en
      ['placeholder', 'title', 'aria-label'].forEach(function (attr) {
        document.querySelectorAll('[data-' + attr + '-ua]').forEach(function (el) {
          var v = el.getAttribute('data-' + attr + '-' + l);
          if (v !== null) el.setAttribute(attr, v);
        });
      });
    }
    document.querySelectorAll('[data-set-lang]').forEach(function (b) {
      b.addEventListener('click', function () { setLang(b.getAttribute('data-set-lang')); });
    });
    setLang(currentLang());

    /* ---------------- mobile drawer ------------------ */
    var menu = document.querySelector('[data-mobile-menu]');
    var burger = document.querySelector('[data-burger]');
    function openMenu(open) {
      if (!menu) return;
      menu.classList.toggle('is-open', open);
      if (burger) { burger.classList.toggle('is-open', open); burger.setAttribute('aria-expanded', open ? 'true' : 'false'); }
      document.body.style.overflow = open ? 'hidden' : '';
    }
    if (burger) burger.addEventListener('click', function () { openMenu(!menu.classList.contains('is-open')); });
    document.querySelectorAll('[data-menu-close]').forEach(function (el) {
      el.addEventListener('click', function () { openMenu(false); });
    });

    /* ---------------- FAQ accordion ------------------ */
    document.querySelectorAll('.faq-item .faq-q').forEach(function (q) {
      q.addEventListener('click', function () {
        var item = q.closest('.faq-item');
        var isOpen = item.classList.contains('open');
        document.querySelectorAll('.faq-item.open').forEach(function (o) { o.classList.remove('open'); });
        if (!isOpen) item.classList.add('open');
      });
    });

    /* ---------------- portfolio --------------------- */
    var pf = document.querySelector('[data-portfolio]');
    if (pf) {
      var PAGE = parseInt(pf.getAttribute('data-page'), 10) || 9;
      var grid = pf.querySelector('[data-grid]');
      var works = Array.prototype.slice.call(grid.querySelectorAll('.work'));
      var pills = Array.prototype.slice.call(pf.querySelectorAll('.cat-pill'));
      var emptyEl = pf.querySelector('[data-empty]');
      var moreWrap = pf.querySelector('[data-more]');
      var moreBtn = pf.querySelector('[data-more-btn]');
      var moreCount = moreBtn ? moreBtn.querySelector('.more-count') : null;
      var active = 'all';
      var visible = PAGE;
      var shown = [];

      function apply() {
        var matched = works.filter(function (w) {
          return active === 'all' || w.getAttribute('data-cat') === active;
        });
        shown = [];
        works.forEach(function (w) { w.hidden = true; });
        matched.forEach(function (w, i) {
          if (i < visible) { w.hidden = false; shown.push(w); }
        });
        if (emptyEl) emptyEl.hidden = matched.length !== 0;
        var remaining = matched.length - Math.min(visible, matched.length);
        if (moreWrap) moreWrap.hidden = remaining <= 0;
        if (moreCount) moreCount.textContent = '+' + Math.min(remaining, PAGE);
      }

      pills.forEach(function (p) {
        p.addEventListener('click', function () {
          pills.forEach(function (x) { x.classList.remove('is-active'); });
          p.classList.add('is-active');
          active = p.getAttribute('data-cat');
          visible = PAGE;
          apply();
        });
      });
      if (moreBtn) moreBtn.addEventListener('click', function () { visible += PAGE; apply(); });

      /* -------- lightbox (cycles through the shown set) -------- */
      var lb = pf.querySelector('[data-lb]');
      var lbMedia = lb.querySelector('[data-lb-media]');
      var lbCounter = lb.querySelector('[data-lb-counter]');
      var lbCat = lb.querySelector('[data-lb-cat]');
      var lbTitle = lb.querySelector('[data-lb-title]');
      var lbMat = lb.querySelector('[data-lb-mat]');
      var lbThumbs = lb.querySelector('[data-lb-thumbs]');
      var lbPrev = lb.querySelector('[data-lb-prev]');
      var lbNext = lb.querySelector('[data-lb-next]');
      var lbIndex = -1;

      function field(w, base) {
        var l = currentLang();
        return w.getAttribute('data-' + base + '-' + l) || w.getAttribute('data-' + base + '-ua') || '';
      }
      function renderLb() {
        if (lbIndex < 0 || lbIndex >= shown.length) return;
        var w = shown[lbIndex];
        var photo = w.getAttribute('data-photo');
        var video = w.getAttribute('data-video');
        var title = field(w, 'title');
        lbMedia.innerHTML = video
          ? '<video src="' + video + '" controls autoplay playsinline poster="' + (photo || '') + '"></video>'
          : '<img src="' + photo + '" alt="' + title.replace(/"/g, '&quot;') + '" />';
        lbCounter.textContent = (lbIndex + 1) + ' / ' + shown.length;
        lbCat.textContent = field(w, 'cat');
        lbTitle.textContent = title;
        lbMat.textContent = field(w, 'mat');
        var single = shown.length < 2;
        lbPrev.style.display = single ? 'none' : '';
        lbNext.style.display = single ? 'none' : '';
        // thumbnails
        lbThumbs.innerHTML = '';
        lbThumbs.style.display = single ? 'none' : '';
        shown.forEach(function (it, i) {
          var b = document.createElement('button');
          b.className = 'lb-thumb' + (i === lbIndex ? ' is-active' : '');
          b.innerHTML = '<img src="' + (it.getAttribute('data-photo') || '') + '" alt="" />';
          b.addEventListener('click', function (e) { e.stopPropagation(); lbIndex = i; renderLb(); });
          lbThumbs.appendChild(b);
        });
      }
      function openLb(i) {
        lbIndex = i;
        lb.classList.add('is-open');
        lb.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
        renderLb();
      }
      function closeLb() {
        lb.classList.remove('is-open');
        lb.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
        lbMedia.innerHTML = '';
      }
      function step(d) { if (shown.length) { lbIndex = (lbIndex + d + shown.length) % shown.length; renderLb(); } }

      works.forEach(function (w) {
        w.addEventListener('click', function () {
          var i = shown.indexOf(w);
          if (i >= 0) openLb(i);
        });
      });
      lb.querySelector('[data-lb-close]').addEventListener('click', closeLb);
      lbPrev.addEventListener('click', function (e) { e.stopPropagation(); step(-1); });
      lbNext.addEventListener('click', function (e) { e.stopPropagation(); step(1); });
      lb.addEventListener('click', function (e) {
        if (e.target === lb || e.target.classList.contains('lb-stage')) closeLb();
      });
      document.addEventListener('keydown', function (e) {
        if (!lb.classList.contains('is-open')) return;
        if (e.key === 'Escape') closeLb();
        else if (e.key === 'ArrowLeft') step(-1);
        else if (e.key === 'ArrowRight') step(1);
      });
      // re-render caption language when toggling lang while open
      document.querySelectorAll('[data-set-lang]').forEach(function (b) {
        b.addEventListener('click', function () { if (lb.classList.contains('is-open')) renderLb(); });
      });

      apply();
    }

    /* ---------------- quick contact ------------------ */
    var qc = document.querySelector('[data-qc]');
    var qcToggle = document.querySelector('[data-qc-toggle]');
    if (qc && qcToggle) {
      var chatHTML = qcToggle.innerHTML;
      qcToggle.addEventListener('click', function () {
        var open = !qc.classList.contains('is-open');
        qc.classList.toggle('is-open', open);
        qcToggle.innerHTML = open ? '<span style="font-size:1.4rem;line-height:1">×</span>' : chatHTML;
      });
    }

    /* ---------------- scroll to top ------------------ */
    var st = document.querySelector('[data-scrolltop]');
    if (st) {
      function onScroll() { st.classList.toggle('is-show', (window.scrollY || document.documentElement.scrollTop || 0) > 600); }
      window.addEventListener('scroll', onScroll, { passive: true });
      onScroll();
      st.addEventListener('click', function () { window.scrollTo({ top: 0, behavior: 'smooth' }); });
    }

    /* ---------------- testimonial video overlay ------ */
    document.querySelectorAll('[data-video-play]').forEach(function (btn) {
      btn.addEventListener('click', function (e) {
        e.preventDefault();
        var src = btn.getAttribute('data-video-play');
        if (!src) return;
        var ov = document.createElement('div');
        ov.className = 'l7-video-overlay';
        ov.innerHTML = '<button class="l7-vclose" aria-label="Close">×</button><video src="' + src + '" controls autoplay playsinline></video>';
        function close() { document.body.style.overflow = ''; if (ov.parentNode) ov.parentNode.removeChild(ov); }
        ov.addEventListener('click', function (ev) { if (ev.target === ov || ev.target.classList.contains('l7-vclose')) close(); });
        document.addEventListener('keydown', function esc(ev) { if (ev.key === 'Escape') { close(); document.removeEventListener('keydown', esc); } });
        document.body.appendChild(ov);
        document.body.style.overflow = 'hidden';
      });
    });

    /* ---------------- quick brief form → Telegram ---- */
    var qform = document.querySelector('[data-quick-form]');
    if (qform) {
      qform.addEventListener('submit', function (e) {
        e.preventDefault();
        var handle = qform.getAttribute('data-telegram') || '';
        var fd = new FormData(qform);
        var ua = currentLang() === 'ua';
        var msg = encodeURIComponent(
          (ua ? 'Запит' : 'Request') + ': ' + (fd.get('name') || '—') + ' (' + (fd.get('contact') || '—') + ')\n' + (fd.get('brief') || '')
        );
        window.open('https://t.me/' + handle + '?text=' + msg, '_blank');
      });
    }
  });
})();
