<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>J~Net AI</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Ask AI a Question</h1>
    <form method="get" action="process.php">
        <label for="question">Your Question:</label>
        <input type="text" id="question" name="question" required>
        <button type="submit">Ask</button>
    </form>

    <?php
    // Include the process.php script here
    // You can include or place the process.php code in this file as well
    include 'process.php';
    ?>
</body>
</html>
