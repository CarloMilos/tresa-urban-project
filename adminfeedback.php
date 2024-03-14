<?php
// Include database connection
require 'config.php';

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
    
    $stmt_delete_post = $pdo->prepare("DELETE FROM feedback WHERE post_id = ?");
    $stmt_delete_post->execute([$post_id]);
    
}

// Check if the delete button is clicked for feedback
if(isset($_POST['delete_feedback'])) {
    // Get the feedback ID
    $feedback_id = $_POST['id'];
    
    // Delete feedback from the feedback table
    $stmt_delete_feedback = $pdo->prepare("DELETE FROM feedback WHERE id = ?");
    $stmt_delete_feedback->execute([$feedback_id]);
}

// Query to fetch feedback data
$stmt_feedback = $pdo->prepare("SELECT * FROM feedback");
$stmt_feedback->execute();
$feedback_data = $stmt_feedback->fetchAll(PDO::FETCH_ASSOC);

// Display feedback table
echo "<h2>Feedback Data</h2>";
echo "<table border='1'>";
echo "<tr>
    <th>Feedback ID</th>
    <th>User Name</th>
    <th>User Email</th>
    <th>Category</th>
    <th>Rating</th>
    <th>Message</th>
    <th>Created At</th>
    <th>Delete</th>
    </tr>";
foreach ($feedback_data as $feedback) {
    echo "<tr>";
    echo "<td>".$feedback['id']."</td>";
    echo "<td>".$feedback['name']."</td>";
    echo "<td>".$feedback['email']."</td>";
    echo "<td>".$feedback['category']."</td>";
    echo "<td>".$feedback['rating']."</td>";
    echo "<td>".$feedback['message']."</td>";
    echo "<td>".$feedback['created_at']."</td>";
    echo "<td>";
    echo "<form method='post' onsubmit='return confirmDelete(\"feedback\");'>";
    echo "<input type='hidden' name='id' value='".$feedback['id']."'>";
    echo "<input type='submit' name='delete_feedback' value='Delete' class='delete-button'>";
    echo "</form>";
    echo "</td>"; 
    echo "</tr>";
}
echo "</table>";


// Query to fetch validated posts with user information
$stmt_validated_posts = $pdo->prepare("SELECT pp.post_id, pp.post_resident_name, pp.post_resident_email, pp.post_lat, pp.post_long, pp.post_desc, pp.post_dimens, pp.post_image, pp.post_anon, GROUP_CONCAT(c.category_name SEPARATOR ', ') AS categories FROM privatespace_post pp LEFT JOIN category_has_post chp ON pp.post_id = chp.FK_post_id LEFT JOIN category c ON chp.FK_category_id = c.category_id WHERE pp.validated = 1 GROUP BY pp.post_id, pp.post_resident_name, pp.post_lat, pp.post_long, pp.post_desc, pp.post_dimens, pp.post_image, pp.post_anon;");
$stmt_validated_posts->execute();
$validated_posts = $stmt_validated_posts->fetchAll(PDO::FETCH_ASSOC);

// Display validated posts with user information
echo "<h2>Validated Posts with User Information</h2>";
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
    <th>Delete</th>
    </tr>";
foreach ($validated_posts as $post) {
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
    echo "<form method='post' onsubmit='return confirmDelete(\"post\");'>";
    echo "<input type='hidden' name='post_id' value='".$post['post_id']."'>";
    echo "<input type='submit' name='delete_post' value='Delete' class='delete-button'>";
    echo "</form>";
    echo "</td>"; 
    echo "</tr>";
}
echo "</table>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        .delete-button {
            background-color: #ff5757;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-size: 14px;
            font-weight: bold;
            outline: none;
        }

        .delete-button:hover {
            background-color: #e64141;
        }


        body {
            font-family: Arial, sans-serif;
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
            color: #333;
        }

        tr:hover {
            background-color: #f9f9f9;
        }





        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }

            h1 {
                font-size: 20px;
            }

            th, td {
                padding: 10px;
            }
        }
    </style>
</head>
<body>

<script>
function confirmDelete(type) {
    var message = type === 'feedback' ? "Are you sure you want to delete this feedback?" : "Are you sure you want to delete this post?\nThis will remove the marker from the map";
    return confirm(message);
}
</script>

</body>
</html>



<script>
function confirmDelete() {
    return confirm("Are you sure you want to delete this post?\nThis will remove the marker from the map");
}
</script>

<script>
function confirmDelete() {
    return confirm("Are you sure you want to delete this feedback?");
}
</script>



