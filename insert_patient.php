<!-- Code responsbile for showing a form for user where they can create a new patient and add them to the database, Programmer: 28 -->
<?php
include('header.php');
include('db_connect.php');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ohip = $_POST['ohip'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $birthdate = $_POST['birthdate'];
    $weight = $_POST['weight'];
    $height = $_POST['height'];
    $treatsdocid = $_POST['treatsdocid'];

    // Check for duplicate OHIP
    $check_query = "SELECT * FROM patient WHERE ohip = '$ohip'";
    $check_result = $conn->query($check_query);

    if ($check_result->num_rows > 0) {
        $error_message = "A patient with this OHIP already exists.";
    } else {
        // Insert the new patient into the database
        $query = "INSERT INTO patient (ohip, firstname, lastname, birthdate, weight, height, treatsdocid) 
                  VALUES ('$ohip', '$firstname', '$lastname', '$birthdate', '$weight', '$height', '$treatsdocid')";

        if ($conn->query($query) === TRUE) {
            $success_message = "New patient inserted successfully";
        } else {
            $error_message = "Error: " . $query . "<br>" . $conn->error;
        }
    }
}

// Fetch the list of doctors for the dropdown
$doctors_query = "SELECT docid, firstname, lastname FROM doctor";
$doctors_result = $conn->query($doctors_query);
$conn->close();
?>

<main class="content-container">
    <h1 class="animate-heading"> Add a New Patient &#x1F9CD;</h1>
    <?php if (isset($error_message)): ?>
        <p style="color: red;"><?= htmlspecialchars($error_message) ?></p>
    <?php endif; ?>
    <?php if (isset($success_message)): ?>
        <p style="color: green;"><?= htmlspecialchars($success_message) ?></p>
    <?php endif; ?>
    <form method="POST" class="grid-form">
        <div>
            <label for="ohip">OHIP:</label>
            <input type="text" id="ohip" name="ohip" required>
        </div>
        <div>
            <label for="firstname">First Name:</label>
            <input type="text" id="firstname" name="firstname" required>
        </div>
        <div>
            <label for="lastname">Last Name:</label>
            <input type="text" id="lastname" name="lastname" required>
        </div>
        <div>
            <label for="birthdate">Birthdate:</label>
            <input type="date" id="birthdate" name="birthdate" required>
        </div>
        <div>
            <label for="weight">Weight (kg):</label>
            <input type="number" id="weight" name="weight" required>
        </div>
        <div>
            <label for="height">Height (m):</label>
            <input type="number" id="height" name="height" step="0.01" required>
        </div>
        <div>
            <label for="treatsdocid">Treating Doctor:</label>
            <select id="treatsdocid" name="treatsdocid" required>
                <?php while ($doctor = $doctors_result->fetch_assoc()): ?>
                    <option value="<?= htmlspecialchars($doctor['docid']) ?>">
                        <?= htmlspecialchars($doctor['firstname'] . ' ' . $doctor['lastname']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div>
            <label>&nbsp;</label>
            <button type="submit">Insert Patient</button>
        </div>
    </form>
</main>

<?php include('footer.php'); ?>