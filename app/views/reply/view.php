<?php $title = "View Comments"; ?>
<!-- Start of List of Comments -->
<div class="container">

<div class="span5 offset freeze" style="float:left; margin-left:0;">
    <div class="well span5" style="margin-left:0;">
        <table width="100%">
            <tr style="border-bottom: solid 1px;">
                <td align="left" valign="top" width="230px;" style="word-wrap:break-word"><p style="max-width:230px;"><strong><?php clean_output($topic->topic_name); ?></strong></p></td>
                <td align="right" valign="top" class="muted">
                    <?php clean_output($topic->username); ?><br />
                    <?php clean_output($topic->created); ?>
                </td>
            </tr>
            <tr>
                <td colspan=2 >
                    <br />
                    <div style="word-wrap:break-word;"><p style="max-width:380px;"><?php echo(readable_text($topic->question)); ?></p></div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Start of Error display -->
    <?php if ($reply->hasError()): ?>
        <div class="alert alert-error span5" style="margin-left:0; padding: 19px;">
            <h4 class="alert-heading">Validation error!</h4>
            <?php if ($reply->validation_errors['body']['length']): ?>
                <div><em>Reply</em> must be between
                    <?php clean_output($reply->validation['body']['length'][1]) ?> and
                    <?php clean_output($reply->validation['body']['length'][2]) ?> characters in length.
                </div>
            <?php endif ?>
        </div>
    <?php endif ?>
    <!-- End of Error display -->

    <div class="well" style="float:left; margin-left:0;">
    <form  method="post" action="<?php clean_output(url('reply/view')) ?>">
        <label>Your Answer</label>
        <textarea class="span5" name="body"  style="resize:none" rows="6" 
        placeholder="<?php clean_output(ReplyController::$placeholder); ?>"
        <?php clean_output(ReplyController::$disabled); ?>></textarea>
        <br />
        <input type="hidden" name="topic_id" value="<?php echo base64_encode($topic->topic_id) ?>">
        <input type="hidden" name="page_next" value="write_end">
        <button type="submit" class="btn btn-inverse pull-right" 
        <?php clean_output(ReplyController::$disabled); ?>>
        Submit</button>
    </form>
    </div>
</div>

<!-- Start of List of Comments -->
<?php if(Param::get('m')): ?>
    <div class="alert alert-success offset6 span6" style="padding: 19px; float:right;">
            <?php clean_output(Param::get("m")); ?>
    </div>
<?php endif ?>
<?php if (!empty($replies)): ?>
    <div class="well span6" style="float:right;">
        <h3>Answers</h3>
        <?php foreach ($replies as $k=> $v): ?>
            <div class="alert alert-info">
                <?php if($session['role'] == 1 || $v->user_id == $session['user_id']): ?>
                    <a href="<?php clean_output(url('reply/delete', array('topic_id' =>base64_encode($topic_id), 'reply_id' => base64_encode($v->reply_id)))) ?>"
                        onclick="return confirm('Are you sure you want to delete this reply?')"
                        title="Delete this Reply"
                        class="close" data-dismiss="alert">&times;
                    </a>
                <?php endif ?>
                <font color='green'><strong><?php clean_output($v->username) ?></strong><br />
                 <?php clean_output($v->created) ?></font>
                <div style="word-wrap:break-word;">
                    <p><?php echo(readable_text($v->reply)); ?></p>
                </div>
            </div>
        <?php endforeach ?>
        <?php echo $paged ?>
    </div>
    <?php else: ?>
        <div class="alert alert-error offset6 span6" style="padding: 19px; float:right;">
            This homework is still unanswered.
        </div>
    <?php endif ?>

<!-- End of List of Comments -->




</div>