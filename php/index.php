<?php
$page = $_GET['page'] ?? 'homepage';

$allowed_pages = ['log_in', 'create_account', 'logged_in_page', 'profile_page', 'homepage', 'favorites', 'freq_played', 'pop_games', 'trending'];

if (!in_array($page, $allowed_pages)) {
    $page = 'homepage';
}

include "pages/$page.php";
?>
