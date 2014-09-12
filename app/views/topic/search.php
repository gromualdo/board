<br /><br />
<?php if(!Topic::$has_results): ?>
    <div class="alert alert-error span5 offset3 center">
        No Results Found
    </div>
<?php else: ?>
    <div class="alert alert-success center span9 offset1">
        <?php clean_output($total_rows); ?> Match(es) Found
    </div>
    <br /><br /><br /><br />
    <div class="span5 offset3 center">
        <div class="well" style="margin:-23px">
            <?php foreach($results as $v): ?>
                <table class="table table-striped table-condensed">
                    <tr>
                        <td width="100%"><a href="<?php clean_output(url('reply/view', array('topic_id' => $v->topic_id))) ?>">
                            <?php clean_output($v->topic_name) ?></a></td>
                        <td align="right"><span class="badge" title="# comments">#</span></td>
                    </tr>
                </table>
            <?php endforeach ?>
                <?php echo($paged); ?>
        </div>
    </div>
<?php endif ?>