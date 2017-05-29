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
        <?php echo $this->session->userdata('msg');
        $this->session->unset_userdata('msg');
        ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                View Fridges
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline"
                                   id="dataTables-example" role="grid" aria-describedby="dataTables-example_info"
                                   style="width: 100%;" width="100%">
                                <thead>
                                    <tr role="row">
                                        <th>Country</th>
                                        <th>Area</th>
                                        <th>Address</th>
                                        <th>Services</th>
                                        <th>Username</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

<?php foreach ($items as $item): ?>
                                        <tr class="gradeA odd" role="row">
                                            <td><?php echo $item['country']; ?></td>
                                            <td><?php echo $item['area']; ?></td>
                                            <td><?php echo $item['address']; ?></td>
                                            <td><?php echo $item['services']; ?></td>
                                            <td><?php echo ucwords($item['username']); ?></td>
                                            <td>
                                                <a href="javascript:" class="f-status" data-value="<?php echo bin2hex($item['item_id']); ?>">
                                                <?php if ($item['is_active'] == 0) {
                                                    echo 'Inactive';
                                                }else{
                                                    echo 'Active';
                                                }
                                                ?>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="<?php echo base_url() . 'manager/edit_fridge/' . bin2hex($item['item_id']); ?>" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a> |
                                                <a href="<?php echo base_url() . 'manager/delete_fridge/' . bin2hex($item['item_id']); ?>" title="Delete">
                                                    <i class="fa fa-remove" style="color: #880000"></i>
                                                </a>
                                            </td>
                                        </tr>
<?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->

                        <!-- /.panel-body -->
                    </div>
                    <div style="text-align: right;">
                        <?php echo $links; ?>
                    </div>
                        
                    

                </div>
                <!-- /#page-wrapper -->
            </div><!-- /#wrapper -->

            <script type="text/javascript">
                $(document).ready(function () {

                    $('.f-status').click(function () {

                        var id = $(this).data('value');
                        var status = $(this).text();
                        var newStatus = this;
                        $.ajax({
                            method: "POST",
                            data: {status: status, id: id},
                            url: "<?php echo base_url('admin/fridge_status'); ?>",
                            success: function (response) {
                                if (response == 1) {
                                    $(self).removeAttr('href');
                                    if ($.trim(status) == 'Active') {
                                        alert('Successfully Inactive');
                                        $(newStatus).text('Inactive');
                                    }else{
                                        alert('Successfully Active');
                                        $(newStatus).text('Active');
                                    }   
                                }
                            }
                        });
                    });
                });
            </script>
