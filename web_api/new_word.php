<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Word Audio Generator</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="../../images/favicon.ico" type="image/x-icon" class="trash">
</head>
<body>
<center>
    <h1>Word Audio Generator</h1>
    <label for="word">Enter a word:</label>
    <input type="text" id="word" name="word" style="max-width:500px;">
    <button id="generate-btn">Generate and Play</button>
    <audio id="audio-player" controls></audio>
    <div id="status" style="margin-top: 20px; color: #fff;"></div>

    <script>
        function generateAndPlay() {
            const word=document.getElementById('word').value.trim();
            const statusDiv=document.getElementById('status');

            if (word) {
                const audioPlayer=document.getElementById('audio-player');
                const generateAudioUrl=`generate_audio.php?word=${encodeURIComponent(word)}`;

                // Clear previous status message
                statusDiv.textContent='Generating audio...';

                // Reset previous event handlers
                audioPlayer.oncanplaythrough=null;
                audioPlayer.onerror=null;

                // Fetch the audio generation URL
                fetch(generateAudioUrl)
                    .then(response => response.json())
                    .then(data => {
                        // Wait a moment to ensure the file is fully created
                        setTimeout(() => {
                            // Set the audio source
                            audioPlayer.src=`words/${encodeURIComponent(word)}.wav`;

                            // Wait an additional second before loading and playing
                            setTimeout(() => {
                                audioPlayer.load(); // Load the new audio

                                // Play the audio once it's ready
                                audioPlayer.oncanplaythrough=() => {
                                    audioPlayer.play(); // Simulate pressing the play button
                                    // Update status div
                                    statusDiv.textContent='Audio is playing...';
                                    statusDiv.style.color='green';
                                };

                                // Update status div if there's an issue with playback
                                audioPlayer.onerror=() => {
                                    statusDiv.textContent='Failed to play audio.';
                                    statusDiv.style.color='red';
                                };
                            }, 1000); // Wait for an additional second before loading and playing
                        }, 1000); // Wait for 1 second before setting the audio source
                    })
                    .catch(error => {
                        console.error('Error:', error);

                        // Update status div
                        statusDiv.textContent='An error occurred while processing the request.';
                        statusDiv.style.color='red';
                    });
            } else {
                // Update status div
                statusDiv.textContent='Please enter a word.';
                statusDiv.style.color='red';
            }
        }

        // Add event listener to the button
        document.getElementById('generate-btn').addEventListener('click', generateAndPlay);

        // Add event listener to the input field for Enter key
        document.getElementById('word').addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault(); // Prevent form submission
                generateAndPlay();
            }
        });
    </script>
</center>
</body>
</html>
