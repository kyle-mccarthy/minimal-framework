<h1>Login</h1>
<?php if (isset($_SESSION['error']) && $_SESSION['error']['for'] == "login-form"): ?>
    <div class="alert alert-danger" role="alert">
        <strong>Error</strong> <?php echo $_SESSION['error']['message']; ?>
    </div>
<?php endif; ?>
<form role="form" action="index.php?r=post-login" method="POST">
    <div class="form-group">
        <label for="login-username">Username</label>
        <input type="text" class="form-control" id="login-username"
               name="username" placeholder="Enter username" value="<?php echo $_SESSION['error']['variables']['username']; ?>">
    </div>
    <div class="form-group">
        <label for="login-password">Password</label>
        <input type="password" class="form-control" id="login-password" name="password" placeholder="Password">
    </div>
    <button type="submit" class="btn btn-primary">Login</button>
</form>