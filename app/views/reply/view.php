<?php $title = "View Comments"; ?>
<!-- Start of List of Comments -->
<div class="container">

<div class="span4 offset freeze" style="float:left; margin-left:0;">
    <div class="well span4" style="margin-left:0;">
        <table width="100%">
            <tr style="border-bottom: solid 1px;">
                <td align="left" valign="top"><h3><?php clean_output($topic->topic_name); ?></h3></td>
                <td align="right" valign="top" class="muted">
                    <?php clean_output($topic->username); ?><br />
                    <?php clean_output($topic->created); ?>
                </td>
            </tr>
            <tr>
                <td colspan=2>
                    <br />
                    <?php echo(readable_text($topic->question)); ?>
                </td>
            </tr>
        </table>
    </div>

    <!-- Start of Error display -->
    <?php if ($reply->hasError()): ?>
        <div class="alert alert-error span4" style="margin-left:0; padding: 19px;">
            <h4 class="alert-heading">Validation error!</h4>
            <?php if ($reply->validation_errors['body']['length']): ?>
                <div><em>Comment</em> must be between
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
        <textarea class="span4" name="body"  style="resize:none" rows="6"></textarea>
        <br />
        <input type="hidden" name="topic_id" value="<?php clean_output($topic->topic_id) ?>">
        <input type="hidden" name="page_next" value="write_end">
        <button type="submit" class="btn btn-inverse pull-right">Submit</button>
    </form>
    </div>
</div>

<?php if (!empty($replies)): ?>
    <div class="well span7" style="float:right;">
        <h3>Answers</h3>
        <?php foreach ($replies as $k=> $v): ?>
            <div class="alert alert-info">
                <font color='green'><strong><?php clean_output($v->username) ?></strong><br />
                 <?php clean_output($v->created) ?></font>
                <div class="clipped">
                    <?php echo(readable_text($v->reply)); ?>
                </div>
            </div>
        <?php endforeach ?>
        <?php echo $paged ?>
    </div>
    <?php else: ?>
        <div class="alert alert-error offset2 span7" style="padding: 19px; float:right;">
            This homework is still unanswered.
        </div>
    <?php endif ?>

<!-- End of List of Comments -->




</div>