<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Community Fridge</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Community Fridge">
    <meta name="keywords" content="Community Fridge">
    <meta name="author" content="Synergistics FZ LLC">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url(); ?>assets/images/favicon.png">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style.css">
</head>
<body>
<div id="wrapper">
    <div class="reset-wrap">
        <div class="reset-inner">
            <?php if(!$msg){ ?>
            <h2>Reset Password</h2>
            <form action="<?php echo base_url() . 'password/reset'; ?>" method="post">
                <h5><?php echo validation_errors();?></h5>
                <div class="input-wrap">
                    <input type="password" name="password" placeholder="Type new password" required="required">
                </div>
                <div class="input-wrap">
                    <input type="password" name="c_password" placeholder="Re-type password" required="required">
                </div>
                <input type="submit" value="Reset Now" name="reset_btn">
            </form>
            <?php }else{ ?>
            <h2><?php echo $msg; ?></h2>
            <?php } ?>
            <img src="<?php echo base_url(); ?>assets/images/logo.png" alt="logo" class="main-logo">
        </div>
    </div>
</div>
</body>
</html>