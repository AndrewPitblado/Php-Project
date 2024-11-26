<!-- Code responsible for allowing the user to update the weight of an existing patient, 
upon submission of the form, the database will be updated with this new value, Programmer: 28 -->
<?php
include('header.php');
include('db_connect.php');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ohip = $_POST['ohip'];
    $weight = $_POST['weight'];
    $unit = $_POST['unit'];

    // Convert weight to kg if necessary
    if ($unit == 'lbs') {
        $weight = $weight / 2.20462;
    }

    // Update the patient's weight in the database
    $update_query = "UPDATE patient SET weight = '$weight' WHERE ohip = '$ohip'";
    if ($conn->query($update_query) === TRUE) {
        $success_message = "Patient weight updated successfully.";
    } else {
        $error_message = "Error updating weight: " . $conn->error;
    }
}

// Fetch the list of patients for the dropdown
$patients_query = "SELECT ohip, firstname, lastname FROM patient";
$patients_result = $conn->query($patients_query);
$conn->close();
?>

<main class="content-container">
    <!-- <h1>Modify Patient Weight ⚖️</h1> -->
    <div class="waviy">
        <span style="--i:1">M</span>
        <span style="--i:2">o</span>
        <span style="--i:3">d</span>
        <span style="--i:4">i</span>
        <span style="--i:5">f</span>
        <span style="--i:6">y</span>
        <span style="--i:7"></span>
        <span style="--i:8">W</span>
        <span style="--i:9">e</span>
        <span style="--i:10">i</span>
        <span style="--i:11">g</span>
        <span style="--i:12">h</span>
        <span style="--i:13">t</span>
        <span style="--i:14">⚖️</span>

    </div>
    <?php if (isset($error_message)): ?>
        <p style="color: red;"><?= htmlspecialchars($error_message) ?></p>
    <?php endif; ?>
    <?php if (isset($success_message)): ?>
        <p style="color: green;"><?= htmlspecialchars($success_message) ?></p>
    <?php endif; ?>
    <form method="POST" class="grid-form-modify">
        
            <div>
                <label for="ohip">Select Patient:</label>
                <div class="custom-select" style="width:200px">
                    
                    <select id="ohip" name="ohip" required>
                        <option value="">--Select a Patient --</option>
                        <?php while ($patient = $patients_result->fetch_assoc()): ?>
                            <option value="<?= htmlspecialchars($patient['ohip']) ?>">
                                <?= htmlspecialchars($patient['firstname'] . ' ' . $patient['lastname']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>
        
            <div>
                <label for="weight">New Weight:</label>
                <input type="number" id="weight" name="weight" step="0.01" required>
            </div>
        
        
            <div>
                <label for="unit">Unit:</label>
                <div class="custom-select" style="width:200px">
                    <select id="unit" name="unit" required>
                        <option value="kg">kg</option>
                        <option value="lbs">lbs</option>
                    </select>
                </div>
            </div>
            <div>
                <label>&nbsp;</label>
                <button type="submit">Update Weight</button>
            </div>
        
    </form>
</main>

<?php include('footer.php'); ?>