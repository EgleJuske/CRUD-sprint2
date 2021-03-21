<?php
$sql = "SELECT employees.id_employees, employees.firstname, projects.project_name FROM employees
LEFT JOIN projects ON employees.id_projects = projects.id_projects ORDER BY id_employees";
$result = mysqli_query($conn, $sql);

// Add new employee logic
if (isset($_POST['add-employee'])) {
    $stmt = $conn->prepare("INSERT INTO employees (`firstname`) VALUES (?)");
    $stmt->bind_param('s', $_POST['new-employee']);
    $stmt->execute();
    header('Location: ?path=employees');
    die();
}

// Delete employee logic
if (isset($_POST['delete'])) {
    $stmt = $conn->prepare("DELETE FROM employees WHERE id_employees = ?");
    $stmt->bind_param('i', $_POST['delete']);
    $stmt->execute();
    header('Location: ?path=employees');
    die();
}

// Update employee logic
if (isset($_POST['update-employee'])) {
    if ($_POST['id-project'] == 0) {
        $stmt = $conn->prepare("UPDATE employees SET firstname = ?, id_projects = NULL WHERE id_employees = ?");
        $stmt->bind_param('si', $_POST['employee-name'], $_POST['update-employee']);
        $stmt->execute();
        header('Location: ?path=employees');
        die();
    } else {
        $stmt = $conn->prepare("UPDATE employees SET firstname = ?, id_projects = ? WHERE id_employees = ?");
        $stmt->bind_param('sii', $_POST['employee-name'], $_POST['id-project'], $_POST['update-employee']);
        $stmt->execute();
        header('Location: ?path=employees');
        die();
    }
}
?>
<h2>Darbuotojai</h2>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Vardas</th>
            <th>Projektas</th>
            <th>Veiksmai</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>
                        <td>' . $row["id_employees"] . '</td>
                        <td>' . $row["firstname"] . '</td>
                        <td>' . $row["project_name"] . '</td>
                        <td>
                            <form action="" method="POST">
                                <button type="submit" class="btn btn-delete" name="delete" value="' . $row["id_employees"] . '">Ištrinti</button>
                                <button type="submit" class="btn btn-update" name="update" value="' . $row["id_employees"] . '">Redaguoti</button>
                        </form>
                        </td>
                    </tr>';
            }
        }
        ?>
    </tbody>
</table>

<form class="add-form" action="" method="POST">
    <input type="text" name="new-employee" placeholder="Darbuotojo vardas"><br>
    <button type="submit" class="btn btn-submit" name="add-employee" value="add-employee">Pridėti darbuotoją</button>
</form>

<?php
if (isset($_POST['update'])) {
    $id_empl = $_POST['update'];

    $stmt = $conn->prepare("SELECT * FROM employees WHERE id_employees = ?");
    $stmt->bind_param('i', $id_empl);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if (mysqli_num_rows($result) > 0) {
        $row = $result->fetch_array();
        $firstname = $row['firstname'];
        $id_proj = $row['id_projects'];
    }
    echo '<form class="update-form" action="" method="POST">
                <label for="empl-name">Darbuotojo ID: ' . $id_empl . '</label><br>
                <input type="text" id="empl-name" name="employee-name" value="' . $firstname . '">
                <select name="id-project">';

    $stmt = $conn->prepare("SELECT * FROM projects");
    $stmt->bind_param();
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if (mysqli_num_rows($result) > 0) {
        echo '<option value="unlink"></option>';
        while ($row = mysqli_fetch_assoc($result)) {
            $selected = '';
            if ($id_proj === $row['id_projects']) {
                $selected = 'selected';
            }
            echo '<option value="' . $row['id_projects'] . '"' . $selected . '>' . $row['project_name'] . '</option>';
        }
    }
    echo '</select><br>
            <button type="submit" class="btn btn-submit" name="update-employee" value="' . $id_empl . '">Atnaujinti duomenis</button>
            </form>';
}
?>