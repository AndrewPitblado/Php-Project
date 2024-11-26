<!-- Retrieve all of the current patients from the database and list them in the following table, Programmer: 28 -->
<?php
include('header.php');
include('db_connect.php');


// Default sorting
$sort_by = 'patient.lastname';
$order = 'ASC';

// Handle form submission for sorting
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sort_by = $_POST['sort_by'] ?? 'patient.lastname';
    $order = $_POST['order'] ?? 'ASC';
}

// Build the query
$query = "SELECT patient.ohip AS ohip, patient.firstname AS patient_firstname, patient.lastname AS patient_lastname, 
doctor.firstname AS doctor_firstname, doctor.lastname AS doctor_lastname, patient.birthdate AS birthday,
patient.weight AS pat_weight, patient.height AS pat_height
FROM patient 
LEFT JOIN doctor ON patient.treatsdocid = doctor.docid 
ORDER BY $sort_by $order";

$result = $conn->query($query);
if (!$result) {
    die("Query failed: " . $conn->error);
}
$conn->close();
?>

<main class="list_patients">
    <h1>Patient List 📋</h1>
    <!-- Sorting Form -->
    <form id="sorting-form" class="sorting-form" method="POST">
        
            <button type="button" name="sort_by" value="patient.lastname" data-group="sort_by">Sort by Last Name ↕️</button>
            <button type="button" name="sort_by" value="patient.firstname" data-group="sort_by">Sort by First Name ↕️</button>
        
       
            <button type="button" name="order" value="ASC" data-group="order">Ascending ⬆️</button>
            <button type="button" name="order" value="DESC" data-group="order">Descending ⬇️</button>
        
    </form>

    <!-- Display Patient Data -->
    <div class="table-container">
        <table id="patient-table">
            <thead>
                <tr>
                    <th>Patient OHIP</th>
                    <th>Patient Name</th>
                    <th>Doctor Name</th>
                    <th>Patient Birthday</th>
                    <th>Weight (kg/lbs)</th>
                    <th>Height (m/ ft-in)</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?=htmlspecialchars($row['ohip']) ?></td>
                    <td><?=htmlspecialchars($row['patient_firstname'] . ' ' . $row['patient_lastname']) ?></td>
                    <td><?=htmlspecialchars($row['doctor_firstname'] . ' ' . $row['doctor_lastname']) ?></td>
                    <td><?=htmlspecialchars($row['birthday'])?></td>
                    <td>
                        <?=htmlspecialchars($row['pat_weight']) ?> kg /
                        <?=htmlspecialchars($row['pat_weight']* 2.20462, 2) ?> lbs
                    </td>
                    <td>
                        <?=htmlspecialchars($row['pat_height']) ?> m / 
                        <?=htmlspecialchars(convertToFeetAndInches($row['pat_height'])) ?> 
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</main>

<?php include('footer.php'); ?>
<?php
// Function to convert cm to ft and in
function convertToFeetAndInches($cm){
    $inches = ($cm * 100) / 2.54;
    $feet = floor($inches / 12);
    $remaining_inches = $inches % 12;
    return $feet . ' ft ' . round($remaining_inches) . ' in';
}
?>