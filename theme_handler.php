<style>
    :root {
        --bg-color: #f4f7fe;
        --card-bg: #ffffff;
        --text-color: #212529;
        --primary-blue: #003399;
        --border-color: #dee2e6;
    }

    body.dark-mode {
        --bg-color: #121212;
        --card-bg: #1e1e1e;
        --text-color: #f1f1f1;
        --primary-blue: #3399ff;
        --border-color: #444;
    }

    body {
        background-color: var(--bg-color) !important;
        color: var(--text-color) !important;
        transition: background 0.3s ease;
    }

    /* Draggable Floating Button Style */
    #theme-dragger {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 9999;
        cursor: grab;
        user-select: none;
        touch-action: none;
    }

    .drag-pill {
        background: var(--primary-blue);
        color: white;
        padding: 10px 15px;
        border-radius: 50px;
        display: flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        border: 2px solid white;
    }

    #theme-dragger:active { cursor: grabbing; }
</style>

<div id="theme-dragger">
    <div class="drag-pill">
        <i class="bi bi-arrows-move small"></i>
        <div class="form-check form-switch mb-0">
            <input class="form-check-input" type="checkbox" id="darkModeToggle" style="cursor: pointer;">
            <label class="form-check-label small fw-bold" for="darkModeToggle">Dark Mode</label>
        </div>
    </div>
</div>

<script>
    const toggle = document.getElementById('darkModeToggle');
    const dragger = document.getElementById('theme-dragger');
    const body = document.body;

    // --- 1. THEME PERSISTENCE LOGIC ---
    if (localStorage.getItem('theme') === 'dark') {
        body.classList.add('dark-mode');
        toggle.checked = true;
    }

    toggle.addEventListener('change', () => {
        if (toggle.checked) {
            body.classList.add('dark-mode');
            localStorage.setItem('theme', 'dark');
        } else {
            body.classList.remove('dark-mode');
            localStorage.setItem('theme', 'light');
        }
    });

    // --- 2. DRAGGABLE LOGIC ---
    let isDragging = false;
    let offsetX, offsetY;

    dragger.addEventListener('mousedown', (e) => {
        if (e.target === toggle) return; // Don't drag if clicking the switch
        isDragging = true;
        offsetX = e.clientX - dragger.getBoundingClientRect().left;
        offsetY = e.clientY - dragger.getBoundingClientRect().top;
    });

    document.addEventListener('mousemove', (e) => {
        if (!isDragging) return;
        
        let x = e.clientX - offsetX;
        let y = e.clientY - offsetY;

        // Keep it within screen bounds
        x = Math.max(0, Math.min(x, window.innerWidth - dragger.offsetWidth));
        y = Math.max(0, Math.min(y, window.innerHeight - dragger.offsetHeight));

        dragger.style.left = x + 'px';
        dragger.style.top = y + 'px';
        dragger.style.bottom = 'auto';
        dragger.style.right = 'auto';
    });

    document.addEventListener('mouseup', () => {
        isDragging = false;
    });
</script>