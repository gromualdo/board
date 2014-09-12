<?php $title = "Topics"; ?>
<?php if(Param::get('m')): ?>
     <div class="alert alert-error center">
            <?php clean_output(Param::get("m")); ?>
    </div>

<?php endif ?>
<h1 class="span5 offset3 center">All<img src="/img/homer.gif" />Topics</h1>
<div class="span5 offset3 center">
    <div class="well" style="margin:-23px">

            <?php foreach($topics as $v): ?>
            <table class="table table-striped table-condensed">
                    <tr>
                        <td width="100%"><a href="<?php clean_output(url('reply/view', array('topic_id' => $v->topic_id))) ?>">
                        <?php clean_output($v->topic_name) ?></a></td>
                    </tr>
                </table>
            <?php endforeach ?>
            <?php echo($paged); ?>
        <a class="btn btn-primary" href="<?php clean_output(url('topic/create')) ?>">Create</a>
    </div>
</div>

