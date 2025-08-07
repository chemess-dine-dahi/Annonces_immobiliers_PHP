<?php
session_start();
require_once 'bdd.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['listing_id'])) {
    $userId = $_SESSION['user']['id'];
    $listingId = (int) $_POST['listing_id'];

    $stmt = $pdo->prepare("INSERT IGNORE INTO favorite (user_id, listing_id) VALUES (:user_id, :listing_id)");
    $stmt->execute(['user_id' => $userId, 'listing_id' => $listingId]);
}

header('Location: index.php');
exit;
