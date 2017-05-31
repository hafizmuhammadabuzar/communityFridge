<div id="wrapper">

    <!-- Navigation -->
    <?php include 'navigation.php'; ?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Dashboard</h1>
            </div>
            <!-- /.col-lg-12 -->
            
            <div class="form-group col-lg-3">
                <form action="<?php echo base_url().strstr($_SERVER['REQUEST_URI'], 'admin'); ?>" method="post">
                    <select class="form-control" name="sort" id="sort" required="required">
                        <option value="">Sort By:</option>
                        <option value="name" <?php if($this->session->userdata('sorted') == 'name') echo 'selected="selected"'; ?>>Name</option>
                        <option value="date" <?php if($this->session->userdata('sorted') == 'date') echo 'selected="selected"'; ?>>Date</option>
                    </select>
                    <button type="submit" class="btn btn-default" name="sort_btn">Submit</button>
                </form>
            </div>
        </div>
        <?php echo $this->session->userdata('msg'); $this->session->unset_userdata('msg'); ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                View Users
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
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Account Type</th>
                                    <th>Status</th>
                                    <th>Created at</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php foreach( $users as $row ): ?>
                                    <tr class="gradeA odd" role="row">
                                        <td><?php echo ucwords($row['username']); ?></td>
                                        <td><?php echo $row['email']; ?></td>
                                        <td><?php echo $row['account_type']; ?></td>
                                        <td>
                                            <a href="javascript:" class="f-status" data-value="<?php echo bin2hex($row['user_id']); ?>">
                                            <?php if($row['status'] == 1 || $row['account_type'] == 'facebook'){ echo 'Active'; }else{ echo 'Pending'; } ?>
                                            </a>
                                            </td>
                                        <td><?php echo date('d-m-Y h:i a', strtotime($row['created_at'])); ?></td>
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
                            url: "<?php echo base_url('admin/user_status'); ?>",
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