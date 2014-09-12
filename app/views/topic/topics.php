<?php $title = "Topics"; ?>
<?php if(Param::get('m')): ?>
     <div class="alert alert-error center">
            <?php clean_output(Param::get("m")); ?>
    </div>

<?php endif ?>
<h1 class="span5 offset3 center">All<img src="/img/homer.gif" />Topics</h1>
<div class="span5 offset3">
    <div class="well" style="margin:-23px">

            <?php foreach($topics as $v): ?>
                <div class="alert alert-info">
                <a href="<?php clean_output(url('reply/view', array('topic_id' => $v->topic_id))) ?>">
                    <?php clean_output($v->topic_name) ?></a>
                    <a href="/topic/delete" class="close" data-dismiss="alert">&times;</a>
                </div>
            <?php endforeach ?>
            <?php echo($paged); ?>
        <a class="btn btn-primary span4" href="<?php clean_output(url('topic/create')) ?>" align="center">Create</a>
        <br />
    </div>
</div>

