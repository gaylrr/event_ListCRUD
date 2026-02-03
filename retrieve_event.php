<?php
require "config.php";

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$eID = intval($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare(
        "UPDATE events SET delete_at = NULL WHERE eID = ?"
    );
    $stmt->bind_param("i", $eID);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        $error = "Error restoring event.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Restore Event</title>

<style>
/* ===== Base ===== */
body {
    font-family: Arial, sans-serif;
    background: #fff;
    margin: 0;
    padding: 0;
    color: #222;
}

/* ===== Header ===== */
.header {
    background: linear-gradient(135deg, #FF6B35, #D7263D);
    padding: 20px;
    color: #fff;
    display: flex;
    align-items: center;
    gap: 10px;
}

.header a {
    color: #FFD93D;
    text-decoration: none;
    font-size: 1.5rem;
}

.header h1 {
    margin: 0;
    font-size: 1.6rem;
}

/* ===== Card ===== */
.card {
    max-width: 500px;
    margin: 60px auto;
    background: #fff;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    text-align: center;
}

.card p {
    font-size: 1.1rem;
    margin-bottom: 25px;
}

/* ===== Buttons ===== */
.btn {
    padding: 10px 20px;
    border: none;
    border-radius: 6px;
    font-size: 14px;
    cursor: pointer;
    margin: 5px;
}

.btn.restore {
    background: #FF6B35;
    color: #fff;
}

.btn.restore:hover {
    background: #D7263D;
}

.btn.cancel {
    background: #eee;
    color: #333;
}

.btn.cancel:hover {
    background: #ccc;
}

/* ===== Modal ===== */
.modal {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.5);
    justify-content: center;
    align-items: center;
}

.modal-content {
    background: #fff;
    padding: 25px;
    border-radius: 12px;
    max-width: 400px;
    width: 90%;
    text-align: center;
    animation: pop 0.3s ease;
}

.modal-content h2 {
    color: #D7263D;
    margin-bottom: 10px;
}

.modal-content p {
    margin-bottom: 20px;
}
</style>
</head>

<body>

<!-- Header -->
<div class="header">
    <a href="index.php">🏠</a>
    <h1>Restore Event</h1>
</div>

<!-- Restore Card -->
<div class="card">
    <p>Do you want to restore this event back to the list?</p>

    <button class="btn restore" onclick="openModal()">Restore Event</button>
    <a href="index.php">
        <button class="btn cancel">Cancel</button>
    </a>
</div>

<!-- Confirmation Modal -->
<div class="modal" id="confirmModal">
    <div class="modal-content">
        <h2>Confirm Restore</h2>
        <p>This event will be visible again in the event list.</p>

        <form method="POST">
            <button type="submit" class="btn restore">Yes, Restore</button>
            <button type="button" class="btn cancel" onclick="closeModal()">No</button>
        </form>
    </div>
</div>

</body>
</html>
