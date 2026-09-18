document.addEventListener('DOMContentLoaded', () => {
    // Typewriter on hero title
    const title = document.querySelector('.hero-title[data-typewriter]');
    if (title) {
        const text = title.dataset.typewriter;
        title.innerHTML = '<span class="tw-cursor">█</span>';
        const cursor = title.querySelector('.tw-cursor');
        let i = 0;
        const tick = () => {
            if (i < text.length) {
                cursor.insertAdjacentText('beforebegin', text[i++]);
                setTimeout(tick, 55 + Math.random() * 30);
            } else {
                cursor.classList.add('tw-done');
            }
        };
        setTimeout(tick, 350);
    }

    // Scroll reveal for sections
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('revealed');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.08 });

    document.querySelectorAll('.section').forEach(el => observer.observe(el));

    // Просмотр кадров кейса во весь экран
    const shots = document.querySelectorAll('.case-shot[data-zoomable]');
    if (!shots.length) return;

    let box = null;

    const close = () => {
        if (!box) return;
        box.classList.remove('is-open');
        const node = box;
        box = null;
        document.body.style.overflow = '';
        setTimeout(() => node.remove(), 250);
    };

    const open = (src, caption) => {
        close();
        box = document.createElement('div');
        box.className = 'lightbox';
        box.innerHTML =
            '<button class="lightbox-close" aria-label="Закрыть">[ esc ]</button>' +
            '<img alt="">' +
            (caption ? '<div class="lightbox-caption"></div>' : '');
        box.querySelector('img').src = src;
        box.querySelector('img').alt = caption || '';
        if (caption) box.querySelector('.lightbox-caption').textContent = caption;
        document.body.appendChild(box);
        document.body.style.overflow = 'hidden';
        requestAnimationFrame(() => box.classList.add('is-open'));
        box.addEventListener('click', close);
    };

    shots.forEach(shot => {
        shot.addEventListener('click', () => {
            const img = shot.querySelector('img');
            if (!img) return;
            const caption = shot.parentElement?.querySelector('figcaption')?.textContent || '';
            open(img.currentSrc || img.src, caption.replace(/^\/\/\s*/, ''));
        });
    });

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') close();
    });
});
