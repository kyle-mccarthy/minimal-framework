<h1>Register</h1>
<?php if (isset($_SESSION['error']) && $_SESSION['error']['for'] == "register-form"): ?>
    <div class="alert alert-danger" role="alert">
        <strong>Error</strong> <?php echo $_SESSION['error']['message']; ?>
    </div>
<?php endif; ?>
<form role="form" action="index.php?r=post-register" method="POST">
    <div class="form-group">
        <label for="register-username">Username</label>
        <input type="text" class="form-control" id="register-username"
               name="username" placeholder="Enter username" value="<?php echo $_SESSION['error']['variables']['username']; ?>">
    </div>
    <div class="form-group">
        <label for="register-password">Password</label>
        <input type="password" class="form-control" id="register-password" name="password" placeholder="Password">
    </div>
    <button type="submit" class="btn btn-primary">Register</button>
</form>