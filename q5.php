<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-News Paper Registration</title>
    <style>
        label {
            display: block;
            margin-bottom: 5px;
        }

        input,
        select {
            width: 50%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .error {
            color: red;
            font-size: 0.9em;
        }
    </style>
</head>

<body>

    <h2>E-News Paper Registration</h2>
    <form id="registrationForm" onsubmit="return validateForm()">
        <label for="fullName">Full Name:</label>
        <input type="text" id="fullName" name="fullName" required>
        <label for="age">Age:</label>
        <input type="number" id="age" name="age" required>
        <label for="gender">Gender:</label>
        <select id="gender" name="gender" required>
            <option value="">Select</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
        </select>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <label for="countryCode">Country Code (3 uppercase alphabets):</label>
        <input type="text" id="countryCode" name="countryCode" required>
        <br>
        <button type="submit">Register</button>
    </form>

    <script>
        function validateForm() {

            var fullName = document.getElementById("fullName").value;
            var age = document.getElementById("age").value;
            var gender = document.getElementById("gender").value;
            var email = document.getElementById("email").value;
            var countryCode = document.getElementById("countryCode").value;

            var countryCodePattern = /^[A-Z]{3}$/;
            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            // Check if all fields are filled
            if (fullName === '' || email === '' || countryCode === '' || age === '' || gender === '') {
                alert("All fields are mandatory");
                return false;
            }

            // Check if the email matches the pattern
            if (!emailPattern.test(email)) {
                alert("Invalid email format");
                return false;
            }

            // Check if age is a number and greater than 0
            if (isNaN(age) || age <= 0) {
                alert("Age must be a positive number");
                return false;
            }

            // Check if gender is selected
            if (gender === '') {
                alert("Please select a gender");
                return false;
            }

            // Check if the country code matches the pattern
            if (!countryCodePattern.test(countryCode)) {
                alert("Country code should be 3 uppercase alphabets");
                return false;
            }

            // Display success message
            alert("Success");
            return true;
        }
    </script>

</body>

</html>