<?php
// Include database connection
include 'dbcon.php';

// Query to fetch most recent posts with user information
$stmt_recent_posts = $pdo->prepare("
    SELECT 
        p.post_id AS post_id, 
        p.post_desc AS description, 
        p.post_dimens AS dimensions, 
        p.post_land_type AS land_type, 
        p.post_image AS images, 
        p.post_insta AS instagram, 
        p.post_permissions AS permissions, 
        p.post_anon AS anonymous, 
        u.user_name AS user_name, 
        u.user_email AS user_email,
        u.user_id AS user_id,
        p.validated AS validated

    FROM post p
    INNER JOIN user u ON p.FK_user_id = u.user_id
    ORDER BY p.post_id DESC
    LIMIT 10"); // Assuming you want to display the 10 most recent posts
$stmt_recent_posts->execute();
$recent_posts = $stmt_recent_posts->fetchAll(PDO::FETCH_ASSOC);

// Display recent posts with user information
echo "<h2>Recent Posts with User Information</h2>";
echo "<table border='1'>";
echo "<tr>
    <th>Post ID</th>
    <th>User ID</th>
    <th>User Name</th>
    <th>User Email</th>
    <th>Description</th>
    <th>Dimensions</th>
    <th>Instagram</th>
    <th>Social Permissions</th>
    <th>Image</th>
    <th>Anonymous Post</th>
    <th>If Button Shows, Post needs Verifcation</th>
    </tr>";
    foreach ($recent_posts as $post) {
        echo "<tr>";
        echo "<td>".$post['post_id']."</td>";
        echo "<td>".$post['user_id']."</td>";
        echo "<td>".$post['user_name']."</td>";
        echo "<td>".$post['user_email']."</td>";
        echo "<td>".$post['description']."</td>";
        echo "<td>".$post['dimensions']." m^2</td>";
        echo "<td>".$post['instagram']."</td>";
        echo "<td>".$post['permissions']."</td>";
        echo "<td><img src='".$post['images']."' height='100'></td>";
        echo "<td>".($post['anonymous'] == 1 ? "Yes" : "No")."</td>";
    
        // Check if 'validated' column is NULL
        if ($post['validated'] === NULL) {
            $showButton = true;
        }
    // Add button if any row has 'validated' column as NULL
    if ($showButton) {
        echo "<td colspan='10'><button onclick='verifyAndValidate()'>VERIFY AND VALIDATE</button></td>";
    }
    echo "</tr>";
}
echo "</table>";

// JavaScript function to handle button click
echo "<script>
function verifyAndValidate() {
    if (confirm('Are you sure you want to verify and validate, The marker will be uploaded to the Map?')) {
        // Send AJAX request
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'verify.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Refresh page after successful update
                location.reload();
            }
        };
        xhr.send();
    }
}
</script>";
?>
