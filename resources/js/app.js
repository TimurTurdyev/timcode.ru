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
});
