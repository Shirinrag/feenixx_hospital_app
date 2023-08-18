<!-- application/views/webcam_capture.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Webcam Capture</title>
</head>
<body>
    <h1>Webcam Capture</h1>

    <video id="webcam" autoplay></video>
    <button id="capture">Capture Image</button>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Access the webcam
        const videoElement = document.getElementById('webcam');
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(stream => videoElement.srcObject = stream)
            .catch(error => console.error('Error accessing webcam:', error));

        // Capture image
        const captureButton = document.getElementById('capture');
        captureButton.addEventListener('click', () => {
            const canvas = document.createElement('canvas');
            canvas.width = videoElement.videoWidth;
            canvas.height = videoElement.videoHeight;
            const context = canvas.getContext('2d');
            context.drawImage(videoElement, 0, 0, canvas.width, canvas.height);

            const imageDataURL = canvas.toDataURL('image/png');

            // Send the captured image to the server
            $.ajax({
                type: 'POST',
                url: '<?= site_url("welcome/save_image"); ?>',
                data: { imageData: imageDataURL },
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    alert(response.message);
                },
                error: function(error) {
                    console.error('Error sending image:', error);
                }
            });
        });
    </script>
</body>
</html>
