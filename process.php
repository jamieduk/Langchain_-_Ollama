<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>J~Net AI</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="../../images/favicon.ico" type="image/x-icon" class="trash">
</head>


<h2>AI Output:<h2>
<center>

<?php
$question=isset($_GET['question']) ? escapeshellarg($_GET['question']) : '';

if (!empty($question)) {
    // Path to the virtual environment's Python interpreter
    $python_interpreter='sudo /var/www/html/apps/ai/venv/bin/python';

    // Path to your Python script
    $script_path='/var/www/html/apps/ai/api.py';

    // Command to execute the Python script using the virtual environment's Python
    $command=escapeshellcmd("$python_interpreter $script_path $question");

    // Execute the command
    $output=shell_exec($command . " 2>&1");

    // Display the output or errors
    if ($output) {
        echo "<pre style='color:green;'>$output</pre>";
    } else {
        echo "<pre style='color:red;'>Error: No response from the Python script.</pre>";
    }
} else {
    echo "<pre style='color:red;'>Ask The AI A Question!</pre>";
}

?>

    <h1>Ask AI a Question</h1>
    <form method="get" action="process.php">
        <label for="question">Your Question:</label>
        <input type="text" id="question" name="question" required autofocus>
        <button type="submit">Ask</button>
    </form>
    
    
    
