<?php require '../inc/header.php'; ?>


<section class="container l-main">
	<h1>php-mysql practice</h1>

	<?php foreach($posts as $post) : ?>
		<article>
			<h2>
				<a href="single.php?id=<?php echo $post['id']; ?>">
					<?php echo $post['title']; ?>
				</a>
			</h2>
			<div class="body"><?php echo $post['body'] ?></div>
		</article>
	<?php endforeach; ?>

</section>



<?php require '../inc/footer.php'; ?>