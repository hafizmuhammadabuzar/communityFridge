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
                <?php $url = (isset($area)) ? 'update_area' : 'save_area'; 
                echo $page = (isset($area)) ? 'Edit' : 'New'; ?> Area
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-6">
                        <form role="form" action="<?php echo base_url().'admin/'.$url; ?>" method="post">
                            <div class="form-group">
                                <label>Area Name*</label>
                                <input class="form-control" name="area" value="<?php echo $area->area; ?>" required="required">
                            </div>                         
                            <div class="form-group">
                                <label>Polygon*</label>
                                <textarea id="polygon" name="polygon" class="form-control" rows="5" placeholder="Longitude,Latitude <enter> Longitude,Latitude" required='required'><?php echo $area->polygon; ?></textarea>
                            </div>
                            <div class="form-group">
                                <?php 
                                $rest = ($area->is_restricted == 1) ? 'checked="checked"' : ''; 
                                $unrest = ($area->is_restricted == 0 || !isset($area)) ? 'checked="checked"' : ''; 
                                ?>
                                <input type="radio" id="restricted" name="restricted" class="form-control" <?php echo $rest; ?> value="1">Restricted
                                <input type="radio" id="restricted" name="restricted" class="form-control" <?php echo $unrest; ?> value="0">Unrestricted
                            </div>
                            <?php if(isset($area)){ ?>
                            <input type="hidden" name="area_id" value="<?php echo bin2hex($area->area_id); ?>">
                            <?php } ?>
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

<!--<script type="text/javascript">
    $(document).ready(function () {
        
        $('.polygon-main a').click(function (e) {
            e.preventDefault();
            $("#polygon-clone:last").clone().find("input:text").val("").end().appendTo(".polygon-main");
        });
        $(document).on("click", ".clone-remove", function (e) {
            if ($('div[id^=polygon]').length > 1) {
                $(this).closest('#polygon-clone').remove();
            } else {
                $('#polygon').val('');
            }
        });
    });
</script>-->
