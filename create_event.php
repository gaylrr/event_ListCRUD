<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Event</title>
    <style>
        /* Base Styles */
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

        .header a.home-icon:hover {
            color: #FF6B35;
        }

        form {
            max-width: 600px;
            margin: 0 auto;
            background: linear-gradient(135deg, #FF6B35, #D7263D);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            color: white;
        }

        form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        form input[type="text"],
        form input[type="datetime-local"],
        form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            box-sizing: border-box;
        }

        form textarea {
            resize: vertical;
            min-height: 100px;
        }

        form input[type="text"]:focus,
        form input[type="datetime-local"]:focus,
        form textarea:focus {
            outline: 2px solid #FFD93D;
        }

        button.btn {
            display: inline-block;
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

        button.btn:hover {
            background-color: #fff;
            color: #D7263D;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .home-icon::before {
            content: "🏠"; /* Unicode house emoji */
        }

        @media (max-width: 640px) {
            form {
                padding: 20px;
            }
        }
    </style>
</head>
<body>

<div class="header">
    <h1>
        <a href="index.php" class="home-icon"></a>
        New Event
    </h1>
</div>

<form action="insert_event.php" method="POST">
    <label for="eName">Event Name</label>
    <input type="text" id="eName" name="eName" required>

    <label for="eDate">Event Date</label>
    <input type="datetime-local" id="eDate" name="eDate" required>

    <label for="eLocation">Event Location</label>
    <input type="text" id="eLocation" name="eLocation" required>

    <label for="eDesc">Event Description</label>
    <textarea id="eDesc" name="eDesc" required></textarea>

    <button type="submit" class="btn">Add Event</button>
</form>

</body>
</html>
