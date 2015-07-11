<section class="panel">
<header class="panel-heading">
<h3 class="panel-title">patient Details </h3>
</header>
<div class="panel-body">
<form class='form-horizontal tasi-form' method='post' action='<?php echo site_url("site/editpatientsubmit");?>' enctype= 'multipart/form-data'>
<input type="hidden" id="normal-field" class="form-control" name="id" value="<?php echo set_value('id',$before->id);?>" style="display:none;">
<div class="form-group">
<label class="col-sm-2 control-label" for="normal-field">Name</label>
<div class="col-sm-4">
<input type="text" id="normal-field" class="form-control" name="name" value='<?php echo set_value('name',$before->name);?>'>
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label" for="normal-field">Contact</label>
<div class="col-sm-4">
<input type="text" id="normal-field" class="form-control" name="contact" value='<?php echo set_value('contact',$before->contact);?>'>
</div>
</div>
<div class=" form-group">
<label class="col-sm-2 control-label" for="normal-field">Last Selected Hospital</label>
<div class="col-sm-4">
<?php echo form_dropdown("lastselectedhospital",$lastselectedhospital,set_value('lastselectedhospital',$before->lastselectedhospital),"class='chzn-select form-control'");?>
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label" for="normal-field">Last Reported Deciese</label>
<div class="col-sm-4">
<input type="text" id="normal-field" class="form-control" name="lastreporteddeciese" value='<?php echo set_value('lastreporteddeciese',$before->lastreporteddeciese);?>'>
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label" for="normal-field">&nbsp;</label>
<div class="col-sm-4">
<button type="submit" class="btn btn-primary">Save</button>
<a href='<?php echo site_url("site/viewpatient"); ?>' class='btn btn-secondary'>Cancel</a>
</div>
</div>
</form>
</div>
</section>
