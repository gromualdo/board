<?php $title = "Topics"; ?>
<?php if(Param::get('m')): ?>
     <div class="alert alert-success center">
            <?php clean_output(Param::get("m")); ?>
    </div>
<?php endif ?>

<h1 class="span7 offset2 center">All<img src="/img/homer.gif" />Topics</h1>
<div class="span7 offset2">
    <div class="well" style="margin:-23px">
            <?php foreach($topics as $v): ?>
                <div class="alert alert-info">
                    <?php if($session['role'] == 1 || $v->user_id == $session['user_id']): ?>
                        <a href="<?php clean_output(url('topic/delete', array('topic_id' => base64_encode($v->topic_id)))) ?>"
                            onclick="return confirm('Are you sure you want to delete this topic?')"
                            title="Delete this Topic"
                            class="close" data-dismiss="alert">&times;
                        </a>
                    <?php endif ?>
                    <?php if ($v->subject_category == "Science"): ?>
                        <span class="label label-info">
                            Grade <?php clean_output($v->grade_level); ?>:                            
                            <?php clean_output($v->subject_category); 
                            ?>
                        </span>
                    <?php elseif ($v->subject_category == "English"): ?>
                        <span class="label label-warning">
                            Grade <?php clean_output($v->grade_level); ?>:
                            <?php clean_output($v->subject_category); ?>
                        </span>
                    <?php elseif ($v->subject_category == "History"): ?>
                        <span class="label label-important">
                            Grade <?php clean_output($v->grade_level); ?>:
                            <?php clean_output($v->subject_category); ?>
                        </span>
                    <?php endif ?>&nbsp;
                    <font class="muted"><?php clean_output($v->created); ?><br /></font>
                    <a href="<?php clean_output(url('reply/view', array('topic_id' => base64_encode($v->topic_id)))) ?>"
                        class="linkclipped">
                        <?php clean_output($v->topic_name) ?></a>
                </div>
            <?php endforeach ?>
            <?php echo($paged); ?>
        <a class="btn btn-primary span4 offset1" href="<?php clean_output(url('topic/create')) ?>"
        >Create</a>
        <br />
    </div>
</div>