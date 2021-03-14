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

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    ?>
    <header>
        <div class="table-headings">
            <a href="?path=projects">Projektai</a>
            <a href="?path=employees">Darbuotojai</a>
        </div>
        <div class="current-dir">
            <a class="project-manager-link" href="?path=project-manager">Projekto valdymas</a>
        </div>
    </header>
    <?php echo $conn_msg; ?>
    <?php
    if (isset($_GET['path'])) {
        if ($_GET['path'] == 'projects') {
            include 'projects.php';
        } else if ($_GET['path'] == 'employees') {
            include 'employees.php';
        } else if ($_GET['path'] == 'project-manager') {
            include 'project-manager.php';
        }
    }
    ?>
</body>

</html>