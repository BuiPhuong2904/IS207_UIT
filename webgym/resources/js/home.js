// -- Mobile menu toggle --
document.addEventListener("DOMContentLoaded", function () {
    // --- Menu toggle ---
    const btn = document.getElementById("menu-btn");
    const menu = document.getElementById("mobile-menu");

    if (btn && menu) {
        btn.addEventListener("click", () => {
            if (menu.classList.contains("hidden")) {
                menu.classList.remove("hidden");
                menu.classList.add("flex");
                requestAnimationFrame(() => {
                    menu.classList.remove("scale-y-0", "opacity-0");
                    menu.classList.add("scale-y-100", "opacity-100");
                });
            } else {
                menu.classList.add("scale-y-0", "opacity-0");
                menu.classList.remove("scale-y-100", "opacity-100");
                setTimeout(() => {
                    menu.classList.add("hidden");
                    menu.classList.remove("flex");
                }, 300);
            }
        });
        menu.classList.add("scale-y-0", "opacity-0");
    }
});

// --- Lớp học nổi bật slider ---
document.addEventListener("DOMContentLoaded", () => {
    const slider = document.getElementById("slider");
    const nextBtn = document.getElementById("nextBtn");
    const prevBtn = document.getElementById("prevBtn");

    if (!slider || !nextBtn || !prevBtn) return;

    let currentSlide = 0;
    const totalCards = slider.children.length;
    const cardsPerView = 3;

    const updateSlider = () => {
        const card = slider.children[0];
        const gap = parseFloat(getComputedStyle(slider).gap) || 0;
        const slideWidth = card.offsetWidth + gap;
        slider.style.transform = `translateX(-${currentSlide * slideWidth}px)`;
    };

    const nextSlide = () => {
        if (currentSlide < totalCards - cardsPerView) currentSlide++;
        else currentSlide = 0;
        updateSlider();
    };

    const prevSlide = () => {
        if (currentSlide > 0) currentSlide--;
        else currentSlide = totalCards - cardsPerView;
        updateSlider();
    };

    nextBtn.addEventListener("click", nextSlide);
    prevBtn.addEventListener("click", prevSlide);

    // Auto-play
    let autoPlay = setInterval(nextSlide, 4000);
    slider.addEventListener("mouseenter", () => clearInterval(autoPlay));
    slider.addEventListener("mouseleave", () => {
        autoPlay = setInterval(nextSlide, 4000);
    });

    window.addEventListener("resize", updateSlider);
});
