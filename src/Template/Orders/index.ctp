<div class="main-panel">
    <nav class="navbar navbar-transparent navbar-absolute">
        <div class="container-fluid">
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="#pablo" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="material-icons">person</i>
                            <p class="hidden-lg hidden-md">Profile</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">

                        <div class="card-content table-responsive">
                            <table class="table" id="orderTable">
                                <thead class="text-primary">
                                <th>Id</th>
                                <th>Order Id</th>
                                <th>Restaurant Name</th>
                                <th>Status</th>
                                <th>Added Date</th>
                                <th>Assing To</th>
                                </thead>
                                <tbody>
                                <?php if(!empty($orderDetails)) {
                                    foreach ($orderDetails as $key => $value) { ?>
                                        <tr>
                                            <td><?php echo $key+1; ?></td>
                                            <td><?php echo $value['order_id']; ?></td>
                                            <td><?php echo $value['restaurant_name']; ?></td>
                                            <td><?php echo $value['status']; ?></td>
                                            <td><?php echo date('Y-m-d h:i A', strtotime($value['created'])); ?></td>
                                            <td>
                                                <?php if($value['assigned_driver'] == '') { ?>
                                                    <button class="btn btn-primary pull-right" type="button">
                                                        Update Profile
                                                        <div class="ripple-container"></div>
                                                    </button>
                                                <?php }else {
                                                    echo 'sundar'
                                                    ?>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('#orderTable').DataTable({
            columnDefs: [ { orderable: false, targets: [-1,-2] } ]
        });
    });
</script>