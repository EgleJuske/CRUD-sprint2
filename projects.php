<?php
$sql = "SELECT * FROM projects";
$result = mysqli_query($conn, $sql);
?>
<h2>Projektai</h2>
<table>
    <thead>
        <th>Id</th>
        <th>Projektas</th>
    </thead>
    <tbody>
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>" . $row["id_projects"] . "</td>
                        <td>" . $row["project_name"] . "</td>
                    </tr>";
            }
        }
        ?>
    </tbody>
</table>