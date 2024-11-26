<!-- Code resonsible for listing all of the Doctors that currently do not have any patients yet assigned to them Programmer: 28 -->
<?php
include('header.php');
include('db_connect.php');

// Fetch the list of doctors without patients
$query = "SELECT doctor.docid, doctor.firstname, doctor.lastname 
          FROM doctor 
          LEFT JOIN patient ON doctor.docid = patient.treatsdocid 
          WHERE patient.treatsdocid IS NULL";
$result = $conn->query($query);
$conn->close();
?>

<main class="content-container">
    <h1>
        <span class="word">Doctors Without Patients &#x1F62D;</span>
        
    </h1>
    <h3>
        <span class="word">These Doctors are lonely, help them out by assigning them some patients 🫵🏼</span>
    </h3>
    <table>
        <thead>
            <tr>
                <th>Doctor ID</th>
                <th>First Name</th>
                <th>Last Name</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['docid']) ?></td>
                <td><?= htmlspecialchars($row['firstname']) ?></td>
                <td><?= htmlspecialchars($row['lastname']) ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</main>

<?php include('footer.php'); ?>