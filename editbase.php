<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
require_once 'dbConfig.php';

// Start session
if (!session_id()) {
    session_start();
}

// Add process
if (isset($_POST['add'])) {
    $selectedTable = $_POST['selected_table'];
    $newData = $_POST['new_data'];

    $columns = implode(', ', array_keys($newData));
    $values = implode(', ', array_fill(0, count($newData), '?'));
    $sqlAdd = "INSERT INTO $selectedTable ($columns) VALUES ($values)";

    $queryAdd = $conn->prepare($sqlAdd);
    $add = $queryAdd->execute(array_values($newData));

    $sessData = [];
    if ($add) {
        $sessData['status']['type'] = 'success';
        $sessData['status']['msg'] = 'New ' . $selectedTable . ' data has been added successfully.';
    } else {
        $sessData['status']['type'] = 'error';
        $sessData['status']['msg'] = 'Error adding new ' . $selectedTable . ' data.';
    }

    $_SESSION['sessData'] = $sessData;
}

// Update process
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $selectedTable = $_POST['selected_table'];
    $updateID = $_POST['update_id'];
    $updatedData = $_POST['updated_data'];

    $setClause = implode(' = ?, ', array_keys($updatedData)) . ' = ?';
    $sqlUpdate = "UPDATE $selectedTable SET $setClause WHERE {$selectedTable}_ID = ?";

    $queryUpdate = $conn->prepare($sqlUpdate);
    $updatedDataValues = array_values($updatedData);
    $updatedDataValues[] = $updateID;
    $update = $queryUpdate->execute($updatedDataValues);

    $sessData = [];
    if ($update) {
        $sessData['status']['type'] = 'success';
        $sessData['status']['msg'] = $selectedTable . ' data has been updated successfully.';
    } else {
        $sessData['status']['type'] = 'error';
        $sessData['status']['msg'] = 'Error updating ' . $selectedTable . ' data.';
    }

    $_SESSION['sessData'] = $sessData;
}

// Delete process
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $selectedTable = $_POST['selected_table'];
    $deleteID = $_POST['delete_id'];

    $sql = "DELETE FROM $selectedTable WHERE {$selectedTable}_ID = ?";
    $query = $conn->prepare($sql);
    $delete = $query->execute(array($deleteID));

    $sessData = [];
    if ($delete) {
        $sessData['status']['type'] = 'success';
        $sessData['status']['msg'] = $selectedTable . ' data has been deleted successfully.';
    } else {
        $sessData['status']['type'] = 'error';
        $sessData['status']['msg'] = 'This record cannot be deleted because it is referenced in other tables.';
        
    }

    $_SESSION['sessData'] = $sessData;
}


$categories = [
    'AUTHOR' => ['AUTHOR_ID', 'AUTHOR_NAME', 'AUTHOR_LASTNAME', 'AUTHOR_EMAIL'],
    'SUPERVISOR' => ['SUPERVISOR_ID', 'SUPERVISOR_NAME', 'SUPERVISOR_LASTNAME', 'SUPERVISOR_EMAIL'],
    'COSUPERVISOR' => ['COSUPERVISOR_ID', 'COSUPERVISOR_NAME', 'COSUPERVISOR_LASTNAME', 'COSUPERVISOR_EMAIL'],
    'UNIVERSITY' => ['UNIVERSITY_ID', 'UNIVERSITY_NAME', 'UNIVERSITY_CITY', 'UNIVERSITY_STATE'],
    'INSTITUTE' => ['INSTITUTE_ID', 'INSTITUTE_NAME', 'UNIVERSITY_ID'],
    'LANGUAGE' => ['LANGUAGE_ID', 'LANGUAGE_NAME'],
    'TOPICS' => ['TOPICS_ID', 'TOPICS_NAME'],
    'KEYWORDS' => ['KEYWORDS_ID', 'KEYWORD'],
];

$tables = array_keys($categories);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Database</title>
    <style>
        body {
            line-height: 1;
            font-size: 16px;
            color: #333;
            word-wrap: break-word !important;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('yeniscreen.png') center center fixed;
            background-size: cover;
        }

        form {
            background-color: #fff;
            padding: 10px;
            border-radius: 5px;
            display: inline-block;
            margin: 10px 0;
        }

        select {
            padding: 8px;
            font-size: 16px;
            border: 1px solid #337ab7;
            border-radius: 3px;
            background-color: #fff;
            color: #333;
            margin-right: 10px;
        }

        input[type="submit"] {
            padding: 6px 10px;
            font-size: 16px;
            border: none;
            border-radius: 3px;
            color: #fff;
            background-color: #337ab7;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #286090;
        }

        input[type="text"] {
            padding: 5px;
            margin: 5px 0;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 3px;
        }

        button {
            padding: 5px 10px;
            margin: 5px 0;
            font-size: 14px;
            border: none;
            border-radius: 3px;
            color: #fff;
            background-color: #337ab7;
            cursor: pointer;
        }

        button:hover {
            background-color: #286090;
        }

        .actions {
            display: flex;
            align-items: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            background-color: #fff;
        }

        tr:hover {
            background-color: #4481eb;
            color: #4481eb;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        .status {
            padding: 10px;
            margin: 10px 0;
        }

        .error {
            background-color: #ff6666;
            color: white;
        }

        .success {
            background-color: #66cc66;
            color: white;
        }

        .btn {
            background-color: #2980b9;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            transition-duration: 0.4s;
        }

        .add-new-form {
            background-color: #fff;
            padding: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>

    <form method="post" action="">
        <label for="tables" style="font-size: 20px;">Select Table:</label>
        <select name="selected_table" id="tables" style="font-size: 18px;">
            <?php foreach ($tables as $table) : ?>
                <option value="<?= $table ?>" style="font-size: 14px;"><?= $table ?></option>
            <?php endforeach; ?>
        </select>
        <input type="submit" value="Show">
        <a href="submit.html" class="btn solid" style="width: 125px; height: 15px; margin-left: 60px;">Submit Thesis</a>
        <a href="search.html" class="btn solid" style="width: 125px; height: 15px;">Search Thesis</a>
    </form>

    <?php if ($_SERVER['REQUEST_METHOD'] == 'POST') : ?>
        <?php
        $selectedTable = $_POST['selected_table'];
        $sql = "SELECT * FROM $selectedTable";
        $query = $conn->query($sql);
        ?>

        <?php if ($query) : ?>
            <table>
                <tr>
                    <?php foreach ($categories[$selectedTable] as $column) : ?>
                        <th><?= $column ?></th>
                    <?php endforeach; ?>
                    <th>Actions</th>
                </tr>

                <?php while ($row = $query->fetch(PDO::FETCH_ASSOC)) : ?>
                    <tr>
                        <?php foreach ($categories[$selectedTable] as $column) : ?>
                            <td><?= $row[$column] ?></td>
                        <?php endforeach; ?>
                        <td class="actions">
                            <form method="post" action="">
                                <input type="hidden" name="selected_table" value="<?= $selectedTable ?>">
                                <input type="hidden" name="update_id" value="<?= $row[$selectedTable . '_ID'] ?>">
                                <?php foreach (array_slice($categories[$selectedTable], 1) as $column) : ?>
                                    <label for="<?= $column ?>"><?= $column ?>:</label>
                                    <input type="text" name="updated_data[<?= $column ?>]" value="<?= $row[$column] ?>">
                                <?php endforeach; ?>
                                <button type="submit" name="update">Update</button>
                            </form>

                            <form method="post" action="" id="deleteForm">
                                <input type="hidden" name="selected_table" value="<?= $selectedTable ?>">
                                <input type="hidden" name="delete_id" value="<?= $row[$selectedTable . '_ID'] ?>">
                                <button type="submit" name="delete" id="deleteButton">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>

            <div class="add-new-form">
                <h2>Add New <?= $selectedTable ?></h2>
                <form method="post" action="">
                    <input type="hidden" name="selected_table" value="<?= $selectedTable ?>">
                    <?php foreach (array_slice($categories[$selectedTable], 1) as $column) : ?>
                        <label for="<?= $column ?>"><?= $column ?>:</label>
                        <input type="text" name="new_data[<?= $column ?>]" required>
                    <?php endforeach; ?>
                    <button type="submit" name="add">Add</button>
                </form>
            </div>

        <?php else : ?>
            <div class="status error"><?= 'Query error: ' . $conn->errorInfo()[2] ?></div>
        <?php endif; ?>
    <?php endif; ?>

    <?php if (isset($sessData['status'])) : ?>
        <div class="status <?= $sessData['status']['type'] ?>">
            <?= $sessData['status']['msg'] ?>
        </div>
        <?php unset($sessData['status']); ?>
        <?php $_SESSION['sessData'] = $sessData; ?>
    <?php endif; ?>

    <!-- JavaScript kodunu ekleyelim -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var statusElement = document.querySelector('.status');

            if (statusElement) {
                var statusType = statusElement.classList.contains('success') ? 'success' : 'error';
                var statusMessage = statusElement.innerText.trim();

                alert(statusMessage);

                if (statusType === 'success') {
                    // Baþarý durumu
                } else if (statusType === 'error') {
                    // Hata durumu
                }
            }
        });
    </script>

</body>
</html>
