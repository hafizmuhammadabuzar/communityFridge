<?php $method = $this->uri->segment(3); ?>
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?php echo base_url().'admin/dashboard' ?>">Admin - Community Fridge</a>
    </div>
    <!-- /.navbar-header -->

    <ul class="nav navbar-top-links navbar-right">
        <!-- /.dropdown -->
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="<?php echo base_url().'admin/logout' ?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                </li>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-top-links -->

    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li>
                    <a href="<?php echo base_url().'admin/dashboard'; ?>"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                </li>
                <li>
                    <a href="<?php echo base_url().'admin/view_fridges'; ?>"><i class="fa fa-list-ul fa-fw"></i> Fridges</a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> City Area Manager<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="<?php echo base_url().'admin/add_manager'; ?>" <?php if($method=='add_manager') echo "class='active'" ?>>Add City Area Manager</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url().'admin/view_managers'; ?>" <?php if($method=='view_managers') echo "class='active'" ?>>View City Area Managers</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="<?php echo base_url().'admin/view_sub_managers'; ?>"><i class="fa fa-list-ul fa-fw"></i> View Zone Managers</a>
                </li>
                <li>
                    <a href="<?php echo base_url().'admin/view_users'; ?>"><i class="fa fa-list-ul fa-fw"></i> Users</a>
                </li>
                <li>
                    <a href="<?php echo base_url().'push_form'; ?>" <?php if($method=='push_form') echo "class='active'" ?>><i class="fa fa-bell fa-fw"></i> Push Notification</a>
                </li>
            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>