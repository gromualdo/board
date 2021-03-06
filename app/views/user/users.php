<?php $title = "Users"; ?>
<br />
<h2 class="offset3 center span5"><?php clean_output($header); ?></h2>   
<?php if (isset($_GET['m'])): ?>
    <div class="alert span11 center" style="padding:19px;">
    <?php clean_output($_GET['m']); ?>
    </div>
<?php endif ?>

<div class="span11" style="padding:0 40px;">
    <div class="pull-right">
        <a href="/user/users<?php clean_output($query_string1); ?>">
            <?php clean_output($link1); ?>
        </a>
        <font class="alike"> &#183; </font>
        <a href="/user/users<?php clean_output($query_string2); ?>">
            <?php clean_output($link2); ?>
        </a>
    </div>
</div>
<?php if($all_users): ?>
    <div class="<?php clean_output($alert); ?> span11 curved" style="padding:25px;">
        <table class="table table-hover">
            <thead>
            <tr>
                <th style="text-align: center;">User ID</th>
                <th>Username</th>
                <th>Name</th>
                <th>Email Address</th>
                <th style="text-align: center;">Grade Level</th>
                <th colspan="2" style="text-align: center;"><?php clean_output($option); ?></th>
            </tr>
            </thead>
            <?php foreach($all_users as $user): ?>
                <tbody>
                <tr>
                    <td style="text-align: center;"><?php clean_output($user->user_id) ?></td>
                    <td><?php clean_output($user->username) ?></td>
                    <td><?php clean_output($user->name) ?></td>
                    <td><?php clean_output($user->email) ?></td>
                    <td style="text-align: center;"><?php clean_output($user->grade_level)?></td>
                    <td style="text-align: center;">
                        <a href="/user/promote_to_admin?u=<?php echo base64_encode($user->user_id); ?>" 
                            class="btn btn-info btn-small"
                            style="<?php clean_output($hide_button1); ?>">
                            Promote
                        </a>
                    </td>
                    <td style="text-align: center;">
                        <a href="/user/change_block_status?u=<?php echo base64_encode($user->user_id); ?>" 
                            class="btn btn-danger btn-small"
                            style="<?php clean_output($hide_button2); ?>">
                            <?php clean_output($button2); ?>
                        </a>
                    </td>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>
        <?php echo $paged ?>
    </div>
<?php else: ?>
    <div class="alert-error span11 center" style="padding:25px;">
        <h4> <?php clean_output($display_message); ?></h4>
    </div>
    <div class="span5 pull-left">
    <a href="<?php echo $back_link; ?>" style="margin-left:20px;">
        <?php echo $back_button; ?>
    </a>
    </div>
<?php endif ?>