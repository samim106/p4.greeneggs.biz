<div id='article_container'>
<?php if ($posts==null) {
		echo "There are no posts to display.";
	} ?>
<?php foreach($posts as $post): ?>
	<article class='article_one'>
		<p class='article_content'>
			<?=$post['content']?>
		</p>
		<p class='article_poster'>
			<?=substr($post['first_name'],0,1)?> <?=$post['last_name']?> - 
			<time datetime="<?=Time::display($post['created'],'Y-m-d').'T'.Time::display($post['created'],'H:i:s')?>">
				<?=Time::display($post['created'])?>
			</time>
		</p>
	</article>
<?php endforeach; ?>
</div>