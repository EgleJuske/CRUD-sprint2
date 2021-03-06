<?php
$sql = "SELECT projects.id_projects, projects.project_name, group_concat(employees.firstname SEPARATOR ', ') AS names
FROM projects
LEFT JOIN employees ON projects.id_projects = employees.id_projects
GROUP BY projects.id_projects";
$result = mysqli_query($conn, $sql);
$msg = '';

// Add new project logic
if (isset($_POST['add-project'])) {
    if (empty($_POST['new-project'])) {
        $msg = '<div style="color: red">Projekto pavadinimas negali būti tuščias</div>';
    } else {
        $stmt = $conn->prepare("INSERT INTO projects (`project_name`) VALUES (?)");
        $stmt->bind_param('s', $_POST['new-project']);
        $stmt->execute();
        header('Location: ' . $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'] . '');
        die();
    }
}

// Delete project logic
if (isset($_POST['delete'])) {
    $stmt = $conn->prepare("DELETE FROM projects WHERE id_projects = ?");
    $stmt->bind_param('i', $_POST['delete']);
    $stmt->execute();
    header('Location: ' . $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'] . '');
    die();
}

// Update project logic
if (isset($_POST['cancel'])) {
    unset($_POST['update-project']);
}

if (isset($_POST['update-project'])) {
    if ($_POST['project-name'] === '') {
        $msg = '<div style="color: red">Projekto pavadinimas negali būti tuščias</div>';
    } else {
        echo 'project name' . $_POST['project-name'];
        $stmt = $conn->prepare("UPDATE projects SET project_name = ? WHERE id_projects = ?");
        $stmt->bind_param('si', $_POST['project-name'], $_POST['update-project']);
        $stmt->execute();
        header('Location: ' . $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'] . '');
        die();
    }
}

?>
<h2>Projektai</h2>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Projektas</th>
            <th>Darbuotojai</th>
            <th>Veiksmai</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>
                        <td>' . $row["id_projects"] . '</td>
                        <td>' . $row["project_name"] . '</td>
                        <td>' . $row["names"] . '</td>
                        <td>
                            <form action="" method="POST">
                                <button type="submit" class="btn btn-delete" name="delete" value="' . $row["id_projects"] . '">Ištrinti</button>
                                <button type="submit" class="btn btn-update" name="update" value="' . $row["id_projects"] . '">Redaguoti</button>
                        </form>
                        </td>
                    </tr>';
            }
        }
        ?>
    </tbody>
</table>
<?php
if (!isset($_POST['update'])) {
    echo '<form class="add-form" action="" method="POST">
            <input type="text" name="new-project" placeholder="Projekto pavadinimas"><br>
            <button type="submit" class="btn btn-submit" name="add-project" value="add-project">Pridėti projektą</button>
        </form>';
} else {
    $id = $_POST['update'];
    $stmt = $conn->prepare("SELECT * FROM projects WHERE id_projects = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if (mysqli_num_rows($result) > 0) {
        $row = $result->fetch_array();
        $project_name = $row['project_name'];
    }

    echo '<form class="update-form" action="" method="POST">
                <label for="pr-name">Projekto ID: ' . $id . '</label><br>
                <input type="text" id="pr-name" name="project-name" value="' . $project_name . '"><br>
                <button type="submit" class="btn btn-submit" name="update-project" value="' . $id . '">Atnaujinti duomenis</button>
                <button type="submit" class="btn btn-cancel" name="cancel">Atšaukti</button>
            </form>';
}
echo $msg;
?>