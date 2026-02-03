<?php require "config.php";

if (!isset($_GET['eID'])) {
    header("Location: index.php");
    exit();
}

$eID = intval($_GET['eID']);

$sql = $conn->prepare("SELECT * FROM events WHERE eID = ?");
$sql -> bind_param("i", $eID);
$sql->execute();
$result = $sql->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
} else {
    die("Event not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
</head>

<body>
    <style>
        <style>
    /* Base */
    body {
        font-family: Arial, sans-serif;
        background: #fff3e6;
        margin: 0;
        padding: 20px;
        color: #222;
    }

    .header {
        text-align: center;
        margin-bottom: 30px;
    }

    .header h1 {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        color: #D7263D;
        font-size: 2rem;
        margin: 0;
    }

    .header a.home-icon {
        text-decoration: none;
        color: #D7263D;
        font-size: 2rem;
        transition: color 0.3s;
    }

    .home-icon {
        text-decoration: none;
        font-size: 1.8rem;
        color: #D7263D;
        transition: color 0.3s ease;
    }

    .home-icon:hover {
        color: #FF6B35;
    }

    .home-icon::before {
        content: "🏠";
    }

    form {
        max-width: 600px;
        margin: 0 auto;
        background: linear-gradient(135deg, #FF6B35, #D7263D);
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        color: #fff;
    }

    label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
    }

    input[type="text"],
    input[type="datetime-local"],
    textarea {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        box-sizing: border-box;
    }

    textarea {
        resize: vertical;
        min-height: 100px;
    }

    input:focus,
    textarea:focus {
        outline: 2px solid #FFD93D;
    }

    .btn {
        background-color: #FFD93D;
        color: #D7263D;
        font-weight: bold;
        padding: 12px 25px;
        border: none;
        border-radius: 50px;
        cursor: pointer;
        font-size: 16px;
        transition: all 0.3s ease;
    }

    .btn:hover {
        background-color: #fff;
        color: #D7263D;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    @media (max-width: 640px) {
        form {
        padding: 20px;
        }
    }
    .home-icon::before {
        content: "🏠"; 
        }

    @media (max-width: 640px) {
        form {
                padding: 20px;
            }
        }
</style>
</head>
</body>

<div class="header">
    <h1>
        <a href="index.php" class="home-icon"></a>
        Edit Event Information
    </h1>
</div>

<form action="update_event.php" method="POST">
    <input type="hidden" name="eID" value="<?= $row['eID']; ?>">

    <label>Event Name:</label>
    <input type="text" name="eName" value="<?= htmlspecialchars($row['eName']); ?>" required>

    <label>Event Date:</label>
    <input type="datetime-local" name="eDate" value="<?= $row['eDate']; ?>" required>

    <label>Event Location:</label>
    <input type="text" name="eLocation" value="<?= htmlspecialchars($row['eLocation']); ?>" required>

    <label>Event Description:</label>
    <textarea name="eDesc" required><?= htmlspecialchars($row['eDesc']); ?></textarea>

    <input type="submit" value="Update Event" class="btn">
</form>
</body>
</html>
