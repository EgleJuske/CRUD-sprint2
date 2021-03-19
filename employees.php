<?php
$sql = "SELECT employees.id_employees, employees.firstname, projects.project_name FROM sprint2.employees
LEFT JOIN projects ON employees.id_projects = projects.id_projects ORDER BY id_employees;";
$result = mysqli_query($conn, $sql);
$buttons = '<form action="" method="POST">
                <button type="submit" class="btn btn-delete" name="delete" value="delete">Delete</button>
                <button type="submit" class="btn btn-update" name="update" value="update">Update</button>
            </form>';
?>
<h2>Darbuotojai</h2>
<table>
    <thead>
        <tr>
            <th>Id</th>
            <th>Vardas</th>
            <th>Projektas</th>
            <th>Veiksmai</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>" . $row["id_employees"] . "</td>
                        <td>" . $row["firstname"] . "</td>
                        <td>" . $row["project_name"] . "</td>
                        <td>" . $buttons . "</td>
                    </tr>";
            }
        }
        ?>
    </tbody>
</table>

<form class="add-form" action="" method="POST">
    <input type="text"><br>
    <button type="submit" class="btn btn-add" name="add-employee" value="add-employee">Add employee</button>
</form>