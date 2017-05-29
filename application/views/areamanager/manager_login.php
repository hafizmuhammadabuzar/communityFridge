<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Please Sign In</h3>
                </div>
                <div class="panel-body">
                    <?php echo $this->session->userdata('error');
                    $this->session->unset_userdata('error');
                    ?>
                    <form id="loginForm" role="form" action="<?php echo base_url('areamanager/login'); ?>" method="post">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="Email" name="email" type="text" required="required" autofocus>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Password" name="password" type="password" required="required">
                            </div>
                            <!-- Change this to a button or input when using this as a form -->

                            <button class="btn btn-lg btn-success btn-block">Submit</button>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function submit(){
        document.getElementById("loginForm").submit();
    }
</script>
