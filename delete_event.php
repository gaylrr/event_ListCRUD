<?php require "config.php";

$eID = $_GET['id'];

$eID = intval($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare(
        "UPDATE events SET delete_at = NOW() WHERE eID = ?"
    );
    $stmt->bind_param("i", $eID);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        $error = "Error deleting event.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Delete Event</title>

<style>
    body {
        font-family: Arial, sans-serif;
        background: #fff3e6;
        margin: 0;
        padding: 20px;
    }

    /* Modal Overlay */
    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.6);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Modal Box */
    .modal {
        background: linear-gradient(135deg, #FF6B35, #D7263D);
        padding: 30px;
        border-radius: 15px;
        max-width: 420px;
        width: 100%;
        color: #fff;
        text-align: center;
        box-shadow: 0 15px 35px rgba(0,0,0,0.3);
        animation: pop 0.3s ease;
    }

    @keyframes pop {
        from { transform: scale(0.9); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }

    .modal h2 {
        margin-top: 0;
        font-size: 1.6rem;
    }

    .modal p {
        margin: 15px 0 25px;
        line-height: 1.4;
    }

    /* Buttons */
    .modal-actions {
        display: flex;
        justify-content: center;
        gap: 15px;
    }

    .btn {
        padding: 10px 20px;
        border-radius: 50px;
        border: none;
        cursor: pointer;
        font-weight: bold;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .btn-delete {
        background: #FFD93D;
        color: #D7263D;
    }

    .btn-delete:hover {
        background: #fff;
    }

    .btn-cancel {
        background: rgba(255,255,255,0.2);
        color: #fff;
        text-decoration: none;
        line-height: 36px;
        padding: 0 20px;
    }

    .btn-cancel:hover {
        background: rgba(255,255,255,0.4);
    }

    .warning-icon {
        font-size: 3rem;
        margin-bottom: 10px;
    }

    .error {
        margin-top: 10px;
        color: #FFD93D;
        font-weight: bold;
    }
</style>
</head>

<body>

<div class="modal-overlay">
    <div class="modal">
        <div class="warning-icon">⚠️</div>
        <h2>Delete Event?</h2>
        <p>
            Are you sure you want to delete this event?<br>
            <strong>This action cannot be undone.</strong>
        </p>

        <form method="POST">
            <div class="modal-actions">
                <button type="submit" class="btn btn-delete">Yes, Delete</button>
                <a href="index.php" class="btn btn-cancel">Cancel</a>
            </div>
        </form>

        <?php if (!empty($error)): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>