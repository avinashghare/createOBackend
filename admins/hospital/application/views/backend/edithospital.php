<section class="panel">
<header class="panel-heading">
<h3 class="panel-title">hospital Details </h3>
</header>
<div class="panel-body">
<form class='form-horizontal tasi-form' method='post' action='<?php echo site_url("site/edithospitalsubmit");?>' enctype= 'multipart/form-data'>
<input type="hidden" id="normal-field" class="form-control" name="id" value="<?php echo set_value('id',$before->id);?>" style="display:none;">
<div class="form-group">
<label class="col-sm-2 control-label" for="normal-field">Name</label>
<div class="col-sm-4">
<input type="text" id="normal-field" class="form-control" name="name" value='<?php echo set_value('name',$before->name);?>'>
</div>
</div>
<div class=" form-group">
<label class="col-sm-2 control-label" for="normal-field">Type</label>
<div class="col-sm-4">
<?php echo form_dropdown("type",$type,set_value('type',$before->type),"class='chzn-select form-control'");?>
</div>
</div>
<div class=" form-group">
<label class="col-sm-2 control-label" for="normal-field">Address</label>
<div class="col-sm-4">
<?php echo form_dropdown("address",$address,set_value('address',$before->address),"class='chzn-select form-control'");?>
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label" for="normal-field">Fax Number</label>
<div class="col-sm-4">
<input type="text" id="normal-field" class="form-control" name="faxnumber" value='<?php echo set_value('faxnumber',$before->faxnumber);?>'>
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label" for="normal-field">Landline Number 1</label>
<div class="col-sm-4">
<input type="text" id="normal-field" class="form-control" name="landline1" value='<?php echo set_value('landline1',$before->landline1);?>'>
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label" for="normal-field">Landline Number 2</label>
<div class="col-sm-4">
<input type="text" id="normal-field" class="form-control" name="landline2" value='<?php echo set_value('landline2',$before->landline2);?>'>
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label" for="normal-field">Emergency Number 1</label>
<div class="col-sm-4">
<input type="text" id="normal-field" class="form-control" name="emergencynumber1" value='<?php echo set_value('emergencynumber1',$before->emergencynumber1);?>'>
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label" for="normal-field">Emergency Number 2</label>
<div class="col-sm-4">
<input type="text" id="normal-field" class="form-control" name="emergencynumber2" value='<?php echo set_value('emergencynumber2',$before->emergencynumber2);?>'>
</div>
</div>
<div class=" form-group">
<label class="col-sm-2 control-label" for="normal-field">Ambulance Service</label>
<div class="col-sm-4">
<?php echo form_dropdown("ambulance",$ambulance,set_value('ambulance',$before->ambulance),"class='chzn-select form-control'");?>
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label" for="normal-field">Ambulance Contact 1</label>
<div class="col-sm-4">
<input type="text" id="normal-field" class="form-control" name="ambulancecontact1" value='<?php echo set_value('ambulancecontact1',$before->ambulancecontact1);?>'>
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label" for="normal-field">Ambulance Contact 2</label>
<div class="col-sm-4">
<input type="text" id="normal-field" class="form-control" name="ambulancecontact2" value='<?php echo set_value('ambulancecontact2',$before->ambulancecontact2);?>'>
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label" for="normal-field">Nearest Police Station</label>
<div class="col-sm-4">
<input type="text" id="normal-field" class="form-control" name="nearestpolicestation" value='<?php echo set_value('nearestpolicestation',$before->nearestpolicestation);?>'>
</div>
</div>
<div class=" form-group">
<label class="col-sm-2 control-label" for="normal-field">Facility</label>
<div class="col-sm-4">
<?php echo form_dropdown("facility",$facility,set_value('facility',$before->facility),"class='chzn-select form-control'");?>
</div>
</div>
<div class=" form-group">
<label class="col-sm-2 control-label" for="normal-field">Facility Charges</label>
<div class="col-sm-4">
<?php echo form_dropdown("facilitycharges",$facilitycharges,set_value('facilitycharges',$before->facilitycharges),"class='chzn-select form-control'");?>
</div>
</div>
<div class=" form-group">
<label class="col-sm-2 control-label" for="normal-field">Type Of Room</label>
<div class="col-sm-4">
<?php echo form_dropdown("typeofroom",$typeofroom,set_value('typeofroom',$before->typeofroom),"class='chzn-select form-control'");?>
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label" for="normal-field">Room Charges With Tax</label>
<div class="col-sm-4">
<input type="text" id="normal-field" class="form-control" name="roomchargeswithtax" value='<?php echo set_value('roomchargeswithtax',$before->roomchargeswithtax);?>'>
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label" for="normal-field">Number Of Beds</label>
<div class="col-sm-4">
<input type="text" id="normal-field" class="form-control" name="noofbed" value='<?php echo set_value('noofbed',$before->noofbed);?>'>
</div>
</div>
<div class=" form-group">
<label class="col-sm-2 control-label" for="normal-field">Available Status</label>
<div class="col-sm-4">
<?php echo form_dropdown("availablestatus",$availablestatus,set_value('availablestatus',$before->availablestatus),"class='chzn-select form-control'");?>
</div>
</div>
<div class=" form-group">
<label class="col-sm-2 control-label" for="normal-field">Diagnostic Center Available</label>
<div class="col-sm-4">
<?php echo form_dropdown("diagnosticcenteravailable",$diagnosticcenteravailable,set_value('diagnosticcenteravailable',$before->diagnosticcenteravailable),"class='chzn-select form-control'");?>
</div>
</div>
<div class=" form-group">
<label class="col-sm-2 control-label" for="normal-field">Department</label>
<div class="col-sm-4">
<?php echo form_dropdown("department",$department,set_value('department',$before->department),"class='chzn-select form-control'");?>
</div>
</div>
<div class=" form-group">
<label class="col-sm-2 control-label" for="normal-field">Condition</label>
<div class="col-sm-8">
<textarea name="condition" id="" cols="20" rows="10" class="form-control tinymce"><?php echo set_value( 'condition',$before->condition);?></textarea>
</div>
</div>
<div class=" form-group">
<label class="col-sm-2 control-label" for="normal-field">Description</label>
<div class="col-sm-8">
<textarea name="description" id="" cols="20" rows="10" class="form-control tinymce"><?php echo set_value( 'description',$before->description);?></textarea>
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label" for="normal-field">&nbsp;</label>
<div class="col-sm-4">
<button type="submit" class="btn btn-primary">Save</button>
<a href='<?php echo site_url("site/viewhospital"); ?>' class='btn btn-secondary'>Cancel</a>
</div>
</div>
</form>
</div>
</section>
