<div id='article_container'>
	<article class='article_one'>
		<p class='article_content'>
	<?php if ($msg==-1): ?>
		Sorry, you are not the author of this post and cannot edit this post.
	<?php else: ?>
		<form method='POST' action='/posts/p_edit_one'>
			<textarea name='content' rows='5' cols='50'><?=$post['content']?></textarea>
			<br/>
			<input type="hidden" name='post_id' value='<?=$post['post_id']?>'>
			<input type='submit' value='submit edited post'>
		</form>
	<?php endif; ?>
		</p>
		<p class='article_poster'>Created: 
			<time datetime="<?=Time::display($post['created'],'Y-m-d G:i')?>">
				<?=Time::display($post['created'])?>
			</time>
		</p>
	</article>
	<br><br>
	<div id='results'></div>
</div>