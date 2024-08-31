<?php
// Get the word from the query string
$word=isset($_GET['word']) ? escapeshellarg($_GET['word']) : '';

// Define the path to the words folder
$wordsDir='words/';
$audioFile=$wordsDir . $word . '.wav';

// Check if the word is provided
if (!empty($word)) {
    // Check if the file already exists
    if (!file_exists($audioFile)) {
        // Generate the audio file using eSpeak
        $command="sudo espeak -w $audioFile $word";
        shell_exec($command);

        // Check if the file was successfully created
        if (file_exists($audioFile)) {
            echo json_encode(['status' => 'generated', 'path' => $audioFile]);
        } else {
            header('HTTP/1.0 500 Internal Server Error');
            echo json_encode(['status' => 'error', 'message' => 'Failed to generate audio file.']);
        }
    } else {
        // File already exists
        echo json_encode(['status' => 'exists', 'path' => $audioFile]);
    }
} else {
    header('HTTP/1.0 400 Bad Request');
    echo json_encode(['status' => 'error', 'message' => 'No word specified.']);
}
?>

