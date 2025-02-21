<?php
// Define the directory where the file will be uploaded
$uploadDir = 'uploads/';

// Check if the form is submitted and the file is uploaded
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $fileName = $_FILES['file']['name'];
    $fileTmp = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    
    // Get file extension
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    
    // Define allowed file types (e.g., jpg, png, txt)
    $allowedExt = ['jpg', 'jpeg', 'png', 'txt', 'pdf'];
    
    // Check if file type is allowed
    if (in_array($fileExt, $allowedExt)) {
        // Check if there is no error in uploading
        if ($fileError === 0) {
            // Check file size (limit to 5MB for this example)
            if ($fileSize <= 5000000) {
                // Generate a unique name for the file
                $newFileName = uniqid('', true) . '.' . $fileExt;
                $filePath = $uploadDir . $newFileName;

                // Move file from temporary location to the target directory
                if (move_uploaded_file($fileTmp, $filePath)) {
                    echo "File uploaded successfully!<br>";
                    echo "File Name: " . htmlspecialchars($fileName) . "<br>";
                    echo "Uploaded to: " . $filePath . "<br>";
                } else {
                    echo "There was an error uploading the file.";
                }
            } else {
                echo "File size exceeds the 5MB limit.";
            }
        } else {
            echo "Error uploading file. Please try again.";
        }
    } else {
        echo "File type not allowed. Only jpg, jpeg, png, txt, and pdf files are allowed.";
    }
} else {
    echo "No file uploaded.";
}
?>
