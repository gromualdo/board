<?php $title = "Create topic"; ?>
<h1>Create a topic</h1>
<?php if ($topic->hasError()): ?>
    <div class="alert alert-error span9" style="padding: 19px;">
        <h4 class="alert-heading">Validation error!</h4>
        <?php if ($topic->validation_errors['topic_name']['length']): ?>
            <div><em>Title</em> must be between
                <?php clean_output($topic->validation['topic_name']['length'][1]) ?> and
                <?php clean_output($topic->validation['topic_name']['length'][2]) ?> characters in length.
            </div>
        <?php elseif($topic->validation_errors['topic_name']['valid_topic']): ?>
            <div>
                Please do not start with space for <em>Title</em>
            </div>
        <?php endif ?>
        <?php if ($topic->validation_errors['question']['length']): ?>
            <div><em>Description</em> must be between
                <?php clean_output($topic->validation['question']['length'][1]) ?> and
                <?php clean_output($topic->validation['question']['length'][2]) ?> characters in length.
            </div>
        <?php elseif($topic->validation_errors['question']['valid_question']): ?>
            <div>
                Please do not start with space for <em>Question</em>
            </div>
    <?php endif ?>
</div>
<?php endif ?>
<div class="well span9">
<form method="post" action="<?php clean_output(url('')) ?>">
    <div class="span8">
        <label>Topic Title</label>
        <input type="text" maxlength="50" class="span7" name="title" value="<?php clean_output(Param::get('title')) ?>">
    </div>
    <div class="span4">
        <label>Grade Level</label>
        <select name="grade_level">
            <?php for($i = 1; $i<=6; $i++): ?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
            <?php endfor ?>
        </select>
    </div>
    <div class="span4">
        <label>Course Subject</label>
        <select name="course_subject">
            <option value="Science">Science</option>
            <option value="English">English</option>
            <option value="History">History</option>
        </select>
    </div>
    <div class="span9">
        <input type="hidden" class="span6" name="user_id" value="<?php clean_output($user_id); ?>" readonly>
        <label>Description</label>
        <textarea name="questions" style="resize:none" class="span7" maxlength="1000"></textarea>
        <br />
        <input type="hidden" name="page_next" value="create_end">
        <button type="submit" class="btn btn-primary">Submit</button>

    </div>
</form>
</div>