<section class="panel">
<header class="panel-heading">
<h3 class="panel-title">useraddress Details </h3>
</header>
<div class="panel-body">
<form class='form-horizontal tasi-form' method='post' action='<?php echo site_url("site/edituseraddresssubmit");?>' enctype= 'multipart/form-data'>
<input type="hidden" id="normal-field" class="form-control" name="id" value="<?php echo set_value('id',$before->id);?>" style="display:none;">
<div class="form-group">
<label class="col-sm-2 control-label" for="normal-field">Name</label>
<div class="col-sm-4">
<input type="text" id="normal-field" class="form-control" name="name" value='<?php echo set_value('name',$before->name);?>'>
</div>
</div>
<div class=" form-group">
<label class="col-sm-2 control-label" for="normal-field">Parent</label>
<div class="col-sm-4">
<?php echo form_dropdown("parent",$parent,set_value('parent',$before->parent),"class='chzn-select form-control'");?>
</div>
</div>
<div class=" form-group">
<label class="col-sm-2 control-label" for="normal-field">External</label>
<div class="col-sm-4">
<?php echo form_dropdown("external",$external,set_value('external',$before->external),"class='chzn-select form-control'");?>
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label" for="normal-field">Location Type</label>
<div class="col-sm-4">
<input type="text" id="normal-field" class="form-control" name="locationtype" value='<?php echo set_value('locationtype',$before->locationtype);?>'>
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label" for="normal-field">Pin</label>
<div class="col-sm-4">
<input type="text" id="normal-field" class="form-control" name="pin" value='<?php echo set_value('pin',$before->pin);?>'>
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label" for="normal-field">&nbsp;</label>
<div class="col-sm-4">
<button type="submit" class="btn btn-primary">Save</button>
<a href='<?php echo site_url("site/viewuseraddress"); ?>' class='btn btn-secondary'>Cancel</a>
</div>
</div>
</form>
</div>
</section>
