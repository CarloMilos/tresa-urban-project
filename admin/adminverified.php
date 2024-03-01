<?php
// Include database connection
include 'dbcon.php';

// Check if the delete button is clicked
if(isset($_POST['delete_post'])) {
    // Get the post ID
    $post_id = $_POST['post_id'];
    
    // Delete corresponding rows from category_has_post table
    $stmt_delete_category = $pdo->prepare("DELETE FROM category_has_post WHERE FK_post_id = ?");
    $stmt_delete_category->execute([$post_id]);
    
    // Delete from post table
    $stmt_delete_post = $pdo->prepare("DELETE FROM post WHERE post_id = ?");
    $stmt_delete_post->execute([$post_id]);
    
    // Get the user ID associated with the post
    $stmt_get_user_id = $pdo->prepare("SELECT FK_user_id FROM post WHERE post_id = ?");
    $stmt_get_user_id->execute([$post_id]);
    $user_id = $stmt_get_user_id->fetchColumn();
    
    // Delete corresponding row from user table
    $stmt_delete_user = $pdo->prepare("DELETE FROM user WHERE user_id = ?");
    $stmt_delete_user->execute([$user_id]);
}



// Query to fetch validated posts with user information
$stmt_validated_posts = $pdo->prepare("
SELECT 
    p.post_id AS post_id, 
    p.post_desc AS description, 
    p.post_dimens AS dimensions, 
    p.post_land_type AS land_type,  
    p.post_anon AS anonymous, 
    p.post_land_type AS landtype,
    u.user_name AS user_name, 
    u.user_email AS user_email,
    u.user_id AS user_id,
    GROUP_CONCAT(c.category_name SEPARATOR ', ') AS categories
FROM post p
INNER JOIN user u ON p.FK_user_id = u.user_id
LEFT JOIN category_has_post chp ON p.post_id = chp.FK_post_id
LEFT JOIN category c ON chp.FK_category_id = c.category_id
WHERE p.validated = 1
GROUP BY p.post_id
ORDER BY p.post_id DESC;");
$stmt_validated_posts->execute();
$validated_posts = $stmt_validated_posts->fetchAll(PDO::FETCH_ASSOC);

// Display validated posts with user information
echo "<h2>Validated Posts with User Information</h2>";
echo "<table border='1'>";
echo "<tr>
    <th>Post ID</th>
    <th>User ID</th>
    <th>User Name</th>
    <th>User Email</th>
    <th>Description</th>
    <th>Dimensions</th>
    <th>Land Type</th>
    <th>Anonymous Post</th>
    <th>Categories</th>
    <th>Delete</th>
    </tr>";
foreach ($validated_posts as $post) {
    echo "<tr>";
    echo "<td>".$post['post_id']."</td>";
    echo "<td>".$post['user_id']."</td>";
    echo "<td>".$post['user_name']."</td>";
    echo "<td>".$post['user_email']."</td>";
    echo "<td>".$post['description']."</td>";
    echo "<td>".$post['dimensions']." m^2</td>";
    echo "<td>".$post['landtype']. "</td>";
    echo "<td>".($post['anonymous'] == 1 ? "Yes" : "No")."</td>";
    echo "<td>".$post['categories']."</td>";
    echo "<td>";
    echo "<form method='post' onsubmit='return confirmDelete();'>";
    echo "<input type='hidden' name='post_id' value='".$post['post_id']."'>";
    echo "<input type='submit' name='delete_post' value='Delete'>";
    echo "</form>";
    echo "</td>"; 
    echo "</tr>";
}
echo "</table>";
?>
<script>
function confirmDelete() {
    return confirm("Are you sure you want to delete this post?\nThis will remove the marker from the map");
}
</script>


