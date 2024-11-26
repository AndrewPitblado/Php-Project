<!-- Code repsonsible for showing all of the details of a specific nurse that a user selects from the drop down menu
these details include: Total hours worked, Supervisors name, Doctors nurse has worked for, and how many hours they have worked for each doctor
Programmer: 28 -->
<?php
include('header.php');
include('db_connect.php');

// Fetch the list of nurses for the dropdown
$nurses_query = "SELECT nurseid, firstname, lastname FROM nurse ORDER BY lastname, firstname";
$stmt = $conn->prepare($nurses_query);
$stmt->execute();
$nurses_result = $stmt->get_result();

// Initialize variables
$error_message = '';
$success_message = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nurseid'])) {
    // Use a single query to get all the information we need
    $main_query = "
        WITH NurseDetails AS (
            SELECT 
                n.nurseid,
                n.firstname AS nurse_firstname,
                n.lastname AS nurse_lastname,
                sup.firstname AS supervisor_firstname,
                sup.lastname AS supervisor_lastname,
                (SELECT SUM(hours) FROM workingfor WHERE nurseid = n.nurseid) AS total_hours
            FROM nurse n
            LEFT JOIN nurse sup ON n.reporttonurseid = sup.nurseid
            WHERE n.nurseid = ?
        ),
        DoctorHours AS (
            SELECT 
                d.firstname AS doctor_firstname,
                d.lastname AS doctor_lastname,
                w.hours
            FROM workingfor w
            JOIN doctor d ON w.docid = d.docid
            WHERE w.nurseid = ?
            ORDER BY d.lastname, d.firstname
        )
        SELECT * FROM NurseDetails, DoctorHours";

    $stmt = $conn->prepare($main_query);
    $stmt->bind_param("ss", $_POST['nurseid'], $_POST['nurseid']);
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $nurse_info = null;
        $doctor_hours = array();
        
        while ($row = $result->fetch_assoc()) {
            if (!$nurse_info) {
                $nurse_info = array(
                    'nurse_firstname' => $row['nurse_firstname'],
                    'nurse_lastname' => $row['nurse_lastname'],
                    'supervisor_firstname' => $row['supervisor_firstname'],
                    'supervisor_lastname' => $row['supervisor_lastname'],
                    'total_hours' => $row['total_hours']
                );
            }
            if ($row['doctor_firstname'] && $row['doctor_lastname']) {
                $doctor_hours[] = array(
                    'doctor_firstname' => $row['doctor_firstname'],
                    'doctor_lastname' => $row['doctor_lastname'],
                    'hours' => $row['hours']
                );
            }
        }
    } else {
        $error_message = "Error fetching details: " . $conn->error;
    }
}
$conn->close();
?>

<main class="content-container">
    <h1 class="nurse-header">Nurse Details 🩺</h1>
    <div class="animate-container">
        <p>Select a nurse to find: </p>
        <section class="animation">
            <div class="first"><div>Doctors they've worked for</div></div>
            <div class="second"><div>Hours worked</div></div>
            <div class="third"><div>Supervisors</div></div>
        </section>
    </div>
    <form method="POST" class="grid-form-modify">
        
            <div>
                <label for="nurseid">Select Nurse:</label>
                <select id="nurseid" name="nurseid" required>
                    <option value="">-- Select a Nurse --</option>
                    <?php while ($nurse = $nurses_result->fetch_assoc()): ?>
                        <option value="<?= htmlspecialchars($nurse['nurseid']) ?>"
                        <?= isset($_POST['nurseid']) && $_POST['nurseid'] == $nurse['nurseid'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($nurse['firstname'] . ' ' . $nurse['lastname']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div>
                <label>&nbsp;</label>
                <button type="submit">View Details</button>
            </div>
        
    </form>

    <?php if ($error_message): ?>
        <p style="color: red;"><?= htmlspecialchars($error_message) ?></p>
    <?php endif; ?>

    <?php if (isset($nurse_info) && !$error_message): ?>
        <div class="results-container">
            <section>
                <h2>Nurse Information</h2>
                <div class="table-container">
                    <table>
                        <tr>
                            <th>Name</th>
                            <td><?php echo htmlspecialchars($nurse_info['nurse_firstname'] . ' ' . $nurse_info['nurse_lastname']); ?></td>
                        </tr>
                        <?php if ($nurse_info['supervisor_firstname']): ?>
                        <tr>
                            <th>Supervisor</th>
                            <td><?php echo htmlspecialchars($nurse_info['supervisor_firstname'] . ' ' . $nurse_info['supervisor_lastname']); ?></td>
                        </tr>
                        <?php endif; ?>
                        <tr>
                            <th>Total Hours</th>
                            <td><?php echo htmlspecialchars($nurse_info['total_hours'] ?? '0'); ?></td>
                        </tr>
                    </table>
                </div>
            </section>
        
            <?php if (!empty($doctor_hours)): ?>
                <section>
                <h2>Doctors and Hours Worked</h2>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Doctor Name</th>
                                <th>Hours Worked</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($doctor_hours as $dh): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($dh['doctor_lastname'] . ', ' . $dh['doctor_firstname']); ?></td>
                                <td><?php echo htmlspecialchars($dh['hours']); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</main>
<?php include('footer.php'); ?>