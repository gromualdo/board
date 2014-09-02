<h2><?php output($thread->title) ?></h2>
<p class="alert alert-success">
    You successfully created.
</p>
<a href="<?php output(url('thread/threads', array('thread_id' => $thread->id))) ?>">
    &larr; Go to thread
</a>
