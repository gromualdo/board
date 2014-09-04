<?php $title = "Threads"; ?>
<?php if(Param::get('m')): ?>
     <div class="alert alert-error center">
            <?php clean_output(Param::get("m")); ?>
    </div>

<?php endif ?>
<h1 class="span5 offset3 center">All<img src="/img/homer.gif" />Threads</h1>
<div class="span5 offset3 center">
    <div class="well" style="margin:-23px">
            <?php foreach($threads as $v): ?>
            <div>
                <a href="<?php clean_output(url('thread/view', array('thread_id' => $v->id))) ?>">
                <?php clean_output($v->title) ?></a>
            </div>
            <?php endforeach ?>
        <br />
        <div class="padded">
            <?php echo($paged); ?>
        </div>
        <a class="btn btn-primary" href="<?php clean_output(url('thread/create')) ?>">Create</a>
    </div>
</div>

