<?php $title = "Login Page";?>
<br />  
<h2 class="offset3 span5 center">Login</h2> 
    <?php if ($login->hasError() || $login_error || $blocked_error): ?>
        <div class="offset3 span5 center">
            <img src="img/bartnlisa.gif" />
        </div> 
        <div class="alert alert-danger span5 offset3 center" >
            <?php if (empty($login->username) || empty($login->password)): ?>
                <div>Please fill up all the fields</div>
            <?php elseif ($login_error): ?>
                <div>Incorrect Username/Password</div> 
            <?php elseif ($blocked_error): ?>
                <div>You have been blocked by the admins</div>  
            <?php endif ?>
        </div>
    <?php endif ?>
<div class="well span5 offset3 center" style="padding:25px;">
    <br />  
    <form method="post" action="<?php clean_output(url('')); ?>">
        <table align="center">
            <tr>
                <td align="right">Username: </td>
                <td><input type="text" name="username" maxlength="30"/>
                <font class="text-error">*</font></td>
            </tr>
            <tr>
                <td align="right">Password: </td>
                <td><input type="password" name="password" maxlength="30"/>
                <font class="text-error">*</font></td>
            </tr>
            <tr>
                <td><input type="hidden" name="checklogin" value="/topic/topics" /></td>
                <td><input type="submit" class="btn btn-inverse span3" name="login" value="Login" /></td>
            </tr>
         </table>       
    </form> 
</div>
