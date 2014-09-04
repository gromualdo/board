<?php $title = "View Comments"; ?>
<!-- Start of List of Comments -->
<h2 class="offset"><?php clean_output($thread->title) ?></h2> 
<div class=" well">  
    <?php foreach ($comments as $k=> $v): ?>
        <font color='green'><strong><?php clean_output($v->username) ?></strong><br />
         <?php clean_output($v->created) ?></font>
        <div class="clipped">
            <?php clean_output(readable_text($v->body)); ?><hr />
        </div>
    <?php endforeach ?>
    <div class="center">
        <?php echo $paged ?>
    </div>
</div>
<!-- End of List of Comments -->

<!-- Start of Error display -->
<?php if ($comment->hasError()): ?>
    <div class="alert alert-block">
        <h4 class="alert-heading">Validation error!</h4>
        <?php if (!empty($comment->validation_errors['body']['length'])): ?>
            <div><em>Comment</em> must be between
                <?php clean_output($comment->validation['body']['length'][1]) ?> and
                <?php clean_output($comment->validation['body']['length'][2]) ?> characters in length.
            </div>
        <?php endif ?>
    </div>
<?php endif ?>
<!-- End of Error display -->

<div class="well">
<form  method="post" action="<?php clean_output(url('thread/view')) ?>">
    <label>Your name</label>
    <input type="text" class="span4" name="username" value="<?php clean_output($username); ?>" readonly />
    <label>Comment</label>
    <textarea class="span11" name="body"  style="resize:none"></textarea>
    <br />
    <input type="hidden" name="thread_id" value="<?php clean_output($thread->id) ?>">
    <input type="hidden" name="page_next" value="write_end">
    <button type="submit" class="btn btn-inverse">Submit</button>
</form>
</div>


