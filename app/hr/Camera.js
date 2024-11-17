document.addEventListener("DOMContentLoaded", async function () {
  const video = document.getElementById("camera");
  let savedDescriptor;

  // Check if the browser supports getUserMedia
  if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
    try {
      const stream = await navigator.mediaDevices.getUserMedia({ video: true });
      video.srcObject = stream;

      // Load face-api.js models
      await faceapi.nets.tinyFaceDetector.loadFromUri("/models");
      await faceapi.nets.faceRecognitionNet.loadFromUri("/models");
      await faceapi.nets.faceLandmark68Net.loadFromUri("/models");

      video.addEventListener("play", () => {
        setInterval(async () => {
          const detections = await faceapi
            .detectAllFaces(video, new faceapi.TinyFaceDetectorOptions())
            .withFaceLandmarks()
            .withFaceDescriptors();

          if (detections.length > 0) {
            if (!savedDescriptor) {
              // Save the descriptor of the first detected face
              savedDescriptor = detections[0].descriptor;
            } else {
              // Compare with the saved descriptor
              const match = faceapi.matchDimensions(
                detections[0].descriptor,
                savedDescriptor
              );

              if (match) {
                // Match found, do something
                console.log("Match found!");
              } else {
                // No match, do something else
                console.log("No match found!");
              }
            }
          }

          faceapi.draw.drawDetections(
            video,
            faceapi.resizeResults(detections, {
              width: video.width,
              height: video.height,
            })
          );
        }, 1000); // Run every second
      });
    } catch (error) {
      console.error("Error accessing camera:", error);
    }
  } else {
    console.error("getUserMedia is not supported in this browser");
  }

  window.captureAndSave = async function () {
    const canvas = document.createElement("canvas");
    const context = canvas.getContext("2d");
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    context.drawImage(video, 0, 0, canvas.width, canvas.height);

    // Capture the current image descriptor
    const descriptor = await faceapi
      .detectSingleFace(canvas)
      .withFaceLandmarks()
      .withFaceDescriptor();

    if (descriptor) {
      // Send the captured image descriptor to the server
      sendToServer(descriptor.descriptor);
      console.log("Image captured and sent to the server.");
    } else {
      console.error("Error capturing image.");
    }
  };

  function sendToServer(descriptor) {
    // Use AJAX to send the descriptor to the server (PHP)
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "SaveImage.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");

    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        // Server response
        console.log(xhr.responseText);
      }
    };

    // Convert descriptor to JSON and send
    xhr.send(JSON.stringify({ descriptor: descriptor }));
  }
});
