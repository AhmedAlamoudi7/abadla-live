document.addEventListener("DOMContentLoaded", () => {

  const canvas = document.getElementById("treeCanvas");
  const viewport = document.getElementById("treeViewport");
  const detail = document.getElementById("ftreeDetail");
  const detailClose = document.getElementById("ftreeDetailClose");
  const sidebar = document.getElementById("treeSidebar");
  if (!canvas || !viewport) return;

  /* ============ ZOOM ============ */
  let zoom = 1;
  const ZOOM_STEP = 0.1, ZOOM_MIN = 0.3, ZOOM_MAX = 2;
  const zoomLabel = document.getElementById("tbZoomLabel");

  function applyZoom() {
    canvas.style.transform = `scale(${zoom})`;
    if (zoomLabel) zoomLabel.textContent = Math.round(zoom * 100) + "%";
  }

  const bind = (id, fn) => { const el = document.getElementById(id); if (el) el.addEventListener("click", fn); };
  bind("tbZoomIn", () => { zoom = Math.min(zoom + ZOOM_STEP, ZOOM_MAX); applyZoom(); });
  bind("tbZoomOut", () => { zoom = Math.max(zoom - ZOOM_STEP, ZOOM_MIN); applyZoom(); });
  bind("tbReset", () => {
    zoom = 1; applyZoom();
    viewport.scrollTo({ top: 0, left: (viewport.scrollWidth - viewport.clientWidth) / 2, behavior: "smooth" });
  });

  viewport.addEventListener("wheel", (e) => {
    if (e.ctrlKey) {
      e.preventDefault();
      zoom = e.deltaY < 0 ? Math.min(zoom + 0.05, ZOOM_MAX) : Math.max(zoom - 0.05, ZOOM_MIN);
      applyZoom();
    }
  }, { passive: false });

  /* ============ PAN ============ */
  let isDragging = false, startX, startY, scrollLeft, scrollTop;
  viewport.addEventListener("mousedown", (e) => {
    if (e.target.closest(".ftree-node") || e.target.closest(".ftree-toggle")) return;
    isDragging = true; startX = e.pageX; startY = e.pageY;
    scrollLeft = viewport.scrollLeft; scrollTop = viewport.scrollTop;
  });
  document.addEventListener("mousemove", (e) => {
    if (!isDragging) return; e.preventDefault();
    viewport.scrollLeft = scrollLeft - (e.pageX - startX);
    viewport.scrollTop = scrollTop - (e.pageY - startY);
  });
  document.addEventListener("mouseup", () => { isDragging = false; });

  /* ============ TOUCH PAN ============ */
  let touchStart = null;
  viewport.addEventListener("touchstart", (e) => {
    if (e.touches.length === 1 && !e.target.closest(".ftree-node") && !e.target.closest(".ftree-toggle")) {
      touchStart = { x: e.touches[0].pageX, y: e.touches[0].pageY, sl: viewport.scrollLeft, st: viewport.scrollTop };
    }
  }, { passive: true });
  viewport.addEventListener("touchmove", (e) => {
    if (!touchStart || e.touches.length !== 1) return;
    viewport.scrollLeft = touchStart.sl - (e.touches[0].pageX - touchStart.x);
    viewport.scrollTop = touchStart.st - (e.touches[0].pageY - touchStart.y);
  }, { passive: true });
  viewport.addEventListener("touchend", () => { touchStart = null; });

  /* ============ EXPAND / COLLAPSE ============ */
  function toggleBranch(btn) {
    const li = btn.closest("li");
    const childUl = li && li.querySelector(":scope > ul");
    if (!childUl) return;
    const isExpanded = childUl.classList.toggle("ftree-expanded");
    btn.classList.toggle("expanded", isExpanded);
  }

  document.querySelectorAll(".ftree-toggle").forEach(btn => {
    btn.addEventListener("click", (e) => { e.stopPropagation(); toggleBranch(btn); });
  });

  bind("tbExpandAll", () => {
    document.querySelectorAll(".ftree-collapsed").forEach(ul => ul.classList.add("ftree-expanded"));
    document.querySelectorAll(".ftree-toggle").forEach(b => b.classList.add("expanded"));
  });

  bind("tbCollapseAll", () => {
    document.querySelectorAll(".ftree-collapsed").forEach(ul => ul.classList.remove("ftree-expanded"));
    document.querySelectorAll(".ftree-toggle").forEach(b => b.classList.remove("expanded"));
  });

  /* ============ DETAIL PANEL ============ */
  const overlay = document.createElement("div");
  overlay.className = "ftree-overlay";
  document.body.appendChild(overlay);

  function showDetail(node) {
    const iconEl = node.querySelector(".ftree-avatar i");
    document.getElementById("ftreeDetailName").textContent = node.dataset.name || "";
    document.getElementById("ftreeDetailRole").textContent = node.dataset.role || "";
    document.getElementById("ftreeDetailYear").textContent = node.dataset.year || "";
    document.getElementById("ftreeDetailBio").textContent = node.dataset.bio || "";
    document.getElementById("ftreeDetailIcon").className = iconEl ? iconEl.className : "fas fa-user";
    document.querySelectorAll(".ftree-node").forEach(n => n.classList.remove("ftree-active"));
    node.classList.add("ftree-active");
    detail.classList.add("show");
    overlay.classList.add("show");
  }

  function hideDetail() {
    detail.classList.remove("show");
    overlay.classList.remove("show");
    document.querySelectorAll(".ftree-node").forEach(n => n.classList.remove("ftree-active"));
  }

  document.querySelectorAll(".ftree-node").forEach(node => {
    node.addEventListener("click", (e) => {
      if (e.target.closest(".ftree-toggle")) return;
      showDetail(node);
    });
  });

  if (detailClose) detailClose.addEventListener("click", hideDetail);
  overlay.addEventListener("click", hideDetail);
  document.addEventListener("keydown", (e) => { if (e.key === "Escape") hideDetail(); });

  /* ============ TABS ============ */
  const tabs = document.querySelectorAll(".tree-tab");
  const tabPanels = {
    tree: document.getElementById("tabTree"),
    members: document.getElementById("tabMembers"),
    stats: document.getElementById("tabStats"),
    about: document.getElementById("tabAbout"),
  };

  tabs.forEach(tab => {
    tab.addEventListener("click", () => {
      tabs.forEach(t => t.classList.remove("active"));
      tab.classList.add("active");
      const key = tab.dataset.tab;
      Object.values(tabPanels).forEach(p => { if (p) p.classList.remove("active"); });
      if (tabPanels[key]) tabPanels[key].classList.add("active");

      if (key === "members") buildMembersGrid();
      if (key === "stats") animateBars();
    });
  });

  /* ============ MEMBERS GRID ============ */
  function buildMembersGrid() {
    const grid = document.getElementById("membersGrid");
    if (!grid || grid.children.length) return;
    const nodes = document.querySelectorAll("#familyTree .ftree-node");
    nodes.forEach(node => {
      const card = document.createElement("div");
      card.className = "member-card";
      const iconEl = node.querySelector(".ftree-avatar i");
      card.innerHTML = `
        <div class="mc-avatar"><i class="${iconEl ? iconEl.className : 'fas fa-user'}"></i></div>
        <h4>${node.dataset.name || ''}</h4>
        <p>${node.dataset.role || ''}</p>
      `;
      card.addEventListener("click", () => showDetail(node));
      grid.appendChild(card);
    });
  }

  /* ============ STATS BAR ANIMATION ============ */
  let barsAnimated = false;
  function animateBars() {
    if (barsAnimated) return;
    barsAnimated = true;
    document.querySelectorAll(".ts-bar-fill").forEach((bar, i) => {
      setTimeout(() => bar.classList.add("animated"), i * 200);
    });
  }

  /* ============ SIDEBAR TOGGLE ============ */
  bind("tbSidebarToggle", () => {
    if (window.innerWidth <= 992) {
      sidebar.classList.toggle("open");
    } else {
      sidebar.classList.toggle("collapsed");
    }
  });

  /* ============ BRANCH FILTER ============ */
  document.querySelectorAll(".branch-item").forEach(btn => {
    btn.addEventListener("click", () => {
      document.querySelectorAll(".branch-item").forEach(b => b.classList.remove("active"));
      btn.classList.add("active");
      const branch = btn.dataset.branch;
      const rootChildren = document.querySelectorAll("#familyTree > li > ul > li[data-branch]");
      rootChildren.forEach(li => {
        li.style.display = (branch === "all" || li.dataset.branch === branch) ? "" : "none";
      });

      if (branch !== "all") {
        const target = document.querySelector(`#familyTree li[data-branch="${branch}"] .ftree-toggle`);
        if (target && !target.classList.contains("expanded")) {
          toggleBranch(target);
        }
      }

      tabs.forEach(t => t.classList.remove("active"));
      tabs[0].classList.add("active");
      Object.values(tabPanels).forEach(p => { if (p) p.classList.remove("active"); });
      tabPanels.tree.classList.add("active");

      if (window.innerWidth <= 992) sidebar.classList.remove("open");
    });
  });

  /* ============ SEARCH ============ */
  const searchInput = document.getElementById("treeSearchInput");
  const searchResults = document.getElementById("searchResults");
  const allNodes = Array.from(document.querySelectorAll("#familyTree .ftree-node"));

  function doSearch() {
    const query = searchInput.value.trim();
    searchResults.innerHTML = "";
    if (!query) return;
    const matches = allNodes.filter(n => (n.dataset.name || "").includes(query));
    matches.forEach(node => {
      const iconEl = node.querySelector(".ftree-avatar i");
      const item = document.createElement("div");
      item.className = "search-result-item";
      item.innerHTML = `
        <div class="sr-icon"><i class="${iconEl ? iconEl.className : 'fas fa-user'}"></i></div>
        <div class="sr-info">
          <span class="sr-name">${node.dataset.name}</span>
          <span class="sr-role">${node.dataset.role || ''}</span>
        </div>
      `;
      item.addEventListener("click", () => {
        expandPathTo(node);
        scrollToNode(node);
        highlightNode(node);
        tabs.forEach(t => t.classList.remove("active"));
        tabs[0].classList.add("active");
        Object.values(tabPanels).forEach(p => { if (p) p.classList.remove("active"); });
        tabPanels.tree.classList.add("active");
        if (window.innerWidth <= 992) sidebar.classList.remove("open");
      });
      searchResults.appendChild(item);
    });
  }

  if (searchInput) searchInput.addEventListener("input", doSearch);

  function expandPathTo(node) {
    let el = node.closest("ul");
    while (el) {
      if (el.classList.contains("ftree-collapsed")) {
        el.classList.add("ftree-expanded");
        const parentLi = el.closest("li");
        const toggle = parentLi && parentLi.querySelector(":scope > .ftree-node .ftree-toggle");
        if (toggle) toggle.classList.add("expanded");
      }
      el = el.parentElement && el.parentElement.closest("ul");
    }
    document.querySelectorAll("#familyTree > li > ul > li[data-branch]").forEach(li => li.style.display = "");
    document.querySelectorAll(".branch-item").forEach(b => b.classList.remove("active"));
    document.querySelector('.branch-item[data-branch="all"]').classList.add("active");
  }

  function scrollToNode(node) {
    setTimeout(() => {
      const rect = node.getBoundingClientRect();
      const vRect = viewport.getBoundingClientRect();
      viewport.scrollTo({
        left: viewport.scrollLeft + rect.left - vRect.left - vRect.width / 2 + rect.width / 2,
        top: viewport.scrollTop + rect.top - vRect.top - vRect.height / 2 + rect.height / 2,
        behavior: "smooth"
      });
    }, 400);
  }

  function highlightNode(node) {
    document.querySelectorAll(".ftree-node.highlight").forEach(n => n.classList.remove("highlight"));
    node.classList.add("highlight");
    setTimeout(() => node.classList.remove("highlight"), 3200);
  }

  /* ============ ADVANCED SEARCH ============ */
  bind("advancedToggle", () => {
    document.getElementById("advancedFields").classList.toggle("show");
  });

  /* ============ HERO STATS COUNTER ============ */
  document.querySelectorAll(".tree-stat-num[data-target]").forEach(el => {
    const target = parseInt(el.dataset.target);
    let current = 0;
    const step = Math.max(1, Math.ceil(target / 60));
    const interval = setInterval(() => {
      current += step;
      if (current >= target) { current = target; clearInterval(interval); }
      el.textContent = current.toLocaleString("ar-EG");
    }, 30);
  });

  /* ============ CENTER TREE ============ */
  setTimeout(() => {
    viewport.scrollLeft = (viewport.scrollWidth - viewport.clientWidth) / 2;
  }, 500);

  /* ============ CLOSE SIDEBAR ON OUTSIDE CLICK (mobile) ============ */
  document.addEventListener("click", (e) => {
    if (window.innerWidth <= 992 && sidebar.classList.contains("open")) {
      if (!sidebar.contains(e.target) && !e.target.closest("#tbSidebarToggle")) {
        sidebar.classList.remove("open");
      }
    }
  });

});
