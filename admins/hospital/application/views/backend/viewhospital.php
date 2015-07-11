<div id="page-title">
<a class="btn btn-primary btn-labeled fa fa-plus margined pull-right" href="<?php echo site_url("site/createuser"); ?>">Create</a>
<h1 class="page-header text-overflow">hospital Details </h1>
</div>
<div id="page-content">
<div class="row">
<div class="col-lg-12">
<div class="panel drawchintantable">
<?php $this->chintantable->createsearch("hospital List");?>
<div class="fixed-table-container">
<div class="fixed-table-body">
<table class="table table-hover" id="" cellpadding="0" cellspacing="0">
<thead>
<tr>
<th data-field="id">ID</th>
<th data-field="name">Name</th>
<th data-field="type">Type</th>
<th data-field="address">Address</th>
<th data-field="faxnumber">Fax Number</th>
<th data-field="landline1">Landline Number 1</th>
<th data-field="landline2">Landline Number 2</th>
<th data-field="emergencynumber1">Emergency Number 1</th>
<th data-field="emergencynumber2">Emergency Number 2</th>
<th data-field="ambulance">Ambulance Service</th>
<th data-field="ambulancecontact1">Ambulance Contact 1</th>
<th data-field="ambulancecontact2">Ambulance Contact 2</th>
<th data-field="nearestpolicestation">Nearest Police Station</th>
<th data-field="facility">Facility</th>
<th data-field="facilitycharges">Facility Charges</th>
<th data-field="typeofroom">Type Of Room</th>
<th data-field="roomchargeswithtax">Room Charges With Tax</th>
<th data-field="noofbed">Number Of Beds</th>
<th data-field="availablestatus">Available Status</th>
<th data-field="diagnosticcenteravailable">Diagnostic Center Available</th>
<th data-field="department">Department</th>
<th data-field="condition">Condition</th>
<th data-field="description">Description</th>
</tr>
</thead>
<tbody>
</tbody>
</table>
</div>
<div class="fixed-table-pagination" style="display: block;">
<div class="pull-left pagination-detail">
<?php $this->chintantable->createpagination();?>
</div>
</div>
</div>
</div>
</div>
</div>
<script>
function drawtable(resultrow) {
return "<tr><td>" + resultrow.id + "</td><td>" + resultrow.name + "</td><td>" + resultrow.type + "</td><td>" + resultrow.address + "</td><td>" + resultrow.faxnumber + "</td><td>" + resultrow.landline1 + "</td><td>" + resultrow.landline2 + "</td><td>" + resultrow.emergencynumber1 + "</td><td>" + resultrow.emergencynumber2 + "</td><td>" + resultrow.ambulance + "</td><td>" + resultrow.ambulancecontact1 + "</td><td>" + resultrow.ambulancecontact2 + "</td><td>" + resultrow.nearestpolicestation + "</td><td>" + resultrow.facility + "</td><td>" + resultrow.facilitycharges + "</td><td>" + resultrow.typeofroom + "</td><td>" + resultrow.roomchargeswithtax + "</td><td>" + resultrow.noofbed + "</td><td>" + resultrow.availablestatus + "</td><td>" + resultrow.diagnosticcenteravailable + "</td><td>" + resultrow.department + "</td><td>" + resultrow.condition + "</td><td>" + resultrow.description + "</td><td><a class='btn btn-primary btn-xs' href='<?php echo site_url('site/edithospital?id=');?>"+resultrow.id+"'><i class='icon-pencil'></i></a><a class='btn btn-danger btn-xs' onclick=return confirm(\"Are you sure you want to delete?\") href='<?php echo site_url('site/deletehospital?id='); ?>"+resultrow.id+"'><i class='icon-trash '></i></a></td></tr>";
}
generatejquery("<?php echo $base_url;?>");
</script>
</div>
</div>
