<?php $title = "Users"; ?>
<br />
<?php if(!isset($_GET['c'])): ?>
    <?php if($all_users): ?>
        <h2 class="offset3 center span5">Cleared Users</h2>

        <?php if (isset($_GET['m'])): ?>
            <div class="alert alert-info span11 center" style="padding:19px;">
            <?php clean_output($_GET['m']); ?>
            </div>
        <?php endif ?>

        <div class="span11" style="padding:0 40px;">
            <a href="/user/users?c=blocked" class="pull-right">Show all Blocked Users</a>
        </div>
        <div class="alert-success span11" style="padding:25px;">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Username</th>
                    <th>Name</th>
                    <th>Email Address</th>
                    <th style="text-align: center;">Grade Level</th>
                    <th colspan="2" style="text-align: center;">Options</th>
                </tr>
                </thead>
                <?php foreach($all_users as $user): ?>
                    <tbody>
                    <tr>
                        <td><?php clean_output($user->username) ?></td>
                        <td><?php clean_output($user->name) ?></td>
                        <td><?php clean_output($user->email) ?></td>
                        <td style="text-align: center;"><?php clean_output($user->grade_level)?></td>
                        <td style="text-align: center;">
                            <a href="/user/promotetoadmin?u=<?php echo base64_encode($user->user_id); ?>" class="btn btn-info btn-small">Promote</a>
                        </td>
                        <td style="text-align: center;">
                            <a href="/user/changeblockstatus?u=<?php echo base64_encode($user->user_id); ?>" class="btn btn-danger btn-small">Block</a>
                        </td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
            <?php echo $paged ?>
        </div>
    <?php else: ?>
        <div class="alert-error span11 center" style="padding:25px;">
            <h4>We Have No Users Yet</h4>
        </div>
        <a href="https://kcw.kddi.ne.jp/#!rid20868499" target="blank" style="margin-left:20px;">
            Invite your friends now
        </a>
    <?php endif ?>  

<?php else: ?>
    <?php if($all_users): ?>
        <h2 class="offset3 center span5">Blocked Users</h2>
        
        <?php if (isset($_GET['m'])): ?>
            <div class="alert alert-success span11 center" style="padding:19px;">
            <?php clean_output($_GET['m']); ?>
            </div>
        <?php endif ?>

        <div class="span11" style="padding:0 40px;">
            <a href="/user/users" class="pull-right">Display All</a>
        </div>
        <div class="alert-error span11" style="padding:25px;">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Username</th>
                    <th>Name</th>
                    <th>Email Address</th>
                    <th style="text-align: center;">Grade Level</th>
                    <th style="text-align: center;">Option</th>
                </tr>
                </thead>
                <?php foreach($all_users as $user): ?>
                    <tbody>
                    <tr>
                        <td><?php clean_output($user->username) ?></td>
                        <td><?php clean_output($user->name) ?></td>
                        <td><?php clean_output($user->email) ?></td>
                        <td style="text-align: center;"><?php clean_output($user->grade_level)?></td>
                        <td style="text-align: center;">
                            <a href="/user/changeblockstatus?c=blocked&u=<?php echo base64_encode($user->user_id); ?>" class="btn btn-small">Unblock</a>
                        </td>
                    </tr>
                    </tbody>
                <?php endforeach ?>
            </table>
            <?php echo $paged ?>
        </div>
    <?php else: ?>
        <div class="alert-error span11 center" style="padding:25px;">
            <h4>There are no blocked users</h4>
        </div>
        <a href="/user/users" style="margin-left:20px;">&larr;Go back to Users Page</a>
    <?php endif ?>
<?php endif ?>
