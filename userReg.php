<?php
$successMessage = "";
if (isset($_SESSION['registered'])) {
    $successMessage = $_SESSION['registered'];
    unset($_SESSION['registered']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carpool</title>
    <link rel="stylesheet" href="style.css">
    <style>
        input[type='number'],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
            margin-bottom: 20px;
        }

        .success {
            color: green;
            text-align: center;
            font-weight: 700;
        }

        .error-message {
            color: red;
            font-size: 12px;
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <h1>Carpooling App Registration</h1>

    <?php if ($successMessage !== "") : ?>
        <p class="success"><?php echo $successMessage; ?></p>
    <?php endif; ?>

    <form action="confirmation.php" method="post" onsubmit="return validateForm()">
        <label for="user_FirstName">First Name</label><br>
        <input type="text" name="user_FirstName" oninput="capitalizeFirstLetter(this)" placeholder="Juan" required><br><br>

        <label for="user_LastName">Last Name</label><br>
        <input type="text" name="user_LastName" oninput="capitalizeFirstLetter(this)" placeholder="Dela Cruz" required><br><br>

        <label for="user_ContactNumber">Contact Number</label><br>
        <input type="number" name="user_ContactNumber" oninput="validatePhoneNumber(this, 11)" placeholder="09123456789" required>
        <p id="phoneError" class="error-message"></p><br>

        <label for="user_Email">Email</label><br>
        <input type="text" name="user_Email" oninput="validateEmail(this)" placeholder="user@example.com" required><br><br>

        <label for="user_Password">Password</label><br>
        <input type="password" name="Password" id="passwordInput" oninput="validatePassword(this)" required>
        <p id="passwordError" class="error-message"></p><br>

        <label for="user_Password">Confirm Password</label><br>
        <input type="password" name="user_Password" id="confirmPasswordInput" oninput="validateConfirmPassword()" required>
        <p id="confirmPasswordError" class="error-message"></p><br><br><br>

        <input type="submit" name="send">
        <br>
        <p id="formError" style="color: red; font-size: 15px; margin-top: 15px; font-weight: 700;"></p>
    </form>


    <script>
        function validatePhoneNumber(input, maxLength) {
            if (input.value.length > maxLength) {
                input.value = input.value.slice(0, maxLength);
            }

            var value = input.value;
            var isValid = value.length === 11 && value.startsWith('09');
            input.style.borderColor = isValid ? 'green' : 'red';

            var errorElement = document.getElementById('phoneError');

            if (!isValid) {
                if (value.length !== 11) {
                    errorElement.textContent = 'Phone number must be 11 numbers.';
                } else if (!value.startsWith('09')) {
                    errorElement.textContent = 'Phone number must start with "09".';
                }
            } else {
                errorElement.textContent = '';
            }
        }

        function capitalizeFirstLetter(input) {
            var value = input.value;
            input.value = value.replace(/(^|\s)\S/g, function(match) {
                return match.toUpperCase();
            });
            isValid = input.value.trim().length > 0;
            input.style.borderColor = isValid ? 'green' : 'red';
        }

        function validateEmail(input) {
            var value = input.value;
            var isValid = value.includes('@') && value.endsWith('.com');
            input.style.borderColor = isValid ? 'green' : 'red';
        }

        function validatePassword(input) {
            var value = input.value;
            var isValid = value.length >= 6;
            input.style.borderColor = isValid ? 'green' : 'red';

            var errorMessage = document.getElementById('passwordError');
            if (isValid) {
                errorMessage.textContent = '';
            } else {
                errorMessage.textContent = 'Input must be at least 6 characters.';
            }
        }

        function validateConfirmPassword() {
            var passwordInput = document.getElementById('passwordInput');
            var confirmPasswordInput = document.getElementById('confirmPasswordInput');
            var confirmPasswordError = document.getElementById('confirmPasswordError');
            var password = passwordInput.value;
            var confirmPassword = confirmPasswordInput.value;
            var isValid = password === confirmPassword;

            confirmPasswordInput.style.borderColor = isValid ? 'green' : 'red';

            if (!isValid) {
                confirmPasswordError.textContent = "Password and Confirm Password don't match.";
            } else {
                confirmPasswordError.textContent = '';
            }
        }

        function validateForm() {
            var isValid = true;
            var inputs = document.getElementsByTagName('input');
            var errorMessage = '';

            for (var i = 0; i < inputs.length; i++) {
                if (inputs[i].style.borderColor === 'red') {
                    isValid = false;
                    errorMessage = 'Please fill in all fields correctly.';
                    break;
                }
            }

            var errorElement = document.getElementById('formError');
            errorElement.textContent = errorMessage;

            return isValid;
        }
    </script>

</body>

</html>
