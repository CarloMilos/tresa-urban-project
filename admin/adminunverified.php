<?php
// Include database connection
include 'dbcon.php';

// Check if the validate button is clicked
if(isset($_POST['validate_post'])) {
    // Validate the post
    $stmt_validate_post = $pdo->prepare("UPDATE privatespace_post SET validated = 1 WHERE post_id = ?");
    $stmt_validate_post->execute([$_POST['post_id']]);
}
// Check if the delete button is clicked
if(isset($_POST['delete_post'])) {
    // Get the post ID
    $post_id = $_POST['post_id'];
    
    // Delete corresponding rows from category_has_post table
    $stmt_delete_category = $pdo->prepare("DELETE FROM category_has_post WHERE FK_post_id = ?");
    $stmt_delete_category->execute([$post_id]);
    
    // Delete from post table
    $stmt_delete_post = $pdo->prepare("DELETE FROM privatespace_post WHERE post_id = ?");
    $stmt_delete_post->execute([$post_id]);
    
}

// Query to fetch most recent posts with user information
$stmt_recent_posts = $pdo->prepare("SELECT 
                                        pp.post_id,
                                        pp.post_resident_name,
                                        pp.post_resident_email,
                                        pp.post_lat,
                                        pp.post_long,
                                        pp.post_desc,
                                        pp.post_dimens,
                                        pp.post_image,
                                        pp.post_anon,
                                        GROUP_CONCAT(c.category_name SEPARATOR ', ') AS categories
                                        FROM 
                                        privatespace_post pp
                                        LEFT JOIN 
                                        category_has_post chp ON pp.post_id = chp.FK_post_id
                                        LEFT JOIN 
                                        category c ON chp.FK_category_id = c.category_id
                                        WHERE
                                        pp.validated = 0
                                        GROUP BY 
                                        pp.post_id,
                                        pp.post_resident_name,
                                        pp.post_lat,
                                        pp.post_long,
                                        pp.post_desc,
                                        pp.post_dimens,
                                        pp.post_image,
                                        pp.post_anon;
                                        ");
$stmt_recent_posts->execute();
$recent_posts = $stmt_recent_posts->fetchAll(PDO::FETCH_ASSOC);

if (!empty($recent_posts)) {
    echo "<h2>Recent Posts with User Information</h2>";
    echo "<table border='1'>";
    echo "<tr>
        <th>Post ID</th>
        <th>User Name</th>
        <th>User Email</th>
        <th>Description</th>
        <th>Dimensions m²</th>
        <th> Image </th>
        <th>Anonymous Post?</th>
        <th>Categories</th>
        <th>Validate Post</th> <!-- New column for Validate Post button -->
        <th>Delete</th>
        </tr>";
    foreach ($recent_posts as $post) {
        echo "<tr>";
        echo "<td>".$post['post_id']."</td>";
        echo "<td>".$post['post_resident_name']."</td>";
        echo "<td>".$post['post_resident_email']."</td>";
        echo "<td>".$post['post_desc']."</td>";
        echo "<td>".$post['post_dimens']." m² </td>";
        echo "<td><img src='../".$post['post_image']."' alt='Post Image' style='width: 100px; height: auto;'></td>";
        echo "<td>".($post['post_anon'] == 1 ? "Yes" : "No")."</td>";
        echo "<td>".$post['categories']."</td>";
        echo "<td>";
        echo "<form method='post'onsubmit='return confirmPost();'>";
        echo "<input type='hidden' name='post_id' value='".$post['post_id']."'>";
        echo "<input type='submit' name='validate_post' value='Validate'>";
        echo "</form>";
        echo "</td>";
        echo "<td>";
        echo "<form method='post' onsubmit='return confirmDelete();'>";
        echo "<input type='hidden' name='post_id' value='".$post['post_id']."'>";
        echo "<input type='submit' name='delete_post' value='Delete'>";
        echo "</form>";
        echo "</td>"; 
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>Hey, looks like you don't have any rows to validate!</p>";
    echo '<button onclick="location.href=\'admin.php\'">Go back</button>';
}
