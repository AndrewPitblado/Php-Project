<!-- Code responsible for the 'Delete Patient', 
GETS all current patients to populate table and then deletes patients with button press Page Programmer: 28 -->
<?php
include('header.php');
include('db_connect.php');

// Handle deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_ohip'])) {
    $ohip = $_POST['delete_ohip'];
    $delete_query = "DELETE FROM patient WHERE ohip = '$ohip'";
    if ($conn->query($delete_query) === TRUE) {
        $success_message = "Patient deleted successfully.";
    } else {
        $error_message = "Error deleting patient: " . $conn->error;
    }
}

// Fetch the list of patients
$query = "SELECT ohip, firstname, lastname FROM patient";
$result = $conn->query($query);
$conn->close();
?>

<main class="content-container">
    <h1 class="shake">Delete Patient 🙅🏼‍♂️</h1>
    <?php if (isset($error_message)): ?>
        <p style="color: red;"><?= htmlspecialchars($error_message) ?></p>
    <?php endif; ?>
    <?php if (isset($success_message)): ?>
        <p style="color: green;"><?= htmlspecialchars($success_message) ?></p>
    <?php endif; ?>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>OHIP</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['ohip']) ?></td>
                    <td><?= htmlspecialchars($row['firstname']) ?></td>
                    <td><?= htmlspecialchars($row['lastname']) ?></td>
                    <td>
                        <form class="delete-form" method="POST" onsubmit="return confirm('Are you sure you want to delete this patient?');">
                            <input type="hidden" name="delete_ohip" value="<?= htmlspecialchars($row['ohip']) ?>">
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</main>

<?php include('footer.php'); ?>