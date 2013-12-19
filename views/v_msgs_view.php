<div id='container'>
	<div id='msg_prev_container'>
<?php 
	$msgs = array_reverse( $msgs );
	foreach($msgs as $msg): 
?>
		<article class='msg_one'>
			<div class='article_content'>
				<?=$msg['content']?>
			</div>
			<div class='article_poster'>
				<?=$msg['first_name']?> - 
				<time datetime="<?=Time::display($msg['created'],'Y-m-d').'T'.Time::display($msg['created'],'H:i:s')?>">
					<?=Time::display($msg['created'])?>
				</time>
			</div>
		</article>
<?php endforeach; ?>
	</div>

	<ul id='msg_user_list'>
	<?php foreach ($users as $user): ?>
		<li><a href="/msgs/view/$user['user_id']"><?=$user['first_name'] $user[last_name]?></a></li>
	<?php endforeach; ?>
	</ul>
</div>
