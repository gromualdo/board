<h1><?php eh($thread->title) ?></h1> 
<div class=" well span4 offset">  
<?php foreach ($comments as $k=> $v): ?>
    <font color='green'><?php eh($v->username) ?> <?php eh($v->created) ?></font>
    <div>
        <?php echo readable_text($v->body) ?><hr />
    </div>
<?php endforeach ?>
<div class="center">
    <?php echo $paged ?>
</div>
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

