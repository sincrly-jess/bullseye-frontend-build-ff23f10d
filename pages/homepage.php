<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bullseye</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Orbitron:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --bg: hsl(0,0%,5%);
            --fg: hsl(0,0%,95%);
            --card: hsl(0,0%,8%);
            --primary: hsl(0,80%,50%);
            --primary-fg: #fff;
            --muted: hsl(0,0%,55%);
            --border: hsl(0,0%,16%);
            --glass: rgba(255,255,255,0.05);
            --glass-hover: rgba(255,255,255,0.1);
            --glow-red: 0,100%,50%;
            --radius: 0.75rem;
        }

        body {
            background: var(--bg);
            color: var(--fg);
            font-family: 'Inter', sans-serif;
            -webkit-font-smoothing: antialiased;
            min-height: 100vh;
            background-image: url('images/background-3.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        h1, h2, h3, .font-display { font-family: 'Orbitron', sans-serif; }

        a { color: inherit; text-decoration: none; }

        /* ===== NAVBAR ===== */
        .navbar {
            position: fixed; top: 0; left: 0; right: 0; z-index: 50;
            background: var(--glass); backdrop-filter: blur(24px); -webkit-backdrop-filter: blur(24px);
            border-bottom: 1px solid var(--border); height: 56px;
        }
        .navbar-inner {
            max-width: 1200px; margin: 0 auto; display: flex;
            align-items: center; justify-content: space-between; height: 100%; padding: 0 16px;
        }
        .nav-left, .nav-right { display: flex; align-items: center; gap: 12px; }
        .nav-btn {
            background: none; border: none; color: var(--muted); cursor: pointer;
            padding: 8px; font-size: 20px; transition: color 0.2s;
        }
        .nav-btn:hover { color: var(--fg); }
        .nav-logo { height: 64px; width: auto; object-fit: contain; }
        .nav-user { display: flex; align-items: center; gap: 8px; cursor: pointer; position: relative; background: none; border: none; color: var(--fg); }
        .nav-username { font-size: 14px; color: var(--muted); }
        .nav-pfp { width: 32px; height: 32px; border-radius: 50%; border: 1px solid var(--border); object-fit: cover; }

        /* Profile Dropdown */
        .profile-dropdown {
            display: none; position: absolute; right: 0; top: 48px; z-index: 100;
            width: 192px; border-radius: 12px; background: var(--card); border: 1px solid var(--border);
            box-shadow: 0 10px 30px rgba(0,0,0,0.5); padding: 12px;
        }
        .profile-dropdown.open { display: flex; flex-direction: column; gap: 8px; }
        .profile-dropdown a {
            display: block; text-align: center; padding: 10px; border-radius: 8px;
            background: var(--primary); color: var(--primary-fg); font-weight: 600;
            transition: opacity 0.2s;
        }
        .profile-dropdown a:hover { opacity: 0.8; }

        /* ===== SIDEBAR ===== */
        .sidebar-overlay {
            display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 40;
        }
        .sidebar-overlay.open { display: block; }
        .sidebar {
            position: fixed; top: 56px; left: 0; bottom: 0; width: 256px;
            background: var(--card); border-right: 1px solid var(--border); z-index: 50;
            transform: translateX(-100%); transition: transform 0.3s; padding: 16px;
        }
        .sidebar.open { transform: translateX(0); }
        .sidebar a, .sidebar button {
            display: flex; align-items: center; gap: 12px; padding: 8px 12px;
            border-radius: 8px; width: 100%; font-size: 14px; color: var(--muted);
            transition: all 0.2s; border: none; background: none; cursor: pointer; text-align: left;
        }
        .sidebar a:hover, .sidebar button:hover { color: var(--fg); background: rgba(255,255,255,0.05); }
        .sidebar .sub-menu { margin-left: 28px; margin-top: 4px; }
        .sidebar .sub-menu a { font-size: 13px; padding: 6px 12px; }
        .sidebar .sub-menu a:hover { text-decoration: underline; }

        /* ===== HERO ===== */
        .hero { padding-top: 80px; padding-bottom: 24px; text-align: center; }
        .hero-welcome { font-size: 1.75rem; font-weight: 700; }
        .hero-title {
            font-size: 3.5rem; font-weight: 900; letter-spacing: 0.1em;
            text-shadow: 0 0 20px hsla(var(--glow-red),0.6), 0 0 40px hsla(var(--glow-red),0.3);
        }

        /* ===== GAMES SECTION ===== */
        .games-section { padding: 48px 0; }
        .games-container { max-width: 672px; margin: 0 auto; padding: 0 16px; }
        .games-heading { font-size: 1.5rem; font-weight: 700; text-align: center; margin-bottom: 24px; }

        .game-row {
            background: var(--glass); backdrop-filter: blur(24px); -webkit-backdrop-filter: blur(24px);
            border: 1px solid var(--border); border-radius: 12px; padding: 16px; margin-bottom: 16px;
        }
        .game-row-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; }
        .game-row-info { display: flex; align-items: center; gap: 12px; }
        .game-row-icon {
            width: 40px; height: 40px; border-radius: 8px;
            background: rgba(204,26,26,0.2); display: flex; align-items: center; justify-content: center;
            font-size: 20px;
        }
        .game-row-title { font-weight: 600; font-family: 'Inter', sans-serif; }
        .game-row-subtitle { font-size: 12px; color: var(--muted); }
        .game-row-arrow { background: none; border: none; color: var(--muted); cursor: pointer; font-size: 20px; padding: 8px; transition: color 0.2s; }
        .game-row-arrow:hover { color: var(--fg); }

        .game-thumbs { display: flex; gap: 12px; overflow-x: auto; padding-bottom: 4px; }
        .game-thumb {
            width: 56px; height: 56px; border-radius: 8px; overflow: hidden; flex-shrink: 0;
            border: 1px solid var(--border); cursor: pointer; transition: transform 0.3s;
        }
        .game-thumb:hover { transform: scale(1.5); z-index: 10; }
        .game-thumb img { width: 100%; height: 100%; object-fit: cover; }

        /* ===== MODAL ===== */
        .modal-overlay {
            display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 200;
        }
        .modal-overlay.open { display: block; }
        .modal {
            display: none; position: fixed; inset: 16px; z-index: 201;
            background: var(--card); border: 1px solid var(--border); border-radius: 16px;
            overflow: auto; padding: 24px;
        }
        .modal.open { display: block; }
        .modal-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; }
        .modal-title { font-family: 'Orbitron', sans-serif; font-size: 1.25rem; font-weight: 700; }
        .modal-close { background: none; border: none; color: var(--muted); cursor: pointer; font-size: 24px; padding: 8px; }
        .modal-close:hover { color: var(--fg); }
        .modal-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap: 16px; }
        .modal-card {
            background: var(--glass); border-radius: 12px; padding: 12px;
            display: flex; flex-direction: column; align-items: center; gap: 8px; cursor: pointer;
            transition: background 0.2s;
        }
        .modal-card:hover { background: var(--glass-hover); }
        .modal-card img { width: 80px; height: 80px; border-radius: 8px; object-fit: cover; border: 1px solid var(--border); }
        .modal-card span { font-size: 14px; font-weight: 500; text-align: center; }

        @media (min-width: 768px) {
            .hero-welcome { font-size: 2rem; }
            .hero-title { font-size: 4.5rem; }
            .games-heading { font-size: 1.75rem; }
            .modal { inset: 64px; }
        }

        @media (max-width: 640px) {
            .nav-username { display: none; }
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
    <div class="navbar-inner">
        <div class="nav-left">
            <button class="nav-btn" id="menuBtn" aria-label="Menu">&#9776;</button>
            <button class="nav-btn" aria-label="Notifications">&#128276;</button>
        </div>
        <img src="images/bullseye-logo.png" alt="Bullseye" class="nav-logo">
        <div class="nav-right">
            <button class="nav-user" id="profileBtn">
                <span class="nav-username">testu</span>
                <img src="images/default-pfp.png" alt="Profile" class="nav-pfp">
            </button>
            <div class="profile-dropdown" id="profileDropdown">
                <a href="index.php?page=profile_page">View Profile</a>
                <a href="#">Friends</a>
                <a href="#">Rewards</a>
                <a href="#">Chat</a>
                <a href="#">Stats</a>
                <a href="index.php?page=log_in">Logout</a>
            </div>
        </div>
    </div>
</nav>

<!-- SIDEBAR -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>
<aside class="sidebar" id="sidebar">
    <a href="index.php?page=homepage">&#127968; Home</a>
    <button id="catToggle">&#9783; Categories <span id="catArrow" style="margin-left:auto;">&#9654;</span></button>
    <div class="sub-menu" id="catMenu" style="display:none;">
        <a href="#">Bullseye Games</a>
        <a href="#">Casino</a>
        <a href="#">Markets</a>
    </div>
    <a href="#">&#127942; Leaderboard</a>
    <a href="#">&#128172; Chat</a>
</aside>

<!-- HERO -->
<section class="hero">
    <h1>
        <span class="hero-welcome">Welcome to</span><br>
        <span class="hero-title">BULLSEYE</span>
    </h1>
</section>

<!-- GAMES -->
<section class="games-section">
    <div class="games-container">
        <h2 class="games-heading">Browse Collections</h2>

        <div class="game-row">
            <div class="game-row-header">
                <div class="game-row-info">
                    <div class="game-row-icon">&#11088;</div>
                    <div>
                        <div class="game-row-title">Favorited Games</div>
                        <div class="game-row-subtitle">4 games</div>
                    </div>
                </div>
                <button class="game-row-arrow" onclick="openModal('Favorited Games', [0,1,2,3])">&#10132;</button>
            </div>
            <div class="game-thumbs">
                <div class="game-thumb"><img src="images/dice-card.jpg" alt="Dice"></div>
                <div class="game-thumb"><img src="images/coinflip-card.jpg" alt="Flip"></div>
                <div class="game-thumb"><img src="images/hilo-card.png" alt="Hilo"></div>
                <div class="game-thumb"><img src="images/mines-card.png" alt="Mines"></div>
            </div>
        </div>

        <div class="game-row">
            <div class="game-row-header">
                <div class="game-row-info">
                    <div class="game-row-icon">&#128336;</div>
                    <div>
                        <div class="game-row-title">Frequently Played</div>
                        <div class="game-row-subtitle">889 total plays</div>
                    </div>
                </div>
                <button class="game-row-arrow" onclick="openModal('Frequently Played', [1,2,3,4])">&#10132;</button>
            </div>
            <div class="game-thumbs">
                <div class="game-thumb"><img src="images/coinflip-card.jpg" alt="Flip"></div>
                <div class="game-thumb"><img src="images/hilo-card.png" alt="Hilo"></div>
                <div class="game-thumb"><img src="images/mines-card.png" alt="Mines"></div>
                <div class="game-thumb"><img src="images/casino-card.jpg" alt="Roulette"></div>
            </div>
        </div>

        <div class="game-row">
            <div class="game-row-header">
                <div class="game-row-info">
                    <div class="game-row-icon">&#128293;</div>
                    <div>
                        <div class="game-row-title">Popular Games</div>
                        <div class="game-row-subtitle">Top rated by players</div>
                    </div>
                </div>
                <button class="game-row-arrow" onclick="openModal('Popular Games', [0,1,2,3])">&#10132;</button>
            </div>
            <div class="game-thumbs">
                <div class="game-thumb"><img src="images/dice-card.jpg" alt="Dice"></div>
                <div class="game-thumb"><img src="images/coinflip-card.jpg" alt="Flip"></div>
                <div class="game-thumb"><img src="images/hilo-card.png" alt="Hilo"></div>
                <div class="game-thumb"><img src="images/mines-card.png" alt="Mines"></div>
            </div>
        </div>

        <div class="game-row">
            <div class="game-row-header">
                <div class="game-row-info">
                    <div class="game-row-icon">&#128200;</div>
                    <div>
                        <div class="game-row-title">Trending</div>
                        <div class="game-row-subtitle">2 games trending now</div>
                    </div>
                </div>
                <button class="game-row-arrow" onclick="openModal('Trending', [3,4,5,6])">&#10132;</button>
            </div>
            <div class="game-thumbs">
                <div class="game-thumb"><img src="images/mines-card.png" alt="Mines"></div>
                <div class="game-thumb"><img src="images/casino-card.jpg" alt="Roulette"></div>
                <div class="game-thumb"><img src="images/rps-card.png" alt="RPS"></div>
                <div class="game-thumb"><img src="images/wheel-card.jpg" alt="Wheel"></div>
            </div>
        </div>
    </div>
</section>

<!-- MODAL -->
<div class="modal-overlay" id="modalOverlay"></div>
<div class="modal" id="modal">
    <div class="modal-header">
        <h2 class="modal-title" id="modalTitle"></h2>
        <button class="modal-close" onclick="closeModal()">&times;</button>
    </div>
    <div class="modal-grid" id="modalGrid"></div>
</div>

<script>
    // Games data
    const allGames = [
        { image: 'images/dice-card.jpg', title: 'Dice' },
        { image: 'images/coinflip-card.jpg', title: 'Flip' },
        { image: 'images/hilo-card.png', title: 'Hilo' },
        { image: 'images/mines-card.png', title: 'Mines' },
        { image: 'images/casino-card.jpg', title: 'Roulette' },
        { image: 'images/rps-card.png', title: 'Rock Paper Scissors' },
        { image: 'images/wheel-card.jpg', title: 'Wheel' }
    ];

    // Profile dropdown
    const profileBtn = document.getElementById('profileBtn');
    const profileDropdown = document.getElementById('profileDropdown');
    profileBtn.addEventListener('click', () => profileDropdown.classList.toggle('open'));
    document.addEventListener('mousedown', (e) => {
        if (!profileBtn.contains(e.target) && !profileDropdown.contains(e.target)) {
            profileDropdown.classList.remove('open');
        }
    });

    // Sidebar
    const menuBtn = document.getElementById('menuBtn');
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    menuBtn.addEventListener('click', () => {
        sidebar.classList.toggle('open');
        sidebarOverlay.classList.toggle('open');
    });
    sidebarOverlay.addEventListener('click', () => {
        sidebar.classList.remove('open');
        sidebarOverlay.classList.remove('open');
    });

    // Categories toggle
    const catToggle = document.getElementById('catToggle');
    const catMenu = document.getElementById('catMenu');
    const catArrow = document.getElementById('catArrow');
    catToggle.addEventListener('click', () => {
        const open = catMenu.style.display !== 'none';
        catMenu.style.display = open ? 'none' : 'block';
        catArrow.innerHTML = open ? '&#9654;' : '&#9660;';
    });

    // Modal
    function openModal(title, indices) {
        document.getElementById('modalTitle').textContent = title;
        const grid = document.getElementById('modalGrid');
        grid.innerHTML = '';
        indices.forEach(i => {
            const game = allGames[i];
            const card = document.createElement('div');
            card.className = 'modal-card';
            card.innerHTML = '<img src="' + game.image + '" alt="' + game.title + '"><span>' + game.title + '</span>';
            grid.appendChild(card);
        });
        document.getElementById('modalOverlay').classList.add('open');
        document.getElementById('modal').classList.add('open');
    }
    function closeModal() {
        document.getElementById('modalOverlay').classList.remove('open');
        document.getElementById('modal').classList.remove('open');
    }
    document.getElementById('modalOverlay').addEventListener('click', closeModal);
</script>

</body>
</html>
