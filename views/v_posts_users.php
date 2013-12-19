<div id='user_list'>
	<table>
		<?php foreach($users as $user): ?>
		<tr>
			<td><?=$user['first_name']?> <?=$user['last_name']?></td>
			<td>
				<?php if (isset($connections[$user['user_id']])): ?>
				<a class='uf_link' href='#' id='<?=$user['user_id']?>'>Unfollow</a>
				<?php else: ?>
				<a class='uf_link' href='#' id='<?=$user['user_id']?>'>Follow</a>
				<?php endif; ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>
</div>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
