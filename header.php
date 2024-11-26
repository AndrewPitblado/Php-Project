<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient List</title>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js" defer></script>
</head>
<body>

<header>
    <!-- <h1>Welcome to Andrew's Hosp! 🏥</h1>
    <h2>Explore our Database below ⤵️</h2> -->
    <section>
        <div class="content">
            <h2>Andrew's Hospital</h2>
            <h2>Andrew's Hospital</h2>
            
        </div>
    </section>

    <nav>
        <ul>
            <li><a href="list_patients.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'list_patients.php' ? 'active' : ''; ?>">List of Patients &#x1F637;</a></li>
            <li><a href="insert_patient.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'insert_patient.php' ? 'active' : ''; ?>">Add a new Patient &#x1F64B;</a></li>
            <li><a href="delete_patient.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'delete_patient.php' ? 'active' : ''; ?>">Remove a Patient &#x1F628;</a></li>
            <li><a href="modify_patient.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'modify_patient.php' ? 'active' : ''; ?>">Modify an Existing Patient 🤧</a></li>
            <li><a href="doctors_and_patients.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'doctors_and_patients.php' ? 'active' : ''; ?>">Show all Patients and Doctors 🤒👨🏻‍⚕️</a></li>
            <li><a href="doctors_without_patients.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'doctors_without_patients.php' ? 'active' : ''; ?>">Show Doctors Without a Patient &#x1F625;</a></li>
            <li><a href="nurse_details.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'nurse_details.php' ? 'active' : ''; ?>">Show Nurse Details 👩🏼‍⚕️</a></li>
        </ul>
    </nav>
</header>




