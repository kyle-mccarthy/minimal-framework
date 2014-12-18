<?php include('includes/header.php'); ?>

<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h1>Welcome, <?php echo $_SESSION['username']; ?></h1>
            <p><?php echo $_SESSION['description']; ?></p>
            <h2>User Information</h2>
            <?php
            $reg = $_SESSION['registered'];
            ?>
            <p>On <?php echo $reg->log_date; ?> you registered from the IP
            <?php echo $reg->ip_address; ?></p>
            <h2>Log History</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>username</th>
                        <th>ip</th>
                        <th>date</th>
                        <th>action</th>
                    </tr>
                </thead>
                <tbody>
            <?php
            $logs = $_SESSION['logs'];
            for ($i = 0; $i < pg_num_rows($logs); $i++):
                $tmp = pg_fetch_object($logs, $i);
            ?>
                <tr>
                    <td><?php echo $tmp->username; ?></td>
                    <td><?php echo $tmp->ip_address; ?></td>
                    <td><?php echo $tmp->log_date; ?></td>
                    <td><?php echo $tmp->action; ?></td>
                </tr>
            <?php endfor; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include('includes/footer.php');