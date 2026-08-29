<?php
include 'cek_sesi.php';

include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM report WHERE id = $id";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }
}
$status = $row['status'];


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $status = $_POST['status'];

    $q = "UPDATE report SET status = '$status' WHERE id = $id";
    if ($db->query($q) === TRUE) {
        // echo "Data berhasil diupdate";
        header('location:kelola_laporan.php');
        exit();
    } else {
        echo "Data gagal diupdate";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Status</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 50px;
        }

        .card {
            max-width: 500px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Card to contain form -->
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">Update Status</h5>
            </div>
            <div class="card-body">
                <form method="post">
                    <div class="form-group">
                        <label for="status">Select Status</label>
                        <select class="form-control" name="status" id="status" required>
                            <option value="">Select Status</option>
                            <?php
                            // Query to get the ENUM values from the `status` column
                            $result = $db->query("SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS
                                                WHERE TABLE_NAME = 'report' AND COLUMN_NAME = 'status'");

                            if ($result) {
                                $row = $result->fetch_array();
                                // Parse ENUM values from the COLUMN_TYPE
                                $enumList = explode(",", str_replace("'", "", substr($row['COLUMN_TYPE'], 5, (strlen($row['COLUMN_TYPE']) - 6))));

                                // Loop through the ENUM list and generate options
                                foreach ($enumList as $value) {
                                    echo "<option value=\"$value\">$value</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Save Changes</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>