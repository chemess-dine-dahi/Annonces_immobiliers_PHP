<?php
require_once 'bdd.php';
session_start();

if (!isset($_SESSION['user']) || !isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = (int) $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM listing WHERE id = ?");
$stmt->execute([$id]);
$annonce = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$annonce) {
    echo "Annonce introuvable.";
    exit;
}

if ($_SESSION['user']['role'] !== 'admin' && $_SESSION['user']['id'] !== $annonce['user_id']) {
    echo "Suppression non autorisée.";
    exit;
}

$stmt = $pdo->prepare("DELETE FROM listing WHERE id = ?");
$stmt->execute([$id]);

header('Location: index.php');
exit;
