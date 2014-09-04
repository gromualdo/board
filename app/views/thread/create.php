<?php $title = "Create Thread"; ?>
<h1>Create a thread</h1>
<?php if ($thread->hasError() || $comment->hasError()): ?>
    <div class="alert alert-block">
        <h4 class="alert-heading">Validation error!</h4>
        <?php if (!empty($thread->validation_errors['title']['length'])): ?>
            <div><em>Title</em> must be between
                <?php clean_output($thread->validation['title']['length'][1]) ?> and
                <?php clean_output($thread->validation['title']['length'][2]) ?> characters in length.
            </div>
        <?php endif ?>
        <?php if (!empty($comment->validation_errors['body']['length'])): ?>
            <div><em>Comment</em> must be between
                <?php clean_output($comment->validation['body']['length'][1]) ?> and
                <?php clean_output($comment->validation['body']['length'][2]) ?> characters in length.
            </div>
    <?php endif ?>
</div>
<?php endif ?>

<form class="well" method="post" action="<?php clean_output(url('')) ?>">
    <label>Title</label>
    <input type="text" class="span6" name="title" value="<?php clean_output(Param::get('title')) ?>">
    <label>Your name</label>
    <input type="text" class="span6" name="username" value="<?php clean_output($username); ?>" readonly>
    <label>Comment</label>
    <textarea name="body" style="resize:none" class="span11"></textarea>
    <br />
    <input type="hidden" name="page_next" value="create_end">
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
