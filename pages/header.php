<?php
$avatar_url = $avatar_url ?? 'https://ui-avatars.com/api/?name=Guest&background=random&color=fff';
$username = $user_data['username'] ?? 'Guest';
?>
<nav class="navbar">
    <div class="nav-left">
        <i class="fa-solid fa-bars menu-toggle" id="menuToggle"></i>
        <i class="fa-solid fa-bell"></i>
    </div>
    <div class="nav-center">
        <a href="?page=logged_in_page" class="logo-placeholder">
            <img src="images/bullseye-logo.png" alt="Bullseye">
        </a>
    </div>
    <div class="nav-right">
        <div class="profile-trigger" id="profileTrigger">
            <span class="username"><?php echo htmlspecialchars($username); ?></span>
            <div class="avatar">
                <img src="<?php echo $avatar_url; ?>" alt="Profile">
            </div>
        </div>
        <div class="profile-dropdown" id="profileDropdown">
            <a href="?page=profile_page" class="dropdown-item"><i class="fa-solid fa-user"></i> View Profile</a>
            <a href="#" class="dropdown-item"><i class="fa-solid fa-user-group"></i> Friends</a>
            <a href="#" class="dropdown-item"><i class="fa-solid fa-gift"></i> Rewards</a>
            <a href="#" class="dropdown-item"><i class="fa-solid fa-comment"></i> Chat</a>
            <a href="#" class="dropdown-item"><i class="fa-solid fa-chart-simple"></i> Stats</a>
            <a href="?page=log_in" class="dropdown-item logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
        </div>
    </div>
</nav>

<script>
    const profileTrigger = document.getElementById('profileTrigger');
    const profileDropdown = document.getElementById('profileDropdown');
    profileTrigger.addEventListener('click', () => profileDropdown.classList.toggle('show'));
    document.addEventListener('mousedown', (e) => {
        if (!profileTrigger.contains(e.target) && !profileDropdown.contains(e.target)) {
            profileDropdown.classList.remove('show');
        }
    });
</script>
