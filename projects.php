<?php
$sql = "SELECT projects.id_projects, projects.project_name, group_concat(employees.firstname SEPARATOR ', ') AS names
FROM projects
LEFT JOIN employees ON projects.id_projects = employees.id_projects
GROUP BY projects.id_projects";
$result = mysqli_query($conn, $sql);

// Add new project logic
if (isset($_POST['add-project'])) {
    $stmt = $conn->prepare("INSERT INTO projects (`project_name`) VALUES (?)");
    $stmt->bind_param('s', $_POST['new-project']);
    $stmt->execute();
    header('Location: ?path=projects');
    die();
}

// Delete project logic
if (isset($_POST['delete'])) {
    $stmt = $conn->prepare("DELETE FROM projects WHERE id_projects = ?");
    $stmt->bind_param('i', $_POST['delete']);
    $stmt->execute();
    header('Location: ?path=projects');
    die();
}

// Update project logic
if (isset($_POST['update-project'])) {
    $stmt = $conn->prepare("UPDATE projects SET project_name = ? WHERE id_projects = ?");
    $stmt->bind_param('si', $_POST['project-name'], $_POST['update-project']);
    $stmt->execute();
    header('Location: ?path=projects');
    die();
}

?>
<h2>Projektai</h2>
<table>
    <thead>
        <tr>
            <th>Id</th>
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
                            </form>
                            <form action="" method="POST">
                            <button type="submit" class="btn btn-update" name="update" value="' . $row["id_projects"] . '">Redaguoti</button>
                        </form>
                        </td>
                    </tr>';
            }
        }
        ?>
    </tbody>
</table>

<form class="add-form" action="" method="POST">
    <input type="text" name='new-project'><br>
    <button type="submit" class="btn btn-add" name="add-project" value="add-project">Pridėti projektą</button>
</form>

<?php
if (isset($_POST['update'])) {
    $id = $_POST['update'];
    $result = mysqli_query($conn, "SELECT * FROM projects WHERE id_projects = $id");

    // TODO: generate prepare statement

    if (mysqli_num_rows($result) > 0) {
        $row = $result->fetch_array();
        $project_name = $row['project_name'];
    }
    echo '<form class="update-form" action="" method="POST">
                <input type="number" name="id-projects" value="' . $id . '"><br>
                <input type="text" name="project-name" value="' . $project_name . '"><br>
                <button type="submit" class="btn btn-update" name="update-project" value="' . $_POST['update'] . '">Atnaujinti duomenis</button>
            </form>';
}
?>