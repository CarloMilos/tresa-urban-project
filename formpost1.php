<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $formData = array(
        'Name' => $_POST['uname'],
        'Email' => $_POST['email'],
        'Latitude' => $_POST['latitude'],
        'Longitude' => $_POST['longitude'],
        'Garden Description' => $_POST['garden-description'],
        'Dimensions' => $_POST['dimensions'] . ' ' . $_POST['unit'],
        'Categories' => implode(', ', $_POST['categories']),
        'Social Media Permission' => $_POST['social-media-permission'],
        'Instagram Username' => $_POST['instagram-user'],
        'Anonymous' => isset($_POST['anon']) ? 'Yes' : 'No'
    );

    // If an image is uploaded
    if ($_FILES['image-upload']['error'] == 0) {
        $uploadDir = 'formimages/';
        $uploadFile = $uploadDir . basename($_FILES['image-upload']['name']);

        // Move uploaded image to the upload directory
        if (move_uploaded_file($_FILES['image-upload']['tmp_name'], $uploadFile)) {
            $formData['Image'] = $uploadFile;
        } else {
            $formData['Image'] = 'Failed to upload image';
        }
    }

    // Print the form data array
    echo "<pre>";
    print_r($formData);
    echo "</pre>";
}
?>
