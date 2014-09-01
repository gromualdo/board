<h1 class="span5 offset3 center">All<img src="/img/homer.gif" />Threads</h1>
<div class="span5 offset3 center">
    <div class="well" style="margin:-23px">
            <?php foreach($threads as $v): ?>
            <div>
                <a href="<?php eh(url('thread/view', array('thread_id' => $v->id))) ?>">
                <?php eh($v->title) ?></a>
            </div>
            <?php endforeach ?>
        <br />
        <div class="padded">
            <?php echo $paged; ?>
        </div>
        <a class="btn btn-primary" href="<?php eh(url('thread/create')) ?>">Create</a>
    </div>
</div>