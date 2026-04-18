document.addEventListener("DOMContentLoaded", () => {

  document.body.classList.add("loaded");

  /* =========================================
     SCROLL PROGRESS BAR
     ========================================= */
  const progressBar = document.createElement("div");
  progressBar.className = "scroll-progress";
  document.body.appendChild(progressBar);

  function updateProgress() {
    const scrollTop = window.scrollY;
    const docHeight = document.documentElement.scrollHeight - window.innerHeight;
    const progress = docHeight > 0 ? (scrollTop / docHeight) * 100 : 0;
    progressBar.style.width = progress + "%";
  }
  window.addEventListener("scroll", updateProgress, { passive: true });

  /* =========================================
     CUSTOM CURSOR
     ========================================= */
  if (window.innerWidth > 992) {
    const dot = document.createElement("div");
    dot.className = "cursor-dot";
    const ring = document.createElement("div");
    ring.className = "cursor-ring";
    document.body.appendChild(dot);
    document.body.appendChild(ring);

    let mouseX = 0, mouseY = 0;
    let ringX = 0, ringY = 0;

    document.addEventListener("mousemove", (e) => {
      mouseX = e.clientX;
      mouseY = e.clientY;
      dot.style.left = mouseX - 4 + "px";
      dot.style.top = mouseY - 4 + "px";
    });

    function animateRing() {
      ringX += (mouseX - ringX) * 0.15;
      ringY += (mouseY - ringY) * 0.15;
      ring.style.left = ringX - 18 + "px";
      ring.style.top = ringY - 18 + "px";
      requestAnimationFrame(animateRing);
    }
    animateRing();

    const hoverTargets = "a, button, .event-card, .activity-card, .stat-card, .news-card, .gallery-card, .branch-card, .value-card, .social-card, .collection-card, .graduate-card, .archive-item, .play-btn, input, select, textarea";
    document.querySelectorAll(hoverTargets).forEach((el) => {
      el.addEventListener("mouseenter", () => ring.classList.add("hover"));
      el.addEventListener("mouseleave", () => ring.classList.remove("hover"));
    });
  }

  /* =========================================
     RIPPLE EFFECT ON BUTTONS
     ========================================= */
  document.querySelectorAll(".event-btn, .submit-btn, .more-btn, .type-btn, .news-filter-btn, .social-tab, .archive-cat-btn, .newsletter-form button, .view-btn").forEach((btn) => {
    btn.classList.add("ripple-effect");
    btn.addEventListener("click", function(e) {
      const ripple = document.createElement("span");
      ripple.className = "ripple";
      const rect = this.getBoundingClientRect();
      const size = Math.max(rect.width, rect.height);
      ripple.style.width = ripple.style.height = size + "px";
      ripple.style.left = e.clientX - rect.left - size / 2 + "px";
      ripple.style.top = e.clientY - rect.top - size / 2 + "px";
      this.appendChild(ripple);
      setTimeout(() => ripple.remove(), 600);
    });
  });

  /* =========================================
     SCROLL ANIMATIONS (Intersection Observer)
     ========================================= */
  const animatedEls = document.querySelectorAll("[data-animate]");
  const animObserver = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          const el = entry.target;
          const delay = el.dataset.delay || 0;
          setTimeout(() => el.classList.add("animated"), parseInt(delay));
          animObserver.unobserve(el);
        }
      });
    },
    { rootMargin: "0px 0px -60px 0px", threshold: 0.15 }
  );
  animatedEls.forEach((el) => animObserver.observe(el));

  /* =========================================
     HEADER – sticky shadow & mobile toggle
     ========================================= */
  const header = document.getElementById("header");
  const mobileToggle = document.getElementById("mobileToggle");
  const navMenu = document.getElementById("navMenu");

  let lastScrollY = 0;
  window.addEventListener("scroll", () => {
    if (header) {
      header.classList.toggle("scrolled", window.scrollY > 50);
    }
    lastScrollY = window.scrollY;
  }, { passive: true });

  if (mobileToggle && navMenu) {
    mobileToggle.addEventListener("click", () => {
      navMenu.classList.toggle("active");
      mobileToggle.classList.toggle("active");
    });

    navMenu.querySelectorAll("a").forEach((link) => {
      link.addEventListener("click", () => {
        navMenu.classList.remove("active");
        mobileToggle.classList.remove("active");
      });
    });
  }

  /* =========================================
     HERO SLIDER
     ========================================= */
  const slider = document.querySelector(".hero-slider");
  const slides = document.querySelectorAll(".hero-slider .slide");
  const dotsContainer = document.querySelector(".slider-dots");

  if (slider && slides.length && dotsContainer) {
    let slideIndex = 0;
    let slideInterval;
    let touchStartX = 0;

    slides.forEach((_, i) => {
      const dot = document.createElement("span");
      if (i === 0) dot.classList.add("active");
      dotsContainer.appendChild(dot);
    });

    const dots = dotsContainer.querySelectorAll("span");

    function showSlide(i) {
      slides.forEach((s) => s.classList.remove("active"));
      dots.forEach((d) => d.classList.remove("active"));
      slides[i].classList.add("active");
      dots[i].classList.add("active");
    }

    function startSlider() {
      slideInterval = setInterval(() => {
        slideIndex = (slideIndex + 1) % slides.length;
        showSlide(slideIndex);
      }, 5000);
    }

    slider.addEventListener("mouseenter", () => clearInterval(slideInterval));
    slider.addEventListener("mouseleave", startSlider);

    dots.forEach((dot, i) => {
      dot.addEventListener("click", () => {
        slideIndex = i;
        showSlide(slideIndex);
      });
    });

    slider.addEventListener("touchstart", (e) => {
      touchStartX = e.touches[0].clientX;
    });
    slider.addEventListener("touchend", (e) => {
      const endX = e.changedTouches[0].clientX;
      if (touchStartX - endX > 50) slideIndex = (slideIndex + 1) % slides.length;
      if (endX - touchStartX > 50) slideIndex = (slideIndex - 1 + slides.length) % slides.length;
      showSlide(slideIndex);
    });

    startSlider();
  }

  /* =========================================
     EVENTS SLIDER (arrows)
     ========================================= */
  const eventCards = document.querySelectorAll(".events-row .event-card");
  const nextEventArrow = document.querySelector(".arrow.right");
  const prevEventArrow = document.querySelector(".arrow.left");

  if (eventCards.length) {
    let currentEvent = 0;

    function updateActiveEvent() {
      eventCards.forEach((card, i) => {
        card.classList.toggle("active", i === currentEvent);
      });
    }

    if (nextEventArrow) {
      nextEventArrow.addEventListener("click", () => {
        currentEvent = (currentEvent + 1) % eventCards.length;
        updateActiveEvent();
      });
    }

    if (prevEventArrow) {
      prevEventArrow.addEventListener("click", () => {
        currentEvent = (currentEvent - 1 + eventCards.length) % eventCards.length;
        updateActiveEvent();
      });
    }

    eventCards.forEach((card, i) => {
      card.addEventListener("click", (e) => {
        const btn = e.target.closest(".event-btn");
        if (btn) e.preventDefault();
        currentEvent = i;
        updateActiveEvent();
      });
    });

    updateActiveEvent();
  }

  /* =========================================
     MEDIA SHOWCASE – reveal animation
     ========================================= */
  const mediaWrapper = document.querySelector(".media-wrapper");
  if (mediaWrapper) {
    const mediaObs = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            mediaWrapper.classList.add("show");
            mediaObs.unobserve(mediaWrapper);
          }
        });
      },
      { threshold: 0.2 }
    );
    mediaObs.observe(mediaWrapper);
  }

  /* =========================================
     VIDEO MODAL
     ========================================= */
  const playBtn = document.querySelector(".play-btn");
  const videoModal = document.getElementById("videoModal");
  const videoFrame = document.getElementById("videoFrame");
  const videoCloseBtn = document.querySelector(".video-close");
  const videoOverlay = document.querySelector(".video-overlay");
  const videoURL = "https://www.youtube.com/embed/dQw4w9WgXcQ?autoplay=1";

  function closeVideoModal() {
    if (videoModal) videoModal.classList.remove("active");
    if (videoFrame) videoFrame.src = "";
  }

  if (playBtn) {
    playBtn.addEventListener("click", () => {
      if (videoFrame) videoFrame.src = videoURL;
      if (videoModal) videoModal.classList.add("active");
    });
  }
  if (videoCloseBtn) videoCloseBtn.addEventListener("click", closeVideoModal);
  if (videoOverlay) videoOverlay.addEventListener("click", closeVideoModal);

  /* =========================================
     ACTIVITY SLIDER
     ========================================= */
  const activityCards = document.querySelectorAll(".activity-card");
  const nextActBtn = document.querySelector(".arrow-activty.right");
  const prevActBtn = document.querySelector(".arrow-activty.left");

  if (activityCards.length) {
    let currentActivity = 0;

    function updateActivitySlider() {
      activityCards.forEach((card, i) => {
        card.classList.toggle("active", i === currentActivity);
      });
    }

    if (nextActBtn) {
      nextActBtn.addEventListener("click", () => {
        currentActivity = (currentActivity + 1) % activityCards.length;
        updateActivitySlider();
      });
    }

    if (prevActBtn) {
      prevActBtn.addEventListener("click", () => {
        currentActivity = (currentActivity - 1 + activityCards.length) % activityCards.length;
        updateActivitySlider();
      });
    }

    activityCards.forEach((card, i) => {
      card.addEventListener("click", () => {
        currentActivity = i;
        updateActivitySlider();
      });
    });
  }

  /* =========================================
     STAT COUNTER ANIMATION
     ========================================= */
  const statNumbers = document.querySelectorAll(".stat-number");

  function formatNum(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  }

  function easeOutExpo(t) {
    return t === 1 ? 1 : 1 - Math.pow(2, -10 * t);
  }

  function animateCounter(el) {
    const target = +el.dataset.target;
    const duration = 2200;
    const startTime = performance.now();

    function tick(now) {
      const elapsed = now - startTime;
      const progress = Math.min(elapsed / duration, 1);
      const current = Math.round(easeOutExpo(progress) * target);
      el.textContent = formatNum(current);
      if (progress < 1) requestAnimationFrame(tick);
    }

    requestAnimationFrame(tick);
  }

  const counterObs = new IntersectionObserver(
    (entries, obs) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          animateCounter(entry.target);
          obs.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.5 }
  );

  statNumbers.forEach((el) => counterObs.observe(el));

  /* =========================================
     GALLERY – dynamic grid + lightbox
     ========================================= */
  const galleryImages = [
    "img/library-image.png",
    "img/library-image.png",
    "img/library-image.png",
    "img/library-image.png",
    "img/library-image.png",
    "img/library-image.png",
    "img/library-image.png",
  ];

  const galleryGrid = document.getElementById("galleryGrid");
  const lightbox = document.getElementById("lightbox");
  const lightboxImg = document.getElementById("lightboxImg");
  const lightboxClose = document.querySelector(".lightbox .close");

  if (galleryGrid) {
    const textCell = document.createElement("div");
    textCell.className = "gallery-text grid-text";
    textCell.innerHTML = `
      <h2>تصفح مكتبة الصور</h2>
      <a class="gallery-more" href="#">مشاهدة المزيد</a>
    `;
    galleryGrid.appendChild(textCell);

    galleryImages.forEach((src, i) => {
      const card = document.createElement("div");
      card.className = "gallery-card";
      card.style.animationDelay = `${(i + 1) * 0.12}s`;

      const img = document.createElement("img");
      img.src = src;
      img.alt = "صورة من المكتبة";
      img.loading = "lazy";

      card.appendChild(img);
      galleryGrid.appendChild(card);

      card.addEventListener("click", () => {
        document.querySelectorAll(".gallery-card").forEach((c) => c.classList.remove("active"));
        card.classList.add("active");
        if (lightboxImg) lightboxImg.src = src;
        if (lightbox) lightbox.classList.add("show");
      });
    });
  }

  if (lightboxClose) {
    lightboxClose.addEventListener("click", () => lightbox.classList.remove("show"));
  }
  if (lightbox) {
    lightbox.addEventListener("click", (e) => {
      if (e.target === lightbox) lightbox.classList.remove("show");
    });
  }

  /* =========================================
     TYPE BUTTONS (form)
     ========================================= */
  const typeButtons = document.querySelectorAll(".type-btn");
  typeButtons.forEach((btn) => {
    btn.addEventListener("click", () => {
      typeButtons.forEach((b) => b.classList.remove("active"));
      btn.classList.add("active");
    });
  });

  /* =========================================
     SCROLL TO TOP
     ========================================= */
  const scrollTopBtn = document.getElementById("scrollTop");
  if (scrollTopBtn) {
    window.addEventListener("scroll", () => {
      scrollTopBtn.classList.toggle("visible", window.scrollY > 500);
    });
    scrollTopBtn.addEventListener("click", () => {
      window.scrollTo({ top: 0, behavior: "smooth" });
    });
  }

  /* =========================================
     CARD TILT EFFECT (magnetic hover)
     ========================================= */
  const tiltCards = document.querySelectorAll(
    ".event-card, .stat-card, .news-card, .wide-card"
  );

  tiltCards.forEach((card) => {
    card.addEventListener("mousemove", (e) => {
      const rect = card.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;
      const centerX = rect.width / 2;
      const centerY = rect.height / 2;
      const rotateX = (y - centerY) / 30;
      const rotateY = (centerX - x) / 30;
      card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-6px)`;
    });

    card.addEventListener("mouseleave", () => {
      card.style.transition = "transform 0.5s cubic-bezier(0.4, 0, 0.2, 1)";
      card.style.transform = "";
      setTimeout(() => { card.style.transition = ""; }, 500);
    });
  });

  /* =========================================
     MULTI-LAYER PARALLAX
     ========================================= */
  const heroSection = document.querySelector(".hero-image");
  const landmarkImg = document.querySelector(".landmark-image img");
  const topOrnament = document.querySelector(".top-ornament");

  window.addEventListener("scroll", () => {
    const scrolled = window.scrollY;
    if (heroSection && scrolled < 800) {
      heroSection.style.transform = `translateY(${scrolled * 0.12}px)`;
    }
    if (topOrnament && scrolled < 400) {
      topOrnament.style.transform = `translateY(${scrolled * 0.08}px)`;
      topOrnament.style.opacity = Math.max(1 - scrolled / 400, 0.3);
    }
    if (landmarkImg) {
      const rect = landmarkImg.getBoundingClientRect();
      if (rect.top < window.innerHeight && rect.bottom > 0) {
        const offset = (window.innerHeight - rect.top) * 0.04;
        landmarkImg.style.transform = `translateY(${-offset}px)`;
      }
    }
  }, { passive: true });

  /* =========================================
     SMOOTH REVEAL FOR BREAKING NEWS
     ========================================= */
  const breakingEl = document.querySelector(".breaking");
  if (breakingEl) {
    breakingEl.style.opacity = "0";
    breakingEl.style.transform = "translateY(10px)";
    setTimeout(() => {
      breakingEl.style.transition = "opacity 0.8s ease, transform 0.8s ease";
      breakingEl.style.opacity = "1";
      breakingEl.style.transform = "translateY(0)";
    }, 300);
  }

  /* =========================================
     FORM INPUT FOCUS LABELS
     ========================================= */
  document.querySelectorAll(".field input, .field select").forEach((input) => {
    input.addEventListener("focus", () => {
      const field = input.closest(".field");
      if (field) {
        field.style.transform = "translateY(-2px)";
        field.style.transition = "transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275)";
      }
    });
    input.addEventListener("blur", () => {
      const field = input.closest(".field");
      if (field) field.style.transform = "";
    });
  });

  /* =========================================
     WHATSAPP BOX HOVER EFFECT
     ========================================= */
  const waBox = document.querySelector(".whatsapp-box");
  if (waBox) {
    waBox.addEventListener("mouseenter", () => {
      const img = waBox.querySelector("img");
      if (img) img.style.transform = "scale(1.2) rotate(-10deg)";
    });
    waBox.addEventListener("mouseleave", () => {
      const img = waBox.querySelector("img");
      if (img) img.style.transform = "";
    });
  }

  /* =========================================
     MAGNETIC HOVER ON ARROWS
     ========================================= */
  document.querySelectorAll(".arrow, .arrow-activty, .nav-arrow, .scroll-top").forEach((btn) => {
    btn.addEventListener("mousemove", (e) => {
      const rect = btn.getBoundingClientRect();
      const x = e.clientX - rect.left - rect.width / 2;
      const y = e.clientY - rect.top - rect.height / 2;
      btn.style.transform = `translate(${x * 0.3}px, ${y * 0.3}px) scale(1.1)`;
    });
    btn.addEventListener("mouseleave", () => {
      btn.style.transform = "";
      btn.style.transition = "transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275)";
      setTimeout(() => { btn.style.transition = ""; }, 400);
    });
  });

  /* =========================================
     SECTION TITLE LINE DRAW ANIMATION
     ========================================= */
  const sectionLines = document.querySelectorAll(".title-wrapper .line, .page-section-title .title-line");
  const lineObs = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.style.transition = "transform 1s cubic-bezier(0.16, 1, 0.3, 1)";
        entry.target.style.transform = "scaleX(1)";
        lineObs.unobserve(entry.target);
      }
    });
  }, { threshold: 0.5 });

  sectionLines.forEach((line) => {
    line.style.transform = "scaleX(0)";
    line.style.transformOrigin = "center";
    lineObs.observe(line);
  });

  /* =========================================
     FLOATING PARTICLES ON EVENTS SECTION
     ========================================= */
  const eventsSection = document.querySelector(".family-events");
  if (eventsSection) {
    for (let i = 0; i < 12; i++) {
      const particle = document.createElement("div");
      particle.style.cssText = `
        position: absolute;
        width: ${3 + Math.random() * 5}px;
        height: ${3 + Math.random() * 5}px;
        background: rgba(255,255,255,${0.05 + Math.random() * 0.08});
        border-radius: 50%;
        left: ${Math.random() * 100}%;
        bottom: ${Math.random() * 60}%;
        animation: floatParticle ${6 + Math.random() * 8}s linear infinite;
        animation-delay: ${Math.random() * 5}s;
        pointer-events: none;
      `;
      eventsSection.appendChild(particle);
    }
  }

  /* =========================================
     HOVER GLOW ON SOCIAL ICONS
     ========================================= */
  document.querySelectorAll(".social-icons i").forEach((icon) => {
    icon.addEventListener("mouseenter", function() {
      this.style.boxShadow = "0 0 20px rgba(255,255,255,0.3)";
    });
    icon.addEventListener("mouseleave", function() {
      this.style.boxShadow = "";
    });
  });

  /* =========================================
     STAGGER GRID CHILDREN ON SCROLL
     ========================================= */
  const staggerGrids = document.querySelectorAll(
    ".stats-grid, .news-grid, .stats-wide"
  );

  const gridObs = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          Array.from(entry.target.children).forEach((child, i) => {
            child.style.opacity = "0";
            child.style.transform = "translateY(30px)";
            child.style.transition = `opacity 0.6s ease ${i * 0.1}s, transform 0.6s ease ${i * 0.1}s`;
            requestAnimationFrame(() => {
              child.style.opacity = "1";
              child.style.transform = "translateY(0)";
            });
          });
          gridObs.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.15 }
  );

  staggerGrids.forEach((grid) => gridObs.observe(grid));

  /* =========================================
     INNER PAGE – filter/tab buttons
     ========================================= */
  document.querySelectorAll(".news-filter-btn, .social-tab, .archive-cat-btn").forEach((btn) => {
    btn.addEventListener("click", () => {
      const parent = btn.parentElement;
      parent.querySelectorAll("button").forEach((b) => b.classList.remove("active"));
      btn.classList.add("active");
    });
  });

  /* =========================================
     INNER PAGE – stagger grid animations
     ========================================= */
  const innerGrids = document.querySelectorAll(
    ".values-grid, .social-grid, .degrees-stats, .graduates-grid, .branches-grid, .collections-grid, .archive-grid"
  );

  const innerGridObs = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          Array.from(entry.target.children).forEach((child, i) => {
            child.style.opacity = "0";
            child.style.transform = "translateY(30px)";
            child.style.transition = `opacity 0.6s ease ${i * 0.1}s, transform 0.6s ease ${i * 0.1}s`;
            requestAnimationFrame(() => {
              child.style.opacity = "1";
              child.style.transform = "translateY(0)";
            });
          });
          innerGridObs.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.1 }
  );

  innerGrids.forEach((grid) => innerGridObs.observe(grid));

  /* =========================================
     TIMELINE – stagger animation
     ========================================= */
  const timeline = document.querySelector(".timeline");
  if (timeline) {
    const timelineObs = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            Array.from(entry.target.children).forEach((child, i) => {
              child.style.opacity = "0";
              child.style.transform = "translateX(30px)";
              child.style.transition = `opacity 0.6s ease ${i * 0.15}s, transform 0.6s ease ${i * 0.15}s`;
              requestAnimationFrame(() => {
                child.style.opacity = "1";
                child.style.transform = "translateX(0)";
              });
            });
            timelineObs.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.15 }
    );
    timelineObs.observe(timeline);
  }

  /* =========================================
     GLOBE LANGUAGE TOGGLE
     ========================================= */
  const globeBtn = document.getElementById("globeBtn");
  const langDropdown = document.getElementById("langDropdown");

  if (globeBtn && langDropdown) {
    globeBtn.addEventListener("click", (e) => {
      e.stopPropagation();
      langDropdown.classList.toggle("show");
      globeBtn.classList.toggle("active", langDropdown.classList.contains("show"));
    });

    document.addEventListener("click", (e) => {
      if (!langDropdown.contains(e.target) && e.target !== globeBtn) {
        langDropdown.classList.remove("show");
        globeBtn.classList.remove("active");
      }
    });
  }

  /* =========================================
     SITE-WIDE SEARCH
     ========================================= */
  const siteSearch = document.getElementById("siteSearch");
  const searchDropdown = document.getElementById("searchDropdown");

  const sitePages = [
    { title: "الرئيسية", url: "index.html", icon: "fas fa-home", keywords: "الصفحة الرئيسية أخبار فعاليات إحصائيات صور مكتبة نشرة العبادلة" },
    { title: "عن العائلة", url: "about.html", icon: "fas fa-users", keywords: "تاريخ العائلة القيم الرؤية الرسالة النشأة الجذور العبادلة عن" },
    { title: "أخبار العائلة", url: "news.html", icon: "fas fa-newspaper", keywords: "أخبار مقالات أحداث جديد آخر الأخبار تقارير" },
    { title: "إجتماعيات", url: "social.html", icon: "fas fa-heart", keywords: "زواج تهنئة عزاء مناسبات اجتماعيات تهاني أفراح" },
    { title: "شجرة العائلة", url: "family-tree.html", icon: "fas fa-sitemap", keywords: "شجرة نسب فروع أجداد الجد المؤسس عبدالله محمد إبراهيم علي حسين" },
    { title: "فعاليات", url: "events.html", icon: "fas fa-calendar-check", keywords: "فعاليات أنشطة مناسبات ملتقى حفل تجمع لقاء عائلي" },
    { title: "شخصيات إعتبارية", url: "personalities.html", icon: "fas fa-user-tie", keywords: "شخصيات إعتبارية أعيان وجهاء شخصية بارزة كبار" },
    { title: "الألبوم", url: "album.html", icon: "fas fa-images", keywords: "ألبوم صور مكتبة لقطات ذكريات تاريخ مناسبات صورة" },
    { title: "معلومات", url: "informations.html", icon: "fas fa-info-circle", keywords: "معلومات بيانات تفاصيل أخبار عريس عرس زواج مناسبة" },
  ];

  if (siteSearch && searchDropdown) {
    function collectPageContent() {
      const items = [];
      const sections = document.querySelectorAll("h1, h2, h3, h4, .event-card, .activity-card, .stat-card, .news-card, .gallery-text, .landmark-title, .branch-card, .value-card, .social-card, .collection-card, .graduate-card, .archive-item, .about-intro, .timeline-item, p");
      sections.forEach((el) => {
        const text = el.textContent.trim();
        if (text.length > 3 && text.length < 300) {
          const tag = el.tagName.toLowerCase();
          let icon = "fas fa-file-alt";
          if (tag === "h1" || tag === "h2") icon = "fas fa-heading";
          else if (tag === "h3" || tag === "h4") icon = "fas fa-tag";
          else if (tag === "p") icon = "fas fa-paragraph";
          else if (el.classList.contains("event-card")) icon = "fas fa-calendar";
          else if (el.classList.contains("news-card")) icon = "fas fa-newspaper";

          items.push({ text, icon, element: el });
        }
      });
      return items;
    }

    const pageContent = collectPageContent();

    function renderSearchResults(query) {
      searchDropdown.innerHTML = "";
      if (!query || query.length < 2) {
        searchDropdown.classList.remove("show");
        return;
      }

      const q = query.toLowerCase();

      const pageMatches = sitePages.filter(p =>
        p.title.includes(query) || p.keywords.includes(query)
      );

      const contentMatches = pageContent.filter(item =>
        item.text.toLowerCase().includes(q)
      ).slice(0, 6);

      if (pageMatches.length === 0 && contentMatches.length === 0) {
        searchDropdown.innerHTML = `<div class="sd-empty"><i class="fas fa-search"></i>لا توجد نتائج لـ "${query}"</div>`;
        searchDropdown.classList.add("show");
        return;
      }

      if (pageMatches.length > 0) {
        searchDropdown.innerHTML += `<div class="sd-title">صفحات الموقع</div>`;
        pageMatches.forEach(page => {
          const highlighted = page.title.replace(new RegExp(`(${query})`, "gi"), "<mark>$1</mark>");
          const link = document.createElement("a");
          link.className = "sd-item";
          link.href = page.url;
          link.innerHTML = `<i class="${page.icon}"></i><div class="sd-text"><strong>${highlighted}</strong><small>${page.url}</small></div>`;
          searchDropdown.appendChild(link);
        });
      }

      if (contentMatches.length > 0) {
        const divider = document.createElement("div");
        divider.className = "sd-title";
        divider.textContent = "في هذه الصفحة";
        searchDropdown.appendChild(divider);

        contentMatches.forEach(item => {
          let snippet = item.text;
          if (snippet.length > 60) {
            const idx = snippet.toLowerCase().indexOf(q);
            const start = Math.max(0, idx - 20);
            snippet = (start > 0 ? "..." : "") + snippet.substring(start, start + 60) + "...";
          }
          snippet = snippet.replace(new RegExp(`(${query})`, "gi"), "<mark>$1</mark>");

          const div = document.createElement("div");
          div.className = "sd-item";
          div.innerHTML = `<i class="${item.icon}"></i><div class="sd-text"><strong>${snippet}</strong></div>`;
          div.addEventListener("click", () => {
            item.element.scrollIntoView({ behavior: "smooth", block: "center" });
            item.element.style.outline = "3px solid var(--brown-light)";
            item.element.style.outlineOffset = "4px";
            item.element.style.transition = "outline 0.3s ease, outline-offset 0.3s ease";
            setTimeout(() => {
              item.element.style.outline = "";
              item.element.style.outlineOffset = "";
            }, 2500);
            searchDropdown.classList.remove("show");
            siteSearch.value = "";
          });
          searchDropdown.appendChild(div);
        });
      }

      searchDropdown.classList.add("show");
    }

    siteSearch.addEventListener("input", () => renderSearchResults(siteSearch.value.trim()));
    siteSearch.addEventListener("focus", () => {
      if (siteSearch.value.trim().length >= 2) renderSearchResults(siteSearch.value.trim());
    });

    document.addEventListener("click", (e) => {
      if (!searchDropdown.contains(e.target) && e.target !== siteSearch) {
        searchDropdown.classList.remove("show");
      }
    });

    document.addEventListener("keydown", (e) => {
      if (e.key === "Escape") searchDropdown.classList.remove("show");
    });
  }

  /* =========================================
     SMOOTH SCROLL FOR NAV LINKS
     ========================================= */
  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", (e) => {
      const targetId = anchor.getAttribute("href");
      if (targetId === "#") return;
      const targetEl = document.querySelector(targetId);
      if (targetEl) {
        e.preventDefault();
        const offset = 80;
        const top = targetEl.offsetTop - offset;
        window.scrollTo({ top, behavior: "smooth" });
      }
    });
  });

});
