<?php
// --- BACKEND DATA SIMULATION ---
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

// Array containing the data for the collections
$collections = [
    [
        'icon'       => 'fa-solid fa-star',
        'icon_bg'    => '#ff1a1a', 
        'title'      => 'Favorited Games',
        'subtitle'   => '4 games',
        'link'=> '?page=favorites',
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
        'link'=> '?page=freq_played',        
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
        'link'=> '?page=pop_games',
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
        'link'=> '?page=trending',
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Orbitron:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <style>
        /* --- GLOBAL STYLES --- */
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --bg-dark: hsl(0,0%,5%);
            --card-bg: rgba(255,255,255,0.05);
            --card-bg-hover: rgba(255,255,255,0.1);
            --accent-red: #eb1414;
            --text-main: hsl(0,0%,95%);
            --text-muted: hsl(0,0%,55%);
            --border-color: hsl(0,0%,16%);
            --glow-red: 0,100%,50%;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            -webkit-font-smoothing: antialiased;
            background: var(--bg-dark);
            background-image: url('images/background-3.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: var(--text-main);
            min-height: 100vh;
        }

        h1, h2, h3 { font-family: 'Orbitron', sans-serif; }
        a { color: inherit; text-decoration: none; }

        /* --- SIDEBAR STYLES --- */
        .menu-toggle:hover {
            color: var(--text-muted);
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 260px;
            background: rgba(15,17,20,0.85);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border-right: 1px solid var(--border-color);
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            z-index: 10000;
            box-shadow: 4px 0 25px rgba(0,0,0,0.7);
            overflow-y: auto;
        }

        .sidebar.open {
            transform: translateX(0);
        }

        .sidebar-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.5);
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
            z-index: 9999;
        }

        .sidebar-backdrop.show {
            opacity: 1;
            pointer-events: auto;
        }

        body.sidebar-open .navbar,
        body.sidebar-open .container {
            transform: translateX(260px);
            transition: transform 0.3s ease;
        }

        .logo {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid var(--border-color);
            font-weight: bold;
            color: white;
            font-family: 'Orbitron', sans-serif;
            text-shadow: 0 0 15px hsla(var(--glow-red),0.5);
        }

        .menu-item {
            display: block;
            padding: 14px 22px;
            cursor: pointer;
            color: var(--text-muted);
            user-select: none;
            transition: 0.2s;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
        }

        .menu-item:hover {
            background: rgba(255,255,255,0.05);
            color: white;
        }

        .expandable::after {
            content: "▸";
            float: right;
            transition: transform 0.2s;
        }

        .expandable.active::after {
            transform: rotate(90deg);
            color: var(--accent-red);
        }

        .submenu {
            background: rgba(0,0,0,0.2);
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.25s ease;
        }

        .submenu a {
            display: block;
            padding: 10px 40px;
            text-decoration: none;
            color: var(--text-muted);
            font-size: 13px;
        }

        .submenu a:hover {
            color: var(--accent-red);
        }

        .submenu.show {
            max-height: 400px;
        }

        /* --- NAVIGATION BAR --- */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 50;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 30px;
            height: 56px;
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border-bottom: 1px solid var(--border-color);
            transition: transform 0.3s ease;
        }

        .nav-left {
            display: flex;
            gap: 25px;
            font-size: 20px;
            color: var(--text-main);
        }

        .nav-left i {
            cursor: pointer;
            transition: color 0.2s;
            color: var(--text-muted);
        }
        
        .nav-left i:hover {
            color: var(--text-main);
        }

        .nav-center .logo-placeholder {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .nav-center .logo-placeholder img {
            width: 65px;
            max-height: 45px;
            object-fit: cover;
            display: block;
        }

        /* Profile & Dropdown Styles */
        .nav-right {
            position: relative;
        }

        .profile-trigger {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            padding: 5px;
            border-radius: 20px;
            transition: background 0.2s;
        }

        .profile-trigger:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .username {
            font-size: 14px;
            color: var(--text-muted);
        }

        .avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            overflow: hidden;
            border: 1px solid var(--border-color);
        }

        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Dropdown Menu */
        .profile-dropdown {
            position: absolute;
            top: 110%;
            right: 0;
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            width: 220px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            display: none; 
            flex-direction: column;
            overflow: hidden;
            z-index: 100;
            padding: 8px;
        }

        .profile-dropdown.show {
            display: flex; 
        }

        .wallet-display {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px;
            border-radius: 8px;
            background: rgba(255,215,0,0.1);
            border: 1px solid rgba(255,215,0,0.3);
            font-weight: 700;
            font-size: 15px;
            color: #ffd700;
            margin-bottom: 4px;
        }

        .dropdown-item {
            padding: 10px 12px;
            color: var(--text-main);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            transition: background 0.2s;
            border-radius: 8px;
        }

        .dropdown-item:hover {
            background: rgba(255,255,255,0.1);
        }

        .dropdown-item i {
            width: 16px;
            text-align: center;
            color: var(--text-muted);
        }

        .dropdown-item.logout {
            color: #ff4a4a;
        }
        .dropdown-item.logout i {
            color: #ff4a4a;
        }

        /* --- MAIN CONTENT --- */
        .container {
            max-width: 672px;
            margin: 0 auto;
            padding: 20px 16px;
            padding-top: 56px;
            transition: transform 0.3s ease;
        }

        /* --- HERO SECTION --- */
        .hero-section {
            text-align: center;
            margin-bottom: 40px;
            margin-top: 24px;
        }

        .hero-title {
            font-size: 40px;
            margin: 0;
            font-weight: 900;
            line-height: 1.2;
            letter-spacing: 0.1em;
        }

        .hero-title-glow {
            text-shadow: 0 0 20px hsla(var(--glow-red),0.6), 0 0 40px hsla(var(--glow-red),0.3);
            font-size: 3.5rem;
        }

        .hero-subtitle {
            margin-top: 10px;
            font-size: 1.5rem;
            font-weight: 700;
            font-family: 'Orbitron', sans-serif;
            color: var(--text-main);
            text-shadow: 0 0 15px hsla(var(--glow-red),0.4);
        }

        /* --- COLLECTIONS CARDS --- */
        .collections-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .collection-card {
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 16px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            cursor: pointer;
            transition: background 0.2s;
            position: relative;
        }

        .collection-card:hover {
            background: rgba(255,255,255,0.1);
        }

        .card-icon-container {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 18px;
            color: white;
            flex-shrink: 0;
        }

        .card-content {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .card-header-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .card-title-box h3 {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
        }

        .card-title-box p {
            margin: 2px 0 0 0;
            font-size: 12px;
            color: var(--text-muted);
        }

        .chevron {
            color: var(--text-muted);
            font-size: 16px;
            position: absolute;
            right: 16px;
            top: 20px;
            transition: color 0.2s;
        }

        .collection-card:hover .chevron {
            color: var(--text-main);
        }

        /* --- Game Thumbnails --- */
        .games-row {
            display: flex;
            gap: 12px;
            overflow-x: auto;
            padding-bottom: 4px;
        }

        .game-thumb {
            width: 56px;
            height: 56px;
            border-radius: 8px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-size: 9px;
            font-weight: 800;
            text-align: center;
            color: white;
            overflow: hidden; 
            position: relative;
            flex-shrink: 0;
            border: 1px solid var(--border-color);
            transition: transform 0.3s ease-in-out;
        }
        
        .game-thumb:hover {
            transform: scale(1.5);
            z-index: 10;
        }

        .game-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover; 
            position: absolute;
            top: 0;
            left: 0;
            z-index: 1;
        }

        .game-thumb span {
            margin-top: 5px;
            z-index: 2;
            position: relative;
            text-shadow: 0 1px 2px rgba(0,0,0,0.8);
        }

        @media (min-width: 768px) {
            .hero-title-glow { font-size: 4.5rem; }
            .hero-subtitle { font-size: 1.75rem; }
        }

        @media (max-width: 640px) {
            .username { display: none; }
        }
    </style>
