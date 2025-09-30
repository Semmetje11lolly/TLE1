<?php
function uploadImage()
{
    $uploadDir = "../user_content/img/";
    $file = $_FILES['image'];

    // Validate the image file
    $allowed = ['image/jpeg', 'image/png', 'image/gif'];
    $fileType = $file['type'];
    $fileTmpName = $file['tmp_name'];
    $fileName = basename($file['name']);
    $fileSize = $file['size'];

    if (in_array($fileType, $allowed)) {
        if ($file['error'] === 0) {
            if ($fileSize <= 10 * 1024 * 1024) { // 10MB max
                // Create a unique name for the file
                $newFileName = uniqid('diary_', true) . '.' . pathinfo($fileName, PATHINFO_EXTENSION);
                $fileDestination = $uploadDir . $newFileName;

                // Move the file to the upload directory
                if (move_uploaded_file($fileTmpName, $fileDestination)) {
                    return $fileDestination;
                };
            } else {
                echo "Error: File size exceeds 10MB.";
            }
        } else {
            echo "Error: File upload error code " . $file['error'];
        }
    } else {
        echo "Error: Invalid file type. Only JPG, PNG, and GIF are allowed.";
    }
}