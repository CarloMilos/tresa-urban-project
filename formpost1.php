<?php
// Include database connection
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    try {
        
        // Handle file upload
        $image_path = '';
        if(isset($_FILES['image-upload'])){
            $file_name = $_FILES['image-upload']['name'];
            $file_tmp = $_FILES['image-upload']['tmp_name'];
            $image_path = "formimages/" . $file_name;
            move_uploaded_file($file_tmp, $image_path);
        }
        // Escape user inputs for security
        $name  = $_POST['uname'];
        $email = $_POST['email'];
        $latitude = $_POST['latitude'];
        $longitude = $_POST['longitude'];
        $description = $_POST['garden-description'];
        $dimensions = $_POST['dimensions'];
        $anonymous = isset($_POST['anon']) ? 1 : 0;
        $validated = 0;

        // Insert post information into the post table
        $stmt_post = $pdo->prepare("INSERT INTO privatespace_post (post_resident_name, post_resident_email, post_lat, post_long, post_desc, post_dimens, post_image, post_anon, validated) VALUES (:post_name, :post_email, :lat, :long, :descr, :dimensions, :image_path, :anon, :validated)");
        $stmt_post->bindParam(':post_name', $name);
        $stmt_post->bindParam(':post_email', $email);
        $stmt_post->bindParam(':lat', $latitude);
        $stmt_post->bindParam(':long', $longitude);
        $stmt_post->bindParam(':descr', $description);
        $stmt_post->bindParam(':dimensions', $dimensions);
        $stmt_post->bindParam(':image_path', $image_path);
        $stmt_post->bindParam(':anon', $anonymous);
        $stmt_post->bindParam(':validated', $validated);

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
        header("Location: success.php");
        exit();
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}