<?php
// Include database connection
include 'dbcon.php';

// Handling form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Escape user inputs for security
        $name = $_POST['uname'];
        $email = $_POST['email'];
        
        // Insert user information into the user table
        $stmt_user = $pdo->prepare("INSERT INTO user (ta_user_name, ta_user_email) VALUES (:uname, :email)");
        $stmt_user->bindParam(':uname', $name);
        $stmt_user->bindParam(':email', $email);
        $stmt_user->execute();

        // Get the last inserted user ID
        $user_id = $pdo->lastInsertId();

        // Data for the post table
        $address = $_POST['uaddress'];
        $postcode = $_POST['postcode'];
        $dimensions = $_POST['dimensions'];
        $unit = $_POST['unit'];
        $garden_description = $_POST['garden-description'];
        // Handle tags
        $tagsString = $_POST['tags'];
        $tags = explode(',', $tagsString); // Split the comma-separated string into an array of tags
        // Check if the "anonymous" checkbox is checked
        $anonymous = isset($_POST['anon']) ? 1 : 0;

        // Handle file upload
        $image_path = '';
        if(isset($_FILES['image-upload'])){
            $file_name = $_FILES['image-upload']['name'];
            $file_tmp = $_FILES['image-upload']['tmp_name'];
            $image_path = "formimages/" . $file_name;
            move_uploaded_file($file_tmp, $image_path);
        }

        // Insert post information into the post table
        $stmt_post = $pdo->prepare("INSERT INTO post (ta_post_add, ta_post_postcode, ta_post_dim, ta_dim_unit, ta_post_desc, ta_post_images, ta_post_anon, FK_user_ta_user_id) VALUES (:uaddress, :postcode, :dimensions, :unit, :garden_description, :image_path, :anon, :user_id)");
        $stmt_post->bindParam(':user_id', $user_id);
        $stmt_post->bindParam(':uaddress', $address);
        $stmt_post->bindParam(':postcode', $postcode);
        $stmt_post->bindParam(':dimensions', $dimensions);
        $stmt_post->bindParam(':unit', $unit);
        $stmt_post->bindParam(':garden_description', $garden_description);
        $stmt_post->bindParam(':image_path', $image_path);
        $stmt_post->bindParam(':anon', $anonymous);
        $stmt_post->execute();

        // Get the last inserted post ID
        $post_id = $pdo->lastInsertId();

        // Redirect to success page
        header("Location: formsuccess.php");
        exit();
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
