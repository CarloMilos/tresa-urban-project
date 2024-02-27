<?php
// Include database connection
include 'dbcon.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    try {
        // Escape user inputs for security
        $name = $_POST['uname'];
        $email = $_POST['email'];
        
        // Insert user information into the user table
        $stmt_user = $pdo->prepare("INSERT INTO user (user_name, user_email) VALUES (:uname, :email)");
        $stmt_user->bindParam(':uname', $name);
        $stmt_user->bindParam(':email', $email);
        $stmt_user->execute();

        // Get the last inserted user ID
        $user_id = $pdo->lastInsertId();

        $latitude = $_POST['latitude'];
        $longitude = $_POST['longitude'];
        $description = $_POST['garden-description'];
        $dimensions = $_POST['dimensions'];
        $land_type = $_POST['land-type'];
        $social_permissions = $_POST['social-media-permission'];
        $instagram = $_POST['instagram-user'];
        $anonymous = isset($_POST['anon']) ? 1 : 0;

        $image_path = '';
        if(isset($_FILES['image-upload'])){
            $file_name = $_FILES['image-upload']['name'];
            $file_tmp = $_FILES['image-upload']['tmp_name'];
            $image_path = "formimages/" . $file_name;
            move_uploaded_file($file_tmp, $image_path);
        }

        // Insert post information into the post table
        $stmt_post = $pdo->prepare("INSERT INTO post (post_lat, post_long, post_desc, post_dimens, post_land_type, post_image, post_insta, post_permissions, post_anon, FK_user_id) VALUES (:lat, :long, :descr, :dimensions, :landtype, :image_path, :instagram, :permissions, :anon, :user_id)");
        $stmt_post->bindParam(':user_id', $user_id);
        $stmt_post->bindParam(':lat', $latitude);
        $stmt_post->bindParam(':long', $longitude);
        $stmt_post->bindParam(':dimensions', $dimensions);
        $stmt_post->bindParam(':descr', $description);
        $stmt_post->bindParam(':landtype', $land_type);
        $stmt_post->bindParam(':image_path', $image_path);
        $stmt_post->bindParam(':instagram', $instagram);
        $stmt_post->bindParam(':permissions', $social_permissions);
        $stmt_post->bindParam(':anon', $anonymous);
        $stmt_post->execute();

        $post_id = $pdo->lastInsertId();

        $categories = isset($_POST['categories']) ? $_POST['categories'] : [];

        foreach ($categories as $category) {
            // Fetch category ID from categories table based on category name
            $stmt_category_id = $pdo->prepare("SELECT category_id FROM category WHERE category_name = :category");
            $stmt_category_id->bindParam(':category', $category);
            $stmt_category_id->execute();
            $category_row = $stmt_category_id->fetch(PDO::FETCH_ASSOC);
    
            // Insert into post_has_category join table
            $category_id = $category_row['category_id'];
            $stmt_post_category = $pdo->prepare("INSERT INTO category_has_post (FK_post_id, FK_category_id) VALUES (:post_id, :category_id)");
            $stmt_post_category->bindParam(':post_id', $post_id);
            $stmt_post_category->bindParam(':category_id', $category_id);
            $stmt_post_category->execute();
        }
    
        // Redirect to success page
        header("Location: map.php");
        exit();
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}