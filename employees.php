<?php
$sql = "SELECT employees.id_employees, employees.firstname, projects.project_name FROM sprint2.employees
LEFT JOIN projects ON employees.id_projects = projects.id_projects ORDER BY id_employees;";
$result = mysqli_query($conn, $sql);
?>
<h2>Darbuotojai</h2>
<table>
    <thead>
        <tr>
            <th>Id</th>
            <th>Vardas</th>
            <th>Projektas</th>
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
                    </tr>";
            }
        }
        ?>
    </tbody>
</table>