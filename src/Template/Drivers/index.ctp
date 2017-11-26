<div class="main-panel">
    <nav class="navbar navbar-transparent navbar-absolute">
        <div class="container-fluid">
           <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="<?php echo DISPATCH_URL ?>drivers/add" class="btn btn-primary pull-right">
                            Add New
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
                            <table class="table" id="driverTable">
                                <thead class="text-primary">
                                <th>Id</th>
                                <th>Driver Name</th>
                                <th>Phone Number</th>
                                <th>Driver Status</th>
                                <th>Status</th>
                                <th>Added Date</th>
                                <th>Action</th>
                                </thead>
                                <tbody>
                                <?php if(!empty($driverDetails)) {
                                    foreach ($driverDetails as $key => $value) { ?>
                                        <tr>
                                            <td><?php echo $key+1; ?></td>
                                            <td><?php echo $value['firstname'].''.$value['lastname']; ?></td>
                                            <td><?php echo $value['phone_number']; ?></td>
                                            <td><?php echo $value['driver_status']; ?></td>
                                            <td id="status_<?php echo $value['id'];?>">
                                                <?php if($value['status'] == '1') { ?>
                                                    <i class="fa fa-toggle-on fa-2x toggleactive" id="on" onclick="changeStatus('<?= $value['id'] ?>', '0', 'status', 'drivers/ajaxaction', 'driverstatuschange')"></i>
                                                <?php }else { ?>
                                                    <i class="fa fa-toggle-on fa-2x fa-rotate-180 inactive" id="off" onclick="changeStatus('<?= $value['id'] ?>', '1', 'status', 'drivers/ajaxaction', 'driverstatuschange')" ></i>
                                                <?php } ?>
                                            </td>
                                            <td><?php echo date('Y-m-d h:i A', strtotime($value['created'])); ?></td>

                                            <td>

                                                <a href="<?php echo DISPATCH_URL; ?>drivers/edit/<?php echo $value['id'];?>" class="" data-original-title="Edit" data-placement="top" data-toggle="tooltip" id="<?php echo $value['id']; ?>" >
                                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                                </a>
                                                <button class="" data-original-title="Delete" data-placement="top" data-toggle="tooltip" type="button" id="<?php echo $value['id']; ?>" onclick="return deleteRecord(<?php echo $value['id']; ?>, 'customers/deletecust', 'customers', '', 'catTable')">

                                                    <i class="fa fa-trash-o"></i>
                                                </button>
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
        $('#driverTable').DataTable({
            columnDefs: [ { orderable: false, targets: [-1,-2] } ]
        });
        $('.middle').click(function() {
            $('.inactive, .toggleactive').toggle();
        });
    });

    function changeStatus(id, changestaus, field, urlval, action)
    {
        $.ajax({
            type   : 'POST',
            url    : baseUrl+''+urlval,
            data   : {id:id, field:field ,changestaus:changestaus,action:action},
            success: function(data){
                //clearConsole();
                $("#"+field+"_"+id).html(data);
                return false;
            }
        });
        return false;
    }

</script>