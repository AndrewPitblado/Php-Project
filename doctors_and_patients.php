<!-- Code resonsible for listing all of the Doctors and their respective patients Programmer: 28 -->
<?php
include('header.php');
include('db_connect.php');

// Fetch the list of doctors and their patients
$query = "SELECT doctor.docid, doctor.firstname AS doctor_firstname, doctor.lastname AS doctor_lastname, 
                 patient.firstname AS patient_firstname, patient.lastname AS patient_lastname
          FROM doctor 
          LEFT JOIN patient ON doctor.docid = patient.treatsdocid
          ORDER BY doctor.lastname, doctor.firstname";
$result = $conn->query($query);

// Organize the data into an associative array
$doctors = [];
while ($row = $result->fetch_assoc()) {
    $docid = $row['docid'];
    if (!isset($doctors[$docid])) {
        $doctors[$docid] = [
            'firstname' => $row['doctor_firstname'],
            'lastname' => $row['doctor_lastname'],
            'patients' => []
        ];
    }
    if ($row['patient_firstname'] && $row['patient_lastname']) {
        $doctors[$docid]['patients'][] = [
            'firstname' => $row['patient_firstname'],
            'lastname' => $row['patient_lastname']
        ];
    }
}
$conn->close();
?>

<main class="content-container">
    
    <div class="keyboard">
        <span class="key">D</span>
        <span class="key">O</span>
        <span class="key">C</span>
        <span class="key">T</span>
        <span class="key">O</span>
        <span class="key">R</span>
        <span class="key">S</span>
        <span>&nbsp;</span>
        <span class ="key2">and</span>
        <span class="key2"> Their</span>
        <span>&nbsp;</span>
        <span class="key">P</span>
        <span class="key">A</span>
        <span class="key">T</span>
        <span class="key">I</span>
        <span class="key">E</span>
        <span class="key">N</span>
        <span class="key">T</span>
        <span class="key">S</span>
        <span>🩺</span>

    </div>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Doctor First Name</th>
                    <th>Doctor Last Name</th>
                    <th>Patients' Names</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($doctors as $doctor): ?>
                <tr>
                    <td><?= htmlspecialchars($doctor['firstname']) ?></td>
                    <td><?= htmlspecialchars($doctor['lastname']) ?></td>
                    <td>
                        <?php if (empty($doctor['patients'])): ?>
                            <span>😢</span>
                        <?php else: ?>
                            <ul>
                                <?php foreach ($doctor['patients'] as $patient): ?>
                                <li><?= htmlspecialchars($patient['firstname'] . ' ' . $patient['lastname']) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

<?php include('footer.php'); ?>