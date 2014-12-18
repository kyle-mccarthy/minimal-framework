<h1>Update</h1>
<p>
    <strong>Username: </strong> <?php echo $_SESSION['username']; ?><br>
    <strong>Description: </strong><?php echo $_SESSION['description']; ?>
</p>
<?php if (isset($_SESSION['error']) && $_SESSION['error']['for'] == "login-form"): ?>
    <div class="alert alert-danger" role="alert">
        <strong>Error</strong> <?php echo $_SESSION['error']['message']; ?>
    </div>
<?php endif; ?>
<form role="form" action="index.php?r=post-update" method="POST">
    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" name="description"><?php echo $_SESSION['description']; ?></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>