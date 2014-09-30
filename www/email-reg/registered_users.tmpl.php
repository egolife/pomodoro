<?php 
require "../inc/header.php" 
?>

<section class="container l-main">
	<!-- NEEDS TO BE LOCKED DOWN -->
	<h1>Folks on your Mailing List</h1>
	
	<?php 
		if ($registered_users){
			foreach ($registered_users as $user) {
				list($name, $email) = $user;
				echo "<li>$name: <a href='mailto:$email'>$email</a></li>";

			}
		}
		else {
			echo '<li>No registrered members.</li>';
		}
	 ?>
</section>

<?php require "../inc/footer.php" ?>