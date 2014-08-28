<div class="container">
	<div class="well">
		<h1>All threads</h1>

		<div class="btn-group btn-group-vertical" style="padding:0 10px 10px 0;">
			<?php foreach($threads as $v): ?>
			<a href="<?php eh(url('thread/view', array('thread_id' => $v->id))) ?>" class="btn btn-info btn-small">
			<?php eh($v->title) ?></a>
			
			<?php endforeach ?>
		</div>
		<br />
		<a class="btn btn-primary" href="<?php eh(url('thread/create')) ?>">Create</a>
	</div>
</div>