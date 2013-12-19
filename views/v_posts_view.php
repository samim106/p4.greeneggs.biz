<div id='article_container'>
	<article class='article_one'>
		<p class='article_content'>
			<?=$post['content']?>
		</p>
		<p class='article_poster'>Created: 
			<time datetime="<?=Time::display($post['created'],'Y-m-d G:i')?>">
				<?=Time::display($post['created'])?>
			</time>
		</p>
	</article>
</div>