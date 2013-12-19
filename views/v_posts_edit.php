<div id='article_container'>
<?php if ($posts==null) {
		echo "You have not created any posts.";
	} ?>
<?php foreach($posts as $post): ?>
	<article class='article_one'>
		<p class='article_content'>
			<?=$post['content']?>
		</p>
		<p class='article_poster'>
			<time datetime="<?=Time::display($post['created'],'Y-m-d G:i')?>">
				<?=Time::display($post['created'])?>
			</time>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<a href='/posts/edit_one/<?=$post['post_id']?>'>Edit</a>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<a href='/posts/delete_one/<?=$post['post_id']?>'>Delete</a>
		</p>
	</article>
<?php endforeach; ?>
</div>