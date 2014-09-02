<br />
<h2 class="offset3 center span5">Register a New account</h2>
<?php if ($register->hasError()): ?>
    <div class="alert alert-danger span5 offset3">
        <h4 class="alert-heading">Validation error!</h4>
        <?php if (!empty($register->validation_errors['name']['length'])): ?>
            <div><em>Name</em> must be  between
            <?php output($register->validation['name']['length'][1]) ?> and
            <?php output($register->validation['name']['length'][2]) ?> characters in length.
            </div>
        <?php endif ?>
        <?php if (!empty($register->validation_errors['name']['validname'])): ?>
            <div>Please enter a valid <em>Name</em>
            </div>
            <?php endif ?>
        <?php if (!empty($register->validation_errors['email']['length'])): ?>
            <div><em>Email</em> must be between
            <?php output($register->validation['email']['length'][1]) ?> and
            <?php output($register->validation['email']['length'][2]) ?> characters in length.
            </div>
        <?php endif ?>
            <?php if (!empty($register->validation_errors['email']['validemail'])): ?>
            <div>Please enter a valid <em>Email</em>
            </div>
        <?php endif ?>
        <?php if (!empty($register->validation_errors['uname']['length'])): ?>
            <div><em>Username</em> must be  between
            <?php output($register->validation['uname']['length'][1]) ?> and
            <?php output($register->validation['uname']['length'][2]) ?> characters in length.
            </div>
        <?php endif ?>
        <?php if (!empty($register->validation_errors['uname']['validuname'])): ?>
            <div>Please enter a valid <em>Username</em>
            </div>
            <?php endif ?>
        <?php if (!empty($register->validation_errors['pwd']['length'])): ?>
            <div><em>Password</em> must be  between
            <?php output(($register->validation['pwd']['length'][1])/2) ?> and
            <?php output(($register->validation['pwd']['length'][2])/2) ?> characters in length.
            </div>
        <?php endif ?>
            <?php if (!empty($register->validation_errors['pwd']['validpwd'])): ?>
            <div><em>Password</em> should not contain spaces
            </div>
        <?php endif ?>
        <?php if(!empty($register->validation_errors['pwd']['pwd_match'])): ?>
            <div>The <em>Passwords</em> do not match. 
            </div>
        <?php endif ?>
    </div>
<?php endif ?>



<div class="well span5 offset3" style="padding:25px;">
    <form method="post" action="<?php output(url('')); ?>">
    <table>
    <tr>
        <td align="right">Name:</td>
        <td><input type="text" name="name" placoutputolder="Jet Li"/>
        <font class="text-error">*</font></td>
    </tr>
    <tr>
        <td align="right">Email address:</td>
        <td><input type="text" name="email" placoutputolder="karate@hollywood.com"/>
        <font class="text-error">*</font></td>
    </tr>
    <tr>
        <td align="right">Username:</td>
        <td><input type="text" name="uname" placoutputolder="jetli222"/>
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
        <td><input type="hidden" name="added" value="yesadded" />
        <input type="submit" class="btn btn-inverse" name="regbtn" /></td>
        <td><font class="text-error">*Required Fields</font></td>
    </tr>
    </table>       
    </form> 
</div>



