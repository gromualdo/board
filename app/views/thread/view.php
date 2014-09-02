<h2 class="offset"><?php output($thread->title) ?></h2> 
<div class=" well">  
    <?php foreach ($comments as $k=> $v): ?>
        <font color='green'><strong><?php output($v->username) ?></strong><br />
         <?php output($v->created) ?></font>
        <div>
            <?php echo readable_text($v->body) ?><hr />
        </div>
    <?php endforeach ?>
    <div class="center">
        <?php echo $paged ?>
    </div>
</div>
<div class="well">
<form  method="post" action="<?php output(url('thread/write')) ?>">
    <label>Your name</label>
    <input type="text" class="span2" name="username" value="<?php output($username); ?>" readonly />
    <label>Comment</label>
    <textarea class="span11" name="body"  style="resize:none"></textarea>
    <br />
    <input type="hidden" name="thread_id" value="<?php output($thread->id) ?>">
    <input type="hidden" name="page_next" value="write_end">
    <button type="submit" class="btn btn-inverse">Submit</button>
</form>
</div>


