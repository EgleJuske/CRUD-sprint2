<?php
$sql = "SELECT * FROM employees_projects";
$result = mysqli_query($conn, $sql);
?>
<h2>Darbuotojai</h2>
<table>
    <thead>
        <th>Id</th>
        <th>Vardas</th>
        <th>Projektas</th>
    </thead>
    <tbody>
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>" . $row["id"] . "</td>
                        <td>" . $row["id_employees"] . "</td>
                        <td>" . $row["id_projects"] . "</td>
                    </tr>";
            }
        }
        ?>
    </tbody>
</table>