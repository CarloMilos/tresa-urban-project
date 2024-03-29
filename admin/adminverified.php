<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Verified Posts</title>
  <!-- Link to Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<?php
// Include database connection
require '../config.php';

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


// Query to fetch validated posts with user information
$stmt_validated_posts = $pdo->prepare("SELECT pp.post_id, pp.post_resident_name, pp.post_resident_email, pp.post_lat, pp.post_long, pp.post_desc, pp.post_dimens, pp.post_image, pp.post_anon, GROUP_CONCAT(c.category_name SEPARATOR ', ') AS categories FROM privatespace_post pp LEFT JOIN category_has_post chp ON pp.post_id = chp.FK_post_id LEFT JOIN category c ON chp.FK_category_id = c.category_id WHERE pp.validated = 1 GROUP BY pp.post_id, pp.post_resident_name, pp.post_lat, pp.post_long, pp.post_desc, pp.post_dimens, pp.post_image, pp.post_anon;");
$stmt_validated_posts->execute();
$validated_posts = $stmt_validated_posts->fetchAll(PDO::FETCH_ASSOC);

// Display validated posts with user information
?>
<body>
<div class="container">
  <h2>Validated Posts with User Information</h2>
  <div class="row">
    <div class="col-12">
      <button onclick="location.href='admin.php'" class="btn btn-primary mb-3">Go back</button>
    </div>
  </div>
  <div class="table-responsive">
    <table class="table table-bordered">
      <thead class="thead-dark">
        <tr>
          <th>Post ID</th>
          <th>User Name</th>
          <th>User Email</th>
          <th>Description</th>
          <th>Dimensions m²</th>
          <th>Image</th>
          <th>Anonymous Post?</th>
          <th>Categories</th>
          <th>Delete</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($validated_posts as $post): ?>
          <tr>
            <td><?= $post['post_id'] ?></td>
            <td><?= $post['post_resident_name'] ?></td>
            <td><?= $post['post_resident_email'] ?></td>
            <td><?= $post['post_desc'] ?></td>
            <td><?= $post['post_dimens'] ?> m²</td>
            <td><img src="../<?= $post['post_image'] ?>" alt="Post Image" style="max-width: 100px; height: auto;"></td>
            <td><?= $post['post_anon'] == 1 ? "Yes" : "No" ?></td>
            <td><?= $post['categories'] ?></td>
            <td>
              <form method="post" onsubmit="return confirmDelete();">
                <input type="hidden" name="post_id" value="<?= $post['post_id'] ?>">
                <input type="submit" name="delete_post" value="Delete" class="btn btn-danger">
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
</body>
<script>
function confirmDelete() {
    return confirm("Are you sure you want to delete this post?\nThis will remove the marker from the map");
}
</script>
</html>
