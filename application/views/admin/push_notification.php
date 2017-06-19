<div id="wrapper">

    <!-- Navigation -->
    <?php include 'navigation.php'; ?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Dashboard</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <?php echo validation_errors(); ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                Push Notification
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-6">
                        <form role="form" action="<?php echo base_url() . 'product_notification'; ?>" method="post">
                            <div class="form-group">
                                <label>Title *</label>
                                <input class="form-control" name="title" required="required">
                            </div>
                            <div class="form-group">
                                <label>Message *</label>
                                <textarea id="msg" name="msg" class="form-control" rows="5" required="required" maxlength="255"></textarea>
                                <h6 class="pull-right" id="count_message"></h6>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" id="send_to_android" name="send_to_android" class="form-control" checked="checked">Android
                                <input type="checkbox" id="send_to_ios" name="send_to_ios" class="form-control" checked="checked">iOS
                            </div>
                            <br/>
                            <button type="submit" class="btn btn-default" name="add">Submit</button>
                        </form>
                    </div>
                </div>
                <!-- /.row (nested) -->
            </div>
            <!-- /.panel-body -->
        </div>

    </div>
    <!-- /#page-wrapper -->

</div><!-- /#wrapper -->
<script type="text/javascript">
    $(document).ready(function(){
        var text_max = 255;
        $('#count_message').html(text_max + ' remaining');
        
        $('#msg').keyup(function() {
          var text_length = $('#msg').val().length;
          var text_remaining = text_max - text_length;

          $('#count_message').html(text_remaining + ' remaining');
        }); 
    });
</script>