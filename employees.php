<?php
$sql = "SELECT * FROM employees";
$result = mysqli_query($conn, $sql);
?>
<h2>Darbuotojai</h2>
<table>
    <thead>
        <th>Id</th>
        <th>Name</th>
        <th>Projektai</th>
    </thead>
    <tbody>
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>" . $row["id_employees"] . "</td>
                        <td>" . $row["firstname"] . "</td>
                        <td>" . $row["lastname"] . "</td>
                    </tr>";
            }
        }
        ?>
    </tbody>
</table>