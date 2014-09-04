<?php $title = "Signup"; ?>
<br />
<h2 class="offset3 center span5">Register a New account</h2>
<?php if ($user->hasError() || !$user->same_password): ?>
    <div class="alert alert-danger span5 offset3">
        <h4 class="alert-heading">Validation error!</h4>
        <?php if (!empty($user->validation_errors['name']['length'])): ?>
            <div><em>Name</em> must be  between
            <?php clean_output($user->validation['name']['length'][1]) ?> and
            <?php clean_output($user->validation['name']['length'][2]) ?> characters in length.
            </div>
        <?php// endif ?>
        <?php elseif (!empty($user->validation_errors['name']['validname'])): ?>
            <div>Please enter a valid <em>Name</em>
            </div>
        <?php endif ?>
        <?php if (!empty($user->validation_errors['email']['length'])): ?>
            <div><em>Email</em> must be between
            <?php clean_output($user->validation['email']['length'][1]) ?> and
            <?php clean_output($user->validation['email']['length'][2]) ?> characters in length.
            </div>
        <?php //endif ?>
            <?php elseif (!empty($user->validation_errors['email']['validemail'])): ?>
            <div>Please enter a valid <em>Email</em>
            </div>
        <?php endif ?>
        <?php if (!empty($user->validation_errors['username']['length'])): ?>
            <div><em>Username</em> must be  between
            <?php clean_output($user->validation['username']['length'][1]) ?> and
            <?php clean_output($user->validation['username']['length'][2]) ?> characters in length.
            </div>
        <?php //endif ?>
        <?php elseif (!empty($user->validation_errors['username']['validuname'])): ?>
            <div>Please enter a valid <em>Username</em>
            </div>
            <?php endif ?>
        <?php if (!empty($user->validation_errors['password']['length'])): ?>
            <div><em>Password</em> must be  between
            <?php clean_output(($user->validation['password']['length'][1])) ?> and
            <?php clean_output(($user->validation['password']['length'][2])) ?> characters in length.
            </div>
        <?php // endif ?>
        <?php elseif (!empty($user->validation_errors['password']['validpwd'])): ?>
            <div><em>Password</em> should not contain spaces
            </div>
        <?php //endif ?>
        <?php elseif (!$user->same_password): ?>
            <div>The <em>Passwords</em> do not match. 
            </div>
        <?php endif ?>
    </div>
<?php endif ?>



<div class="well span5 offset3" style="padding:25px;">
    <form method="post" action="<?php clean_output(url('')); ?>">
    <table>
    <tr>
        <td align="right">Name:</td>
        <td><input type="text" name="name" placclean_outputolder="Jet Li"/>
        <font class="text-error">*</font></td>
    </tr>
    <tr>
        <td align="right">Email address:</td>
        <td><input type="text" name="email" placclean_outputolder="karate@hollywood.com"/>
        <font class="text-error">*</font></td>
    </tr>
    <tr>
        <td align="right">Username:</td>
        <td><input type="text" name="uname" placclean_outputolder="jetli222"/>
        <font class="text-error">*</font></td>
    </tr>
    <tr>
        <td align="right">Password:</td>
        <td><input type="password" name="pwd1"/>
        <font class="text-error">*</font></td>
    </tr>
    <tr>
        <td align="right">Re-Type Password:</td>
        <td><input type="password" name="pwd2"/>
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



