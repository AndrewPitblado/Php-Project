<?php
include('db_connect.php');

$sort_by = $_POST['sort_by'] ?? 'patient.lastname';
$order = $_POST['order'] ?? 'ASC';

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

while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>" . htmlspecialchars($row['ohip']) . "</td>
            <td>" . htmlspecialchars($row['patient_firstname'] . ' ' . $row['patient_lastname']) . "</td>
            <td>" . htmlspecialchars($row['doctor_firstname'] . ' ' . $row['doctor_lastname']) . "</td>
            <td>" . htmlspecialchars($row['birthday']) . "</td>
            <td>" . htmlspecialchars($row['pat_weight']) . " kg / " . htmlspecialchars(number_format($row['pat_weight'] * 2.20462, 2)) . " lbs</td>
            <td>" . htmlspecialchars($row['pat_height']) . " m / " . htmlspecialchars(convertToFeetAndInches($row['pat_height'])) . "</td>
          </tr>";
}

function convertToFeetAndInches($cm){
    $inches = ($cm * 100) / 2.54;
    $feet = floor($inches / 12);
    $remaining_inches = $inches % 12;
    return $feet . ' ft ' . round($remaining_inches) . ' in';
}
?>