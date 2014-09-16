<?php $title = "Signup"; ?>
<br />
<h2 class="offset3 center span5">Register a New account</h2>
<?php if (User::$is_email_exists || User::$is_username_exists): ?>
    <div class="alert alert-danger span5 offset3">
        <?php if (User::$is_email_exists && User::$is_username_exists): ?>
            <em>Email Address</em> and <em>Username</em> already exist
        <?php elseif (User::$is_email_exists): ?>
            <em>Email Address</em> already exists
        <?php elseif (User::$is_username_exists): ?>
            <em>Username</em> already exists
        <?php endif ?>
    </div>
<?php elseif ($user->hasError()): ?>
    <div class="alert alert-danger span5 offset3">
        <h4 class="alert-heading">Validation error!</h4>
        <?php if ($user->validation_errors['name']['length']): ?>
            <div>
                <em>Name</em> must be  between
                <?php clean_output($user->validation['name']['length'][1]) ?> and
                <?php clean_output($user->validation['name']['length'][2]) ?> characters in length.
            </div>
        <?php elseif ($user->validation_errors['name']['validname']): ?>
            <div>
                Please enter a valid <em>Name</em>
            </div>
        <?php endif ?>
        <?php if ($user->validation_errors['email']['length']): ?>
            <div>
                <em>Email</em> must be between
                <?php clean_output($user->validation['email']['length'][1]) ?> and
                <?php clean_output($user->validation['email']['length'][2]) ?> characters in length.
            </div>
            <?php elseif ($user->validation_errors['email']['validemail']): ?>
            <div>
                Please enter a valid <em>Email</em>
            </div>
        <?php endif ?>
        <?php if ($user->validation_errors['username']['length']): ?>
            <div>
                <em>Username</em> must be  between
                <?php clean_output($user->validation['username']['length'][1]) ?> and
                <?php clean_output($user->validation['username']['length'][2]) ?> characters in length.
            </div>
        <?php elseif ($user->validation_errors['username']['validuname']): ?>
            <div>
                Please enter a valid <em>Username</em>
            </div>
            <?php endif ?>
        <?php if ($user->validation_errors['password']['length']): ?>
            <div>
                <em>Password</em> must be  between
                <?php clean_output(($user->validation['password']['length'][1])) ?> and
                <?php clean_output(($user->validation['password']['length'][2])) ?> characters in length.
            </div>
        <?php elseif ($user->validation_errors['password']['validpassword']): ?>
            <div>
                <em>Password</em> should not contain spaces
            </div>
        <?php elseif ($user->validation_errors['combined_password']['comparison']): ?>
            <div>
                The <em>Passwords</em> do not match. 
            </div>
        <?php endif ?>
    </div>
<?php endif ?>



<div class="well span5 offset3" style="padding:25px;">
    <form method="post" action="<?php clean_output(url('')); ?>">
    <table>
        <tr>
            <td colspan=2><h4>Personal Info</h4></td>
        </tr>
        <tr>
            <td align="right">Name:</td>
            <td><input type="text" name="name" placeholder="Jet Li"/>
            <font class="text-error">*</font></td>
        </tr>
        <tr>
            <td align="right">Email address:</td>
            <td><input type="text" name="email" placeholder="karate@hollywood.com"/>
            <font class="text-error">*</font></td>
        </tr>
        <tr>
            <td align="right">Grade Level:</td>
            <td><select name="gradelevel">
                    <?php for($i = 1; $i<=6; $i++): ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php endfor ?>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan=2><h4>Login Credentials</h4></td>
        </tr>
        <tr>
            <td align="right">Username:</td>
            <td><input type="text" name="username" placeholder="jetli222"/>
            <font class="text-error">*</font></td>
        </tr>
        <tr>
            <td align="right">Password:</td>
            <td><input type="password" name="password"/>
            <font class="text-error">*</font></td>
        </tr>
        <tr>
            <td align="right">Re-Type Password:</td>
            <td><input type="password" name="password2"/>
            <font class="text-error">*</font></td>
        </tr>
        <tr>
            <td><input type="hidden" name="added" value="signupsuccess" />
            <input type="submit" class="btn btn-inverse" name="regbtn" /></td>
            <td><font class="text-error">*Required Fields</font></td>
        </tr>
    </table>       
    </form> 
</div>
<div style="float:left;">
    <br />
    <br />
    <br />
    <br />
    <br />
    <br />
    <br />
    <br />
    <br />
    <br />
    <br />
    <br />
    <br />
    <br />
    <img src="/img/bartnhomer.gif" />
</div>


