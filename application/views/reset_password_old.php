<style>
    form {
        border: 3px solid #f1f1f1;
    }

    input[type=password] {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        box-sizing: border-box;
    }

    button {
        background-color: #4CAF50;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
    }

    .cancelbtn {
        width: auto;
        padding: 10px 18px;
        background-color: #f44336;
    }

    .imgcontainer {
        text-align: center;
        margin: 24px 0 12px 0;
    }

    img.avatar {
        width: 40%;
        border-radius: 50%;
    }

    .container {
        padding: 16px;
    }

    span.psw {
        float: right;
        padding-top: 16px;
    }
    body{
        width: 40%;
        margin: 0 auto;
    }

    /* Change styles for span and cancel button on extra small screens */
    @media screen and (max-width: 300px) {
        span.psw {
            display: block;
            float: none;
        }
        .cancelbtn {
            width: 100%;
        }
    }

    h3{
        color: green;
        text-align: center;
        border: 3px solid #f1f1f1;
        margin-top: 20px;
        padding: 20px;
    }
    h5{
        color: red;
        text-align: center;
    }
</style>

<?php if(!$msg){ ?>
<h2>Reset Password</h2>

<form action="<?php echo base_url() . 'password/reset'; ?>" method="post">

    <h5><?php echo validation_errors();?></h5>

    <div class="container">
        <label><b>Password</b></label>
        <input type="password" id="password" name="password" class="form-control" required="required">
        
        <label><b>Confirm Password</b></label>
        <input type="password" id="c_password" name="c_password" class="form-control" required="required">

        <button type="submit" class="btn btn-primary pull-right" name="reset_btn">Send</button>
    </div>
</form>
<?php }else{ ?>
<h3><?php echo $msg; ?></h3>
<?php } ?>