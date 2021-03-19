<?php
$sql = "SELECT projects.id_projects, projects.project_name, group_concat(employees.firstname SEPARATOR ', ') AS names
FROM projects
LEFT JOIN employees ON projects.id_projects = employees.id_projects
GROUP BY projects.id_projects";
$result = mysqli_query($conn, $sql);

// Add new project logic
if (isset($_POST['add-project'])) {
    $stmt = $conn->prepare("INSERT INTO projects (`project_name`) VALUES (?)");
    $stmt->bind_param("s", $_POST['new-project']);
    $stmt->execute();
    header('Location: ?path=projects');
    die();
}

// Delete project logic
if (isset($_POST['delete'])) {
    echo 'delete set';
    $stmt = $conn->prepare("DELETE FROM projects WHERE id_projects = ?");
    $stmt->bind_param("i", $_POST['delete']);
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
                                <button type="submit" class="btn btn-delete" name="delete" value="' . $row["id_projects"] . '">Delete</button>
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
    <button type="submit" class="btn btn-add" name="add-project" value="add-project">Add project</button>
</form>