</head>
<body>

    <?php include __DIR__ . "/side_menu.html"; ?>
    <?php include __DIR__ . "/header.php"; ?>

    <div class="container">
        <div class="hero-section">
            <h1 class="hero-title">Welcome to<br><span class="hero-title-glow">BULLSEYE</span></h1>
            <p class="hero-subtitle">Browse Collections</p>
        </div>

        <div class="collections-list">
            <?php foreach ($collections as $collection): ?>
                <div class="collection-link">
                    <div class="collection-card">
                        <a href="<?php echo $collection['link']; ?>" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 0;"></a>
                        <div class="card-icon-container" style="background-color: <?php echo $collection['icon_bg']; ?>20;">
                            <i class="<?php echo $collection['icon']; ?>"></i>
                        </div>

                        <div class="card-content">
                            <div class="card-header-row">
                                <div class="card-title-box">
                                    <h3><?php echo $collection['title']; ?></h3>
                                    <p><?php echo $collection['subtitle']; ?></p>
                                </div>
                                <i class="fa-solid fa-chevron-right chevron"></i>
                            </div>

                            <div class="games-row">
                                <?php foreach ($collection['games'] as $game): ?>
                                    <?php
                                        $link = '#';

                                        if ($game['image'] === 'games/flip.jpg') {
                                            $link = '?page=coin_flip';
                                        } elseif ($game['image'] === 'games/Dice.jpg') {
                                            $link = '?page=dice';
                                        } elseif ($game['image'] === 'games/wheel.jpg') {
                                            $link = '?page=wheel';
                                        } elseif ($game['image'] === 'games/roulette.jpg') {
                                            $link = '?page=roulette';
                                        } elseif ($game['image'] === 'games/mines.jpg') {
                                            $link = '?page=mines';
                                        } elseif ($game['image'] === 'games/rps.jpg') {
                                            $link = '?page=rps';
                                        } elseif ($game['image'] === 'games/blackjack.jpg') {
                                            $link = '?page=blackjack';
                                        }
                                    ?>

                                    <a href="<?php echo $link; ?>" 
                                    class="game-thumb" 
                                    style="background-color: <?php echo $game['color']; ?>; text-decoration: none; color: inherit;">

                                        <?php if (!empty($game['image'])): ?>
                                            <img src="<?php echo $game['image']; ?>" alt="">
                                        <?php endif; ?>

                                        <span><?php echo $game['name']; ?></span>

                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</body>
</html>
