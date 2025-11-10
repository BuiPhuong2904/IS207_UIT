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

// --- Reusable Carousel (Fade + Dot Fixed) ---
document.addEventListener("DOMContentLoaded", () => {

  // Hàm khởi tạo cho 1 carousel cụ thể
  function initCarousel(carouselId) {
    const carousel = document.getElementById(carouselId);
    if (!carousel) return;

    const slides = carousel.querySelectorAll("[data-carousel-item]");
    const nextBtn = carousel.querySelector("[data-carousel-next]");
    const prevBtn = carousel.querySelector("[data-carousel-prev]");
    const dots = carousel.querySelectorAll("[data-carousel-slide-to]");
    if (!slides.length) return;

    let currentIndex = 0;
    let autoPlayInterval;

    // Thêm CSS fade cho từng slide
    slides.forEach(slide => {
      slide.classList.add("opacity-0", "transition-opacity", "duration-1000");
    });

    // Hàm hiển thị slide
    function showSlide(index) {
      slides.forEach((slide, i) => {
        if (i === index) {
          slide.classList.remove("hidden");
          requestAnimationFrame(() => {
            slide.classList.remove("opacity-0");
            slide.classList.add("opacity-100");
          });
        } else {
          slide.classList.remove("opacity-100");
          slide.classList.add("opacity-0");
          setTimeout(() => {
            if (slide.classList.contains("opacity-0")) slide.classList.add("hidden");
          }, 1000);
        }
      });

      // Cập nhật dot
      dots.forEach((dot, i) => {
        if (i === index) {
          dot.classList.add("bg-white");
          dot.classList.remove("bg-white/50", "bg-gray-400");
        } else {
          dot.classList.add("bg-white/50");
          dot.classList.remove("bg-white", "bg-gray-400");
        }
      });

      currentIndex = index;
    }

    // Next / Prev
    const nextSlide = () => showSlide((currentIndex + 1) % slides.length);
    const prevSlide = () => showSlide((currentIndex - 1 + slides.length) % slides.length);

    if (nextBtn) nextBtn.addEventListener("click", nextSlide);
    if (prevBtn) prevBtn.addEventListener("click", prevSlide);
    dots.forEach((dot, index) => dot.addEventListener("click", () => showSlide(index)));

    // Auto play
    function startAutoPlay() {
      stopAutoPlay();
      autoPlayInterval = setInterval(nextSlide, 5000);
    }
    function stopAutoPlay() {
      if (autoPlayInterval) clearInterval(autoPlayInterval);
    }

    carousel.addEventListener("mouseenter", stopAutoPlay);
    carousel.addEventListener("mouseleave", startAutoPlay);

    // Init
    slides[0].classList.remove("hidden", "opacity-0");
    slides[0].classList.add("opacity-100");
    showSlide(currentIndex);
    startAutoPlay();
  }

    // --- Khởi tạo cho tất cả carousel ---
    initCarousel("banner-carousel");
    initCarousel("default-carousel");
    initCarousel("store-carousel");
});