<?php
// --- BACKEND DATA ---
session_start();
require __DIR__ . "/../db.php";

// User Data
$user_data = [
    'username' => $_SESSION['username'] ?? 'Guest',
];

// Fetch real username from database
if (isset($_SESSION['user_id'])) {
    $stmt = $conn->prepare("SELECT username FROM users WHERE id = ? LIMIT 1");
    if ($stmt) {
        $stmt->bind_param("i", $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $user_data['username'] = $row['username'];
        }
        $stmt->close();
    }
}

$avatar_url = "https://ui-avatars.com/api/?name=" . urlencode($user_data['username']) . "&background=random&color=fff";

// Fetch wallet balance from DB (fallback to 0)
$wallet_balance = 0;
if (isset($_SESSION['user_id'])) {
    $stmt = $conn->prepare("SELECT balance FROM users WHERE id = ? LIMIT 1");
    if ($stmt) {
        $stmt->bind_param("i", $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $wallet_balance = $row['balance'] ?? 0;
        }
        $stmt->close();
    }
}

// Collections data
$collections = [
    [
        'icon'       => 'fa-solid fa-star',
        'icon_bg'    => '#ff1a1a',
        'title'      => 'Favorited Games',
        'subtitle'   => '4 games',
        'link'       => '?page=favorites',
        'games'      => [
            ['name' => '', 'color' => '#1cd111', 'image' => 'games/flip.jpg'],
            ['name' => '', 'color' => '#a124e8', 'image' => 'games/Dice.jpg'],
            ['name' => '', 'color' => '#f2a900', 'image' => 'games/wheel.jpg'],
            ['name' => '', 'color' => '#0d9e29', 'image' => 'games/roulette.jpg'],
            ['name' => '', 'color' => '#0d9e29', 'image' => 'games/blackjack.jpg']
        ]
    ],
    [
        'icon'       => 'fa-regular fa-clock',
        'icon_bg'    => '#8a2be2',
        'title'      => 'Frequently Played',
        'subtitle'   => '880 total plays',
        'link'       => '?page=freq_played',
        'games'      => [
            ['name' => '', 'color' => '#f2a900', 'image' => 'games/wheel.jpg'],
            ['name' => '', 'color' => '#0084ff', 'image' => 'games/mines.jpg'],
            ['name' => '', 'color' => '#ff3b3b', 'image' => 'games/rps.jpg']
        ]
    ],
    [
        'icon'       => 'fa-solid fa-fire',
        'icon_bg'    => '#ff6600',
        'title'      => 'Popular Games',
        'subtitle'   => 'Top rated by players',
        'link'       => '?page=pop_games',
        'games'      => [
            ['name' => '', 'color' => '#1cd111', 'image' => 'games/flip.jpg'],
            ['name' => '', 'color' => '#f2a900', 'image' => 'games/wheel.jpg'],
            ['name' => '', 'color' => '#a124e8', 'image' => 'games/Dice.jpg']
        ]
    ],
    [
        'icon'       => 'fa-solid fa-arrow-trend-up',
        'icon_bg'    => '#ff1a1a',
        'title'      => 'Trending',
        'subtitle'   => '2 games trending now',
        'link'       => '?page=trending',
        'games'      => [
            ['name' => '', 'color' => '#f2a900', 'image' => 'games/wheel.jpg'],
            ['name' => '', 'color' => '#0d9e29', 'image' => 'games/roulette.jpg']
        ]
    ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bullseye - Welcome</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Orbitron:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            transition: transform 0.3s ease;
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
            width: 220px; border-radius: 12px;
            background: var(--glass); backdrop-filter: blur(24px); -webkit-backdrop-filter: blur(24px);
            border: 1px solid var(--border);
            box-shadow: 0 10px 30px rgba(0,0,0,0.5); padding: 12px;
        }
        .profile-dropdown.open { display: flex; flex-direction: column; gap: 8px; }
        .wallet-display {
            display: flex; align-items: center; justify-content: center; gap: 8px;
            padding: 10px; border-radius: 8px; background: rgba(255,215,0,0.1);
            border: 1px solid rgba(255,215,0,0.3); font-weight: 700; font-size: 15px;
            color: #ffd700;
        }
        .wallet-display .coin-icon { font-size: 18px; }
        .profile-dropdown a {
            display: flex; align-items: center; gap: 10px; padding: 10px 12px; border-radius: 8px;
            font-size: 14px; font-weight: 500; color: var(--fg);
            transition: background 0.2s;
        }
        .profile-dropdown a:hover { background: var(--glass-hover); }
        .profile-dropdown a i { width: 16px; text-align: center; color: var(--muted); font-size: 14px; }
        .profile-dropdown a.logout { color: #ff4a4a; }
        .profile-dropdown a.logout i { color: #ff4a4a; }

        /* ===== SIDEBAR ===== */
        .sidebar-overlay {
            display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 40;
        }
        .sidebar-overlay.open { display: block; }
        .sidebar {
            position: fixed; top: 56px; left: 0; bottom: 0; width: 256px;
            background: var(--glass); backdrop-filter: blur(24px); -webkit-backdrop-filter: blur(24px);
            border-right: 1px solid var(--border); z-index: 50;
            transform: translateX(-100%); transition: transform 0.3s; padding: 16px;
        }
        .sidebar.open { transform: translateX(0); }
        .sidebar a, .sidebar button {
            display: flex; align-items: center; gap: 12px; padding: 8px 12px;
            border-radius: 8px; width: 100%; font-size: 14px; color: var(--muted);
            transition: all 0.2s; border: none; background: none; cursor: pointer; text-align: left;
        }
        .sidebar a:hover, .sidebar button:hover { color: var(--fg); background: var(--glass-hover); }
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
        .games-heading {
            font-size: 1.5rem; font-weight: 700; text-align: center; margin-bottom: 24px;
            text-shadow: 0 0 15px hsla(var(--glow-red),0.4);
        }

        .game-row {
            background: var(--glass); backdrop-filter: blur(24px); -webkit-backdrop-filter: blur(24px);
            border: 1px solid var(--border); border-radius: 12px; padding: 16px; margin-bottom: 16px;
            transition: background 0.2s;
        }
        .game-row:hover { background: var(--glass-hover); }
        .game-row-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; }
        .game-row-info { display: flex; align-items: center; gap: 12px; }
        .game-row-icon {
            width: 40px; height: 40px; border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; color: white; flex-shrink: 0;
        }
        .game-row-title { font-weight: 600; font-family: 'Inter', sans-serif; }
        .game-row-subtitle { font-size: 12px; color: var(--muted); }
        .game-row-arrow {
            background: none; border: none; color: var(--muted); cursor: pointer;
            font-size: 20px; padding: 8px; transition: color 0.2s; text-decoration: none;
        }
        .game-row-arrow:hover { color: var(--fg); }

        .game-thumbs { display: flex; gap: 12px; overflow-x: auto; padding-bottom: 4px; }
        .game-thumb {
            width: 56px; height: 56px; border-radius: 8px; overflow: hidden; flex-shrink: 0;
            border: 1px solid var(--border); cursor: pointer; transition: transform 0.3s;
            position: relative; display: block;
        }
        .game-thumb:hover { transform: scale(1.5); z-index: 10; }
        .game-thumb img { width: 100%; height: 100%; object-fit: cover; }

        @media (min-width: 768px) {
            .hero-welcome { font-size: 2rem; }
            .hero-title { font-size: 4.5rem; }
            .games-heading { font-size: 1.75rem; }
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
            <button class="nav-btn" id="menuBtn" aria-label="Menu"><i class="fa-solid fa-bars"></i></button>
            <button class="nav-btn" aria-label="Notifications"><i class="fa-solid fa-bell"></i></button>
        </div>
        <a href="?page=logged_in_page">
            <img src="images/bullseye-logo.png" alt="Bullseye" class="nav-logo">
        </a>
        <div class="nav-right">
            <button class="nav-user" id="profileBtn">
                <span class="nav-username"><?php echo htmlspecialchars($user_data['username']); ?></span>
                <img src="<?php echo $avatar_url; ?>" alt="Profile" class="nav-pfp">
            </button>
            <div class="profile-dropdown" id="profileDropdown">
                <div class="wallet-display">
                    <span class="coin-icon">🪙</span>
                    <span><?php echo number_format($wallet_balance); ?> coins</span>
                </div>
                <a href="?page=profile_page"><i class="fa-solid fa-user"></i> View Profile</a>
                <a href="#"><i class="fa-solid fa-user-group"></i> Friends</a>
                <a href="#"><i class="fa-solid fa-gift"></i> Rewards</a>
                <a href="#"><i class="fa-solid fa-comment"></i> Chat</a>
                <a href="#"><i class="fa-solid fa-chart-simple"></i> Stats</a>
                <a href="?page=log_in" class="logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
            </div>
        </div>
    </div>
</nav>

<!-- SIDEBAR -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>
<aside class="sidebar" id="sidebar">
    <a href="?page=logged_in_page">🏠 Home</a>
    <button id="catToggle">☷ Categories <span id="catArrow" style="margin-left:auto;">▶</span></button>
    <div class="sub-menu" id="catMenu" style="display:none;">
        <a href="#">Bullseye Games</a>
        <a href="#">Casino</a>
        <a href="#">Markets</a>
    </div>
    <a href="#">🏆 Leaderboard</a>
    <a href="#">💬 Chat</a>
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

        <?php foreach ($collections as $collection): ?>
        <div class="game-row">
            <div class="game-row-header">
                <div class="game-row-info">
                    <div class="game-row-icon" style="background: <?php echo $collection['icon_bg']; ?>20; border-radius: 8px;">
                        <i class="<?php echo $collection['icon']; ?>"></i>
                    </div>
                    <div>
                        <div class="game-row-title"><?php echo $collection['title']; ?></div>
                        <div class="game-row-subtitle"><?php echo $collection['subtitle']; ?></div>
                    </div>
                </div>
                <a href="<?php echo $collection['link']; ?>" class="game-row-arrow">➔</a>
            </div>
            <div class="game-thumbs">
                <?php foreach ($collection['games'] as $game):
                    $link = '#';
                    if ($game['image'] === 'games/flip.jpg') $link = '?page=coin_flip';
                    elseif ($game['image'] === 'games/Dice.jpg') $link = '?page=dice';
                    elseif ($game['image'] === 'games/wheel.jpg') $link = '?page=wheel';
                    elseif ($game['image'] === 'games/roulette.jpg') $link = '?page=roulette';
                    elseif ($game['image'] === 'games/mines.jpg') $link = '?page=mines';
                    elseif ($game['image'] === 'games/rps.jpg') $link = '?page=rps';
                    elseif ($game['image'] === 'games/blackjack.jpg') $link = '?page=blackjack';
                ?>
                <a href="<?php echo $link; ?>" class="game-thumb" style="background-color: <?php echo $game['color']; ?>;">
                    <?php if (!empty($game['image'])): ?>
                        <img src="<?php echo $game['image']; ?>" alt="">
                    <?php endif; ?>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<script>
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
        catArrow.innerHTML = open ? '▶' : '▼';
    });
</script>

</body>
</html>
