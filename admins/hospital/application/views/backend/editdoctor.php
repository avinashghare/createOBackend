<section class="panel">
<header class="panel-heading">
<h3 class="panel-title">doctor Details </h3>
</header>
<div class="panel-body">
<form class='form-horizontal tasi-form' method='post' action='<?php echo site_url("site/editdoctorsubmit");?>' enctype= 'multipart/form-data'>
<input type="hidden" id="normal-field" class="form-control" name="id" value="<?php echo set_value('id',$before->id);?>" style="display:none;">
<div class="form-group">
<label class="col-sm-2 control-label" for="normal-field">Name</label>
<div class="col-sm-4">
<input type="text" id="normal-field" class="form-control" name="name" value='<?php echo set_value('name',$before->name);?>'>
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label" for="normal-field">Degree</label>
<div class="col-sm-4">
<input type="text" id="normal-field" class="form-control" name="degree" value='<?php echo set_value('degree',$before->degree);?>'>
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label" for="normal-field">Specialization</label>
<div class="col-sm-4">
<input type="text" id="normal-field" class="form-control" name="specialization" value='<?php echo set_value('specialization',$before->specialization);?>'>
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label" for="normal-field">Available Days</label>
<div class="col-sm-4">
<input type="text" id="normal-field" class="form-control" name="availabledays" value='<?php echo set_value('availabledays',$before->availabledays);?>'>
</div>
</div>
<div class=" form-group">
<label class="col-sm-2 control-label" for="normal-field">Type</label>
<div class="col-sm-4">
<?php echo form_dropdown("type",$type,set_value('type',$before->type),"class='chzn-select form-control'");?>
</div>
</div>
<div class=" form-group">
<label class="col-sm-2 control-label" for="normal-field">Hospital</label>
<div class="col-sm-4">
<?php echo form_dropdown("hospital",$hospital,set_value('hospital',$before->hospital),"class='chzn-select form-control'");?>
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label" for="normal-field">&nbsp;</label>
<div class="col-sm-4">
<button type="submit" class="btn btn-primary">Save</button>
<a href='<?php echo site_url("site/viewdoctor"); ?>' class='btn btn-secondary'>Cancel</a>
</div>
</div>
</form>
</div>
</section>
