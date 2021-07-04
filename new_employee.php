<?php if(!isset($conn)){ include 'db_connect.php'; } 



$z = date_default_timezone_set("Asia/Dhaka");
$d=strtotime("now");
$asd = date("Y-m-d\TH:i", $d);
$as = date("Y-m-d", $d);
?>

<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-body">
			<form action="" id="manage-employee">

        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
		<div class="row">
			
			<div class="col-md-4">
				<div class="form-group">
					<label for="" class="control-label">Name</label>
					<input type="text" class="form-control form-control-sm" name="member_name" value="<?php echo isset($member_name) ? $member_name : '' ?>">
				</div>
			</div>
			

          	<div class="col-md-4">
				<div class="form-group">
					<label for="">Shift</label>
					<select name="shift" id="shift" class="custom-select custom-select-sm">
						<option value="1" <?php echo isset($shift) && $shift == 1 ? 'selected' : '' ?>>Morning</option>
						<option value="2" <?php echo isset($shift) && $shift == 2 ? 'selected' : '' ?>>Evening</option>
						<option value="3" <?php echo isset($shift) && $shift == 3 ? 'selected' : '' ?>>No Shift</option>
					</select>
				</div>
			</div>
		</div>
		
		

		
        </form>
    	</div>
    	<div class="card-footer border-top border-info">
    		<div class="d-flex w-100 justify-content-center align-items-center">
    		    <?php // if(isset($status) && $status == 5 && $_SESSION['login_type'] == 1 ): ?>
    		    <!-- <button class="btn btn-flat  bg-gradient-info mx-2" form="">Finished</button> -->
    		    <?php // endif; ?>
    			<button class="btn btn-flat  bg-gradient-primary mx-2" form="manage-employee">Save</button>
    			<button class="btn btn-flat bg-gradient-secondary mx-2" type="button" onclick="location.href='index.php?page=shift'">Cancel</button>
    		</div>
    	</div>
	</div>
</div>
</div>
<script>
	$('#manage-employee').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_employee',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp == 1){
					alert_toast('Data successfully saved',"success");
					setTimeout(function(){
						location.href = 'index.php?page=shift'
					},2000)
				}
			}
		})
	})

</script>