<?php
// Include database connection
include 'dbcon.php';

// Query to fetch most recent posts with user information
$stmt_recent_posts = $pdo->prepare("
    SELECT 
        p.ta_post_id AS post_id, 
        p.ta_post_add AS address, 
        p.ta_post_postcode AS postcode, 
        p.ta_post_dim AS dimensions, 
        p.ta_dim_unit AS unit, 
        p.ta_post_desc AS description, 
        p.ta_post_images AS images, 
        p.ta_post_anon AS anonymous, 
        u.ta_user_name AS user_name, 
        u.ta_user_email AS user_email
    FROM post p
    INNER JOIN user u ON p.FK_user_ta_user_id = u.ta_user_id
    ORDER BY p.ta_post_id DESC
    LIMIT 10"); // Assuming you want to display the 10 most recent posts
$stmt_recent_posts->execute();
$recent_posts = $stmt_recent_posts->fetchAll(PDO::FETCH_ASSOC);

// Display recent posts with user information
echo "<h2>Recent Posts with User Information</h2>";
echo "<table border='1'>";
echo "<tr><th>Post ID</th><th>Address</th><th>Postcode</th><th>Dimensions</th><th>Description</th><th>Images</th><th>User Name</th><th>User Email</th></tr>";
foreach ($recent_posts as $post) {
    echo "<tr>";
    echo "<td>".$post['post_id']."</td>";
    echo "<td>".$post['address']."</td>";
    echo "<td>".$post['postcode']."</td>";
    echo "<td>".$post['dimensions']. $post['unit']."</td>";
    echo "<td>".$post['description']."</td>";
    echo "<td><img src='".$post['images']."' height='100'></td>";
    echo "<td>".$post['user_name']."</td>";
    echo "<td>".$post['user_email']."</td>";
    echo "</tr>";
}
echo "</table>";
?>
