<style>
    form {
        border: 3px solid #f1f1f1;
    }

    input[type=text], input[type=password], textarea, select{
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
        color: red;
        text-align: center;
    }
</style>

<h2>Individual Push Notification</h2>

<form action="<?php echo base_url() . 'ind_product_notification'; ?>" method="post">

    <h3><?php echo $this->session->userdata('error');
$this->session->unset_userdata('error');
?></h3>

    <div class="container">
        <label><b>User</b></label>
        <select name="email">
            <option value="">Select User</option>
            <?php foreach($users as $user): ?>
            <option value="<?php echo $user['email']; ?>"><?php echo ucwords($user['username']).' - '.$user['email']; ?></option>
            <?php endforeach; ?>
        </select>
        
        <label><b>Title</b></label>
        <input type="text" id="title" name="title" class="form-control" required="required">

        <label><b>Message</b></label>
        <textarea id="msg" name="msg" class="form-control" rows="5" required="required"></textarea>

        <button type="submit" class="btn btn-primary pull-right">Send</button>
    </div>
</form>