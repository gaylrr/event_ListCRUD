<?php include("config.php"); 
$records_per_page = 6;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $records_per_page;

$search = isset($_GET['search']) ? $_GET['search'] : '';
$filterMonth = isset($_GET['filterMonth']) ? $_GET['filterMonth'] : '';

$whereClauses = ["delete_at IS NULL"];
if ($search !== '') {
    $search = $conn->real_escape_string($search);
    $whereClauses[] = "(eName LIKE '%$search%' OR eLocation LIKE '%$search%')";
}
if ($filterMonth !== '') {
    $filterMonth = (int)($filterMonth);
    $whereClauses[] = "MONTH(eDate) = '$filterMonth'";
}

$whereSQL = '';
if (count($whereClauses) > 0) {
    $whereSQL = "WHERE " . implode(' AND ', $whereClauses);
}

$sql = "SELECT COUNT(eID) FROM events $whereSQL";
$resultCount = $conn->query($sql);
$row = $resultCount->fetch_row();
$total_records = $row[0];
$total_pages = ceil($total_records / $records_per_page);

$sql = "SELECT * FROM events $whereSQL ORDER BY eDate ASC LIMIT $start, $records_per_page";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Event System</title>
<style>
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


    h1 {
        text-align: center;
        margin-bottom: 30px;
        color: #D7263D;
    }

    .btn-center {
        text-align: center;
        margin-bottom: 30px;
    }

    .btn-create {
        padding: 10px 20px;
        background-color: #FF6B35;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
        text-decoration: none;
    }

    .btn-create:hover {
        background-color: #D7263D;
    }
    .search-form { 
        text-align: center; 
        margin-bottom: 30px; 
    }
    .search-form input, .search-form select, .search-form button { 
        padding: 8px 12px; 
        margin: 5px; 
        border-radius: 5px; 
        border: 1px solid #ccc; 
    }
    .search-form button { 
        background-color: #FF6B35; 
        color: white; 
        border: none; 
        cursor: pointer; 
    }
    .search-form button:hover { 
        background-color: #D7263D; 
    }

    .postcard-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        margin: 0 auto;
        max-width: 1200px;
    }

    .postcard {
        background: linear-gradient(135deg, #FF6B35, #D7263D);
        border-radius: 15px;
        color: #fff;
        padding: 20px;
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-height: 250px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .postcard::before {
        content: "";
        position: absolute;
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: #FFD93D;
        top: -40px;
        right: -40px;
        opacity: 0.3;
    }

    .postcard h2 {
        margin: 0;
        font-size: 1.5rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .postcard p {
        font-size: 1rem;
        line-height: 1.4;
        margin: 15px 0;
    }

    .postcard .date {
        font-weight: bold;
        font-size: 1.1rem;
        background-color: #FFD93D;
        color: #D7263D;
        padding: 5px 12px;
        border-radius: 50px;
        width: fit-content;
    }

    .postcard .location {
        font-size: 0.9rem;
        opacity: 0.8;
    }

    .postcard .actions {
        margin-top: 10px;
    }

    .postcard .actions a {
        color: #fff;
        text-decoration: none;
        background-color: rgba(0,0,0,0.2);
        padding: 5px 10px;
        border-radius: 5px;
        margin-right: 5px;
        font-size: 0.9rem;
    }

    .postcard .actions a:hover {
        background-color: #FFD93D;
        color: #D7263D;
    }

    .postcard:hover {
        transform: scale(1.05);
        box-shadow: 0 15px 35px rgba(0,0,0,0.3);
    }

    /* Pagination */
    .pagination {
        text-align: center;
        margin: 30px 0;
    }

    .pagination a {
        color: #D7263D;
        padding: 10px 15px;
        margin: 0 5px;
        text-decoration: none;
        border: 1px solid #D7263D;
        border-radius: 5px;
    }

    .pagination a:hover {
        background-color: #D7263D;
        color: #fff;
    }

    .pagination a.active {
        background-color: #D7263D;
        color: #fff;
        pointer-events: none;
    }
</style>
</head>
<body>
<h1>Event List</h1>
<div class="btn-center">
    <a href="create_event.php" class="btn-create">New Event</a>
</div>

<form class="search-form" method="get" action="index.php">
    <input type="text" name="search" placeholder="Search events by Name or Location" value="<?= htmlspecialchars($search) ?>">
    <select name="filterMonth">
        <option value="">--Select Month --</option>
        <?php
        $months= [
             1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
            5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
            9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
            ];
            foreach($months as $num => $name) {
                $selected = ($filterMonth == $num) ? ' selected ' : '';
                echo"<option value='$num' $selected>$name</option>";

            }
            ?>
        </select>
        <button type="submit">Search</button>
</form>

<div class="events-wrapper">
    <div class="postcard-container">
        <?php if($result->num_rows > 0):?>
            <?php while($row = $result->fetch_assoc()): ?>
            <div class="postcard">
                <h2><?= $row['eName'] ?></h2>
                <p><?= $row['eDesc'] ?></p>
                <div class="date">
                    <?= date("M d, Y", strtotime($row['eDate'])) ?>
                        <span class="time"><?= date("h:i A", strtotime($row['eDate'])) ?></span>
                    </div>

                <div class="location"><?= $row['eLocation'] ?></div>
                <div class="actions">
                    <a href="edit_event.php?eID=<?= $row['eID'] ?>">Edit</a>
                    <a href="delete_event.php?id=<?= $row['eID'] ?>">Delete</a>
                </div>
            </div>
            <?php endwhile; ?>
        <?php else: ?>
                <p style="text-align:center; grid-column: 1 / -1;">No events found.</p>
        <?php endif; ?>
        </div>

    <div class="pagination">
        <?php
        for($i = 1; $i <= $total_pages; $i++) {
            $queryParams = $_GET;
            $queryParams['page'] = $i;
            $url = 'index.php?' . http_build_query($queryParams);
            echo "<a href='$url' class='" . ($i == $page ? 'active' : '') . "'>$i</a> ";
        }
        ?>
    </div>
</div>

</body>
</html>