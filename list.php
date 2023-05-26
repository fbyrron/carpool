<?php include 'database.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <title>List</title>
</head>

<body class="flex flex-col items-center justify-center tracking-wide">
    <div class="m-6">
        <h1 class="text-2xl font-bold">List of Registered Carpool App Users</h1>
    </div>

    <div class="mb-6">
        <table class="border-separate border">
            <tr>
                <th class="border px-4 bg-blue-200">User Type</th>
                <th class="border px-4 bg-blue-200">Email</th>
                <th class="border px-4 bg-blue-200">First Name</th>
                <th class="border px-4 bg-blue-200">Last Name</th>
                <th class="border px-4 bg-blue-200">Contact Number</th>
            </tr>

            <?php

            $conn = new mysqli($servername, $username, $password, $dbname);
            $sql = "SELECT user_Type, user_Email, user_FirstName, user_LastName, user_ContactNumber FROM user;";
            $result = $conn->query($sql);



            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo
                    "<tr>
                        <td class='border px-4' >" . $row["user_Type"] . "</td>
                        <td class='border px-4' >" . $row["user_Email"] . "</td>
                        <td class='border px-4' >" . $row["user_FirstName"] . "</td>
                        <td class='border px-4' >" . $row["user_LastName"] . "</td>
                        <td class='border px-4' >" . $row["user_ContactNumber"] . "</td>
                        </tr>";
                }
            } else {
                echo "No results";
            }
            $conn->close();
            ?>
        </table>
    </div><br><br>


    <div>
        <button class="py-2 px-3 mb-20 bg-blue-500 text-white rounded-xl"><a href="index.html">Register a User</a></button>
    </div>
</body>

</html>