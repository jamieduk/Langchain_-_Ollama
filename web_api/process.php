<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>J~Net AI</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="../../images/favicon.ico" type="image/x-icon" class="trash">
</head>

<body>
<h2>AI Output:</h2>
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
        echo "<pre id='ai-output' style='color:green;'>$output</pre>";
        echo "<button id='copy-btn'>Copy to Clipboard</button>";
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

<script>
// JavaScript to copy the AI output to clipboard
document.getElementById('copy-btn')?.addEventListener('click', function() {
    const outputText=document.getElementById('ai-output').innerText;

    // Create a temporary textarea to hold the text
    const tempTextArea=document.createElement('textarea');
    tempTextArea.value=outputText;
    document.body.appendChild(tempTextArea);

    // Select the text and copy it to the clipboard
    tempTextArea.select();
    document.execCommand('copy');

    // Remove the temporary textarea
    document.body.removeChild(tempTextArea);

  //  alert('AI Output copied to clipboard!');
});
</script>

</center>
</body>
</html>
