<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Projects CRUD app</title>
</head>

<body>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "mysql";
    $dbname = "sprint2";
    $conn_msg = "";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    } else {
        $conn_msg = '<div style="color: green">Connected successfully</div>';
    }
    ?>
    <header>
        <div class="table-headings">
            <a href="#">Projektai</a>
            <a href="#">Darbuotojai</a>
        </div>
        <div class="current-dir">
            <h3>Projekto valdymas</h3>
        </div>
    </header>
    <?php echo $conn_msg; ?>

    <?php
    $sql = "SELECT * FROM employees";
    $result = mysqli_query($conn, $sql);
    ?>
    <table>
        <thead>
            <th>Id</th>
            <th>Name</th>
            <th>Projektai</th>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>" . $row["id_employees"] . "</td>
                            <td>" . $row["firstname"] . "</td>
                            <td>" . $row["lastname"] . "</td>
                        </tr>";
                }
            }
            ?>
        </tbody>
    </table>
</body>

</html>