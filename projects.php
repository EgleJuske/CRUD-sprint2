<?php
$sql = "SELECT projects.id_projects, projects.project_name, employees.firstname FROM projects
        LEFT JOIN employees ON projects.id_projects = employees.id_projects";
$result = mysqli_query($conn, $sql);
?>
<h2>Projektai</h2>
<table>
    <thead>
        <tr>
            <th>Id</th>
            <th>Projektas</th>
            <th>Darbuorojai</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>" . $row["id_projects"] . "</td>
                        <td>" . $row["project_name"] . "</td>
                        <td>" . $row["firstname"] . "</td>
                    </tr>";
            }
        }
        ?>
    </tbody>
</table>