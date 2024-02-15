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
        $stmt_post = $pdo->prepare("INSERT INTO post (ta_post_add, ta_post_dim, ta_dim_unit, ta_post_desc, ta_post_images, ta_post_anon, FK_user_ta_user_id) VALUES (:uaddress, :dimensions, :unit, :garden_description, :image_path, :anon, :user_id)");
        $stmt_post->bindParam(':user_id', $user_id);
        $stmt_post->bindParam(':uaddress', $address);
        $stmt_post->bindParam(':dimensions', $dimensions);
        $stmt_post->bindParam(':unit', $unit);
        $stmt_post->bindParam(':garden_description', $garden_description);
        $stmt_post->bindParam(':image_path', $image_path);
        $stmt_post->bindParam(':anon', $anonymous);
        $stmt_post->execute();

        // Get the last inserted post ID
        $post_id = $pdo->lastInsertId();

        // Insert tags into the tag table and establish relationship with post in post_tag table
        foreach ($tags as $tag) {
            $tag = trim($tag); // Remove any leading/trailing whitespace
            if (!empty($tag)) {
                // Check if the tag already exists in the tag table
                $stmt_tag_check = $pdo->prepare("SELECT tag_id FROM tags WHERE tag_name = :tag");
                $stmt_tag_check->bindParam(':tag', $tag);
                $stmt_tag_check->execute();
                $row = $stmt_tag_check->fetch(PDO::FETCH_ASSOC);
                if ($row) {
                    // Tag exists, get its ID
                    $tag_id = $row['tag_id'];
                } else {
                    // Tag doesn't exist, insert it into the tag table
                    $stmt_tag_insert = $pdo->prepare("INSERT INTO tags (tag_name) VALUES (:tag)");
                    $stmt_tag_insert->bindParam(':tag', $tag);
                    $stmt_tag_insert->execute();
                    // Get the last inserted tag ID
                    $tag_id = $pdo->lastInsertId();
                }
                // Establish relationship by inserting into post_tag table
                $stmt_post_tag = $pdo->prepare("INSERT INTO tags_for_post (tags_tag_id, post_ta_post_id) VALUES (:tag_id, :post_id)");
                $stmt_post_tag->bindParam(':post_id', $post_id);
                $stmt_post_tag->bindParam(':tag_id', $tag_id);
                $stmt_post_tag->execute();
            }
        }

        // Redirect to success page
        header("Location: formsuccess.php");
        exit();
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
