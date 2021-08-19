<div class="content-page">
<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box">
				    <div class="card">
					    <div class="card-body">
				<h3 class="text-center">View & Manage SAP Connections List</h3>
				<a href="<?php echo base_url('sap/create-new-connection') ?>" class="btn btn-info"><i class="fa fa-plus"></i> Create New Connection</a>
								<?php $this->load->view('inc/after-form-submitted'); ?>

				<form action="" method="post">

				<table id="datatable-buttons" class="table table-bordered table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th class="text-center" style="min-width: 70px">S.No. <input type="checkbox" name="checkboxall" id="checkAll"></th>
							<th>Client Name</th>
							<th>Connection Name</th>
							<th>Ashost</th>
							<th>Sysnr</th>
							<th>Client</th>
							<th>User</th>
							<!-- <th>Gwhost</th>
							<th>Gwserv</th>
							<th>Mshost</th>
							<th>R3 Name</th>
							<th>Group</th>
							<th>Lang</th>
							<th>Tsfile</th> -->
							<th>Status</th>
							<th>Edit</th>
							<th>View</th>
							<th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                    	<?php $counter = 1; foreach ($connections as $key => $connection) { ?>
                    		<tr>
                    			<td><input type="checkbox" name="connection_id[]" value="<?php echo $connection['id'] ?>"> <?php echo ($counter<10)?'0'.$counter:$counter ?></td>
								<td><?php $client_id = $connection['fk_client_id'];
								$client = $this->common_model->get_entry_by_data('clients',true,['id'=>$client_id],'serial_no,client_name');
								echo $client['client_name'].' ('.$client['serial_no'].')';
								 ?></td>
								<td><?php echo $connection['connection_name'] ?></td>
				                <td><?php echo $connection['ashost'] ?></td>
				                <td><?php echo $connection['sysnr'] ?></td>
				                <td><?php echo $connection['client'] ?></td>
				                <td><?php echo $connection['user'] ?></td>
				                <!--<td><?php echo $connection['gwhost'] ?></td>
				                <td><?php echo $connection['gwserv'] ?></td>
				                <td><?php echo $connection['mshost'] ?></td>
				                <td><?php echo $connection['r3name'] ?></td>
				                <td><?php echo $connection['group'] ?></td>
				                <td><?php echo $connection['lang'] ?></td>
				                <td><?php echo $connection['tsfile'] ?></td> -->
								<td class="text-center"><?php echo $connection['active_inactive'] ?></td>
								<td><a href="<?php echo base_url('sap/edit-connection-details/'.id_encode($connection['id'])) ?>" class="btn btn-info">Edit</a></td>
								<td><a href="<?php echo base_url('sap/view-connection-details/'.id_encode($connection['id'])) ?>" class="btn btn-success">View</a></td>
								<td><a href="<?php echo base_url('sap/delete-connection/'.id_encode($connection['id'])) ?>" class="btn btn-danger">Delete</a></td>
                    		</tr>
                    	<?php $counter++; } ?>
                    </tbody>
                    </table>

                    <br>
                    <div class="row">
					<div class="col-1">Status : </div>
					<div class="col-2"><input type="radio" name="update_status" value="Active" checked> Active 
						<input type="radio" name="update_status" value="Inactive"> Inactive
					</div>
					<div class="col-1">
						<input type="submit" name="submit" value="Submit" class="btn btn-success">
					</div>
					</div>
			</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>