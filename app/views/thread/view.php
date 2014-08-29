<h1><?php eh($thread->title) ?></h1> 
<div id="accordion" class="span5 offset3">
<?php foreach ($comments as $k=> $v): ?>

        <h3><?php eh($v->username) ?> <?php eh($v->created) ?></h3>
        <div>
            <?php echo readable_text($v->body) ?>
        </div>
<?php endforeach ?>
</div>
<div class="well offset5">
<form  method="post" action="<?php eh(url('thread/write')) ?>">
    <label>Your name</label>
    <input type="text" class="span2" name="username" value="<?php eh($username); ?>" readonly />
    <label>Comment</label>
    <textarea class="span6" name="body"  style="resize:none"><?php eh(Param::get('body')) ?></textarea>
    <br />
    <input type="hidden" name="thread_id" value="<?php eh($thread->id) ?>">
    <input type="hidden" name="page_next" value="write_end">
    <button type="submit" class="btn btn-inverse">Submit</button>
</form>
</div>

