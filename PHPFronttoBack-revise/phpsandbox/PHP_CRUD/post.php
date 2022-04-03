<?php
require('config/config.php');
require('config/db.php');


//Check for submit
	if(isset($_POST['delete'])){
		// echo 'Submitted'; //test
		$delete_id = mysqli_real_escape_string($conn, $_POST['delete_id']);
		$title = mysqli_real_escape_string($conn, $_POST['title']);
		$body = mysqli_real_escape_string($conn, $_POST['body']);
		$author = mysqli_real_escape_string($conn, $_POST['author']);

		$query = "DELETE FROM posts WHERE id = {$delete_id}";
		// die($query); //for debug

		if(mysqli_query($conn, $query)){
			header('Location: '.ROOT_URL.'');
		} else {
			echo 'ERROR: '. mysqli_error($conn);
		}
	}


//Get ID
$id = mysqli_real_escape_string($conn, $_GET['id']);

$query = 'SELECT * FROM posts WHERE id = '.$id;

//Get Result
$result = mysqli_query($conn, $query);

//Fetch Data
$post = mysqli_fetch_assoc($result);
// var_dump($posts); //test

//Free result
mysqli_free_result($result);

//Close connection
mysqli_close($conn);
?>

<?php include('inc/header.php'); ?>
	<div class="container">
		<!-- <a href="index.php" class="btn btn-default">Back</a>   -->
		<!-- <a href="/" class="btn btn-default">Back</a>  back กลับไปหาหน้า default -->
		<a href="<?php echo ROOT_URL; ?>" class="btn btn-default">Back</a>  
		<h1><?php echo $post['title']; ?></h1>
		
		<small>Created on <?php echo $post['created_at']; ?> by
						<?php echo $post['author']; ?></small>
		<p><?php echo $post['body']; ?></p>		
		<hr>

		<form class="pull-right" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
			<input type="hidden" name="delete_id" value="<?php echo $post['id']; ?>">
			<input type="submit" name="delete" value="Delete" class="btn btn-danger">
		</form>

		<a href="<?php echo ROOT_URL; ?>editpost.php?id=<?php echo $post['id']; ?>" class="btn btn-default">Edit</a>		
			
	</div>
<?php include('inc/footer.php'); ?>