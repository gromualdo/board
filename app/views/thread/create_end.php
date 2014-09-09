<?php $title = "Create Success"; ?>
<h2><?php clean_output($thread->title) ?></h2>
<p class="alert alert-success">
    You successfully created.
</p>
<a href="<?php clean_output(url('thread/view', array('thread_id' => $thread->id))) ?>">
    &larr; Go to thread
</a>
