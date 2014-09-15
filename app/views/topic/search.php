<br /><br />
<?php if(!Topic::$has_results): ?>
    <div class="alert alert-error span9 offset1 center">
        No Results Found
    </div>
    <img src="/img/maggie.gif" width="85px" height="80px" class="offset4"/>
<?php else: ?>
    <div class="alert alert-success center span9 offset1">
        <?php clean_output($total_rows); ?> Match(es) Found
    </div>
    <br /><br /><br /><br />
    <div class="span7 offset2">
        <div class="well" style="margin:-23px">
            <?php foreach($results as $v): ?>
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
                            <?php clean_output($v->subject_category); ?>
                        </span>
                    <?php elseif ($v->subject_category == "English"): ?>
                        <span class="label label-warning">
                            <?php clean_output($v->subject_category); ?>
                        </span>
                    <?php elseif ($v->subject_category == "History"): ?>
                        <span class="label label-important">
                            <?php clean_output($v->subject_category); ?>
                        </span>
                    <?php endif ?>&nbsp;
                    <font class="muted"><?php clean_output($v->created); ?><br /></font>
                    <a href="<?php clean_output(url('reply/view', array('topic_id' => base64_encode($v->topic_id)))) ?>">
                        <?php clean_output($v->topic_name) ?></a>
                </div>
            <?php endforeach ?>
                <?php echo($paged); ?>
        </div>
    </div>
<?php endif ?>