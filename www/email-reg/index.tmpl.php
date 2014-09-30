<?php 
require "../inc/header.php" 
?>

<section class="container l-main">
	<h1>Email registration creation</h1>
	
	<form action="" method="post">
		<?php if ($status) echo '<p class="notice">'.$status.'</p>'; ?>
		<ul>
			<li><label for="name">Your Name:</label>
				<input type="text" name="name" id="name" value="<?php echo old() ?>">
			</li>

			<li><label for="email">Your Email:</label>
				<input type="email" name="email" id="email">
			</li>

			<li><input type="submit" value="Sign Up!"></li>
		</ul>
	</form>
</section>

<?php require "../inc/footer.php" ?>