<?php $title = "Create Success"; ?>
<h2><?php clean_output($topic->topic_name) ?></h2>
<p class="alert alert-success">
    You successfully created.
</p>
<a href="<?php clean_output(url('reply/view', 
    array('topic_id' => base64_encode($topic->topic_id)))) ?>">
    &larr; Go to topic
</a>
