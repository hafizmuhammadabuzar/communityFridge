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

        <div class="panel panel-default">
            <div class="panel-heading">
                Edit Fridge
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-6">
                        <form role="form" action="<?php echo base_url().'admin/update_fridge' ?>" method="post" id="myForm">
                            <div class="form-group">
                                <label>Country</label>
                                <input class="form-control" name="country" value="<?php echo $fridge->country; ?>" required="required">
                            </div>
                            <div class="form-group">
                                <label>Services</label>
                                <input class="form-control" name="services" value="<?php echo $fridge->services; ?>" required="required">
                            </div>
                            <div class="form-group">
                                <label>Latitude</label>
                                <input class="form-control" name="lat" value="<?php echo $fridge->latitude; ?>" required="required">
                            </div>
                            <div class="form-group">
                                <label>Longitude</label>
                                <input class="form-control" name="lng" value="<?php echo $fridge->longitude; ?>" required="required">
                            </div>
                            <div class="form-group">
                                <label>Access Time</label>
                                <input class="form-control" name="accessTime" value="<?php echo $fridge->access_time; ?>" required="required">
                            </div>
                            <div class="form-group">
                                <label>Preferred Filling Time</label>
                                <input class="form-control" name="preferredFillTime" value="<?php echo $fridge->preferred_filling_time; ?>" required="required">
                            </div>
                            <div class="form-group">
                                <label>Area</label>
                                <input class="form-control" name="area" value="<?php echo $fridge->area; ?>" required="required">
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <input class="form-control" name="streetAddress" value="<?php echo $fridge->address; ?>" required="required">
                            </div><br/>
                            <input type="hidden" name="fridge_id" value="<?php echo bin2hex($fridge->item_id); ?>">
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