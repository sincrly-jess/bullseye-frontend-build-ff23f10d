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
// Using reliable placeholders from placehold.co to show the "contain" effect
$collections = [
    [
        'icon'       => 'fa-solid fa-star',
        'icon_bg'    => '#ff1a1a', 
        'title'      => 'Favorited Games',
        'subtitle'   => '4 games',
        'link'=> '?page=favorites',
        'games'      => [
            // Example: Image fits inside, background color shows
            ['name' => '', 'color' => '#1cd111', 'image' => 'games/flip.jpg'],
            ['name' => '', 'color' => '#a124e8', 'image' => 'games/Dice.jpg'],
            ['name' => '', 'color' => '#f2a900', 'image' => 'games/wheel.jpg'],
            ['name' => '', 'color' => '#0d9e29', 'image' => 'games/roulette.jpg'],
            ['name' => '', 'color' => '#0d9e29', 'image' => 'games/blackjack.jpg'] // Blank image shows color fallback
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
    
    <style>
        /* --- GLOBAL STYLES --- */
        :root {
            --bg-dark: #121212;
            --card-bg: #222222;
            --accent-red: #eb1414;
            --text-main: #ffffff;
            --text-muted: #999999;
            --border-color: #333333;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: radial-gradient(circle at top center, #4a0000 0%, var(--bg-dark) 40%);
            background-color: var(--bg-dark);
            color: var(--text-main);
            min-height: 100vh;
            box-sizing: border-box;
        }

        /* --- SIDEBAR STYLES --- */
/*       .menu-toggle {
            position: relative;
            top: 0;
            left: 0;
            z-index: 10001;
            font-size: 20px;
            cursor: pointer;
            color: white;
            background: none;
            border: none;
            padding: 0;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            align-self: flex-start;
            margin-top: -3px;
            transition: color 0.2s;
        }
*/
        .menu-toggle:hover {
            color: var(--text-muted);
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 260px;
            background: #0f1114;
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
            background: rgba(0, 0, 0, 0.45);
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
            border-bottom: 1px solid #222;
            font-weight: bold;
            color: white;
        }

        .menu-item {
            display: block;
            padding: 14px 22px;
            cursor: pointer;
            color: #aaa;
            user-select: none;
            transition: 0.2s;
        }

        .menu-item:hover {
            background: #15181d;
            color: white;
        }

        .expandable::after {
            content: "▸";
            float: right;
            transition: transform 0.2s;
        }

        .expandable.active::after {
            transform: rotate(90deg);
            color: #EB1414;
        }

        .submenu {
            background: #121417;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.25s ease;
        }

        .submenu a {
            display: block;
            padding: 10px 40px;
            text-decoration: none;
            color: #888;
        }

        .submenu a:hover {
            color: #EB1414;
        }

        .submenu.show {
            max-height: 400px;
        }

        /* --- NAVIGATION BAR --- */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
            background-color: transparent; /* Seamless with body */

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
        }
        
        .nav-left i:hover {
            color: var(--text-muted);
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

        .nav-left i {
            font-size: 20px;
            margin-right: 20px;
            cursor: pointer;
            color: var(--text-white);
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
            font-size: 15px;
            color: var(--text-muted);
        }

        .avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            overflow: hidden;
            border: 2px solid transparent;
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
            background-color: #2a2a2a;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            width: 200px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.5);
            display: none; 
            flex-direction: column;
            overflow: hidden;
            z-index: 100;
        }

        .profile-dropdown.show {
            display: flex; 
        }

        .dropdown-item {
            padding: 12px 20px;
            color: var(--text-main);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            transition: background 0.2s;
            border-bottom: 1px solid var(--border-color);
        }

        .dropdown-item:last-child {
            border-bottom: none;
        }

        .dropdown-item:hover {
            background-color: #383838;
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
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
        }

        /* --- HERO SECTION --- */
        .hero-section {
            text-align: center;
            margin-bottom: 40px;
            margin-top: 10px;
        }

        .hero-title {
            font-size: 40px;
            margin: 0;
            font-weight: 700;
            line-height: 1.2;
        }

        .hero-subtitle {
            margin-top: 10px;
            font-size: 14px;
            color: var(--text-muted);
        }

        /* --- COLLECTIONS CARDS --- */
        .collections-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .collection-card {
            background-color: var(--card-bg);
            border-radius: 12px;
            padding: 25px;
            display: flex;
            align-items: flex-start;
            gap: 20px;
            cursor: pointer;
            transition: background 0.2s;
            position: relative;
        }

        .collection-card:hover {
            background-color: #2e2e2e;
        }

        .card-icon-container {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 22px;
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
            margin-bottom: 15px;
        }

        .card-title-box h3 {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
        }

        .card-title-box p {
            margin: 4px 0 0 0;
            font-size: 13px;
            color: var(--text-muted);
        }

        .chevron {
            color: var(--text-muted);
            font-size: 16px;
            position: absolute;
            right: 25px;
            top: 30px;
        }

        /* --- Game Thumbnails Update --- */
        .games-row {
            display: flex;
            gap: 12px;
        }

        .game-thumb {
            width: 75px;
            height: 100px;
            border-radius: 8px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-size: 9px;
            font-weight: 800;
            text-align: center;
            color: white;
            box-shadow: inset 0 -12px 15px rgba(0,0,0,0.25);
            overflow: hidden; 
            position: relative; 
            transition: transform 0.2s ease-in-out;
        }
        
        .game-thumb:hover {
            transform: scale(1.15);
        }

        .game-thumb img {
            width: 100%;
            height: 100%;
            /* CHANGE: 'contain' makes the image fit inside the box */
            object-fit: fill; 
            position: absolute;
            top: 0;
            left: 0;
            z-index: 1;
        }

        .game-thumb span {
            margin-top: 5px;
            z-index: 2;
            position: relative;
            /* Optional: Add a slight shadow to make text readable over images */
            text-shadow: 0 1px 2px rgba(0,0,0,0.8);
        }
    </style>
</head>
<body>

    <?php include __DIR__ . "/side_menu.html"; ?>
    <?php include __DIR__ . "/header.php"; ?>

    <div class="container">
        <div class="hero-section">
            <h1 class="hero-title">Welcome to<br>Bullseye</h1>
            <p class="hero-subtitle">Browse collections</p>
        </div>

        <div class="collections-list">
            <?php foreach ($collections as $collection): ?>
                <div class="collection-link">
                    <div class="collection-card">
                        <a href="<?php echo $collection['link']; ?>" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 0;"></a>
                        <div class="card-icon-container" style="background-color: <?php echo $collection['icon_bg']; ?>;">
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