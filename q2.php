<!DOCTYPE html>
<html>

<head>
    <title>Caesar Cipher</title>
    <style>
        body{
            justify-content: center;
        }
        form {
            margin: 0 auto;
            width: 300px;
        }
    </style>
</head>

<body>
    <h2>Caesar Cipher Encryption</h2>
    <form method="post">
        <label for="input">Enter characters separated by *:</label><br>
        <input type="text" id="input" name="input"><br><br>
        <input type="submit" value="Encrypt">
    </form>

    <?php
    function caesarCipher($char, $shift)
    {
        if (!ctype_alpha($char)) {
            return $char;
        }

        $isUpper = ctype_upper($char);
        $char = strtolower($char);

        $ascii = ord($char) + $shift;
        if ($ascii > ord('z')) {
            $ascii -= 26;
        }
        if ($isUpper) {
            $ascii -= 32;
        }

        return chr($ascii);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $input = $_POST["input"];

        // Explode the input by *
        $characters = explode("*", $input);

        // Apply Caesar Cipher encryption and concatenate characters
        $encryptedText = "";
        foreach ($characters as $char) {
            if ($char != "") {
                $encryptedText .= caesarCipher($char, 3);
            }
        }

        // Replace * with &
        $encryptedText = str_replace("*", "&", $encryptedText);

        // Display encrypted text and its length
        echo "<h3>Encrypted Text:</h3>";
        echo "<p>$encryptedText</p>";
        echo "<p>Length: " . strlen($encryptedText) . "</p>";

        // Sort encrypted characters based on ASCII value
        $encryptedChars = str_split($encryptedText);
        sort($encryptedChars);

        // Display sorted encrypted characters
        echo "<h3>Sorted Encrypted Characters:</h3>";
        echo "<p>" . implode(" ", $encryptedChars) . "</p>";

        $charCounts = array();
        foreach ($encryptedChars as $char) {
            if (isset($charCounts[$char])) {
                $charCounts[$char]++;
            } else {
                $charCounts[$char] = 1;
            }
        }

        $repeatedChars = array();
        $uniqueChars = array();
        foreach ($encryptedChars as $char) {
            if ($charCounts[$char] == 1) {
                $uniqueChars[$char] = true;
            } else {
                $repeatedChars[$char] = true;
            }
        }

        echo "<h3>Repeated Characters:</h3>";
        echo "<p>" . implode(" ", array_keys($repeatedChars)) . "</p>";

        echo "<h3>Unique Characters:</h3>";
        echo "<p>" . implode(" ", array_keys($uniqueChars)) . "</p>";
    }
    ?>
</body>

</html>