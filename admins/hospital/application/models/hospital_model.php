<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class hospital_model extends CI_Model
{
public function create($name,$type,$address,$faxnumber,$landline1,$landline2,$emergencynumber1,$emergencynumber2,$ambulance,$ambulancecontact1,$ambulancecontact2,$nearestpolicestation,$facility,$facilitycharges,$typeofroom,$roomchargeswithtax,$noofbed,$availablestatus,$diagnosticcenteravailable,$department,$condition,$description)
{
$data=array("name" => $name,"type" => $type,"address" => $address,"faxnumber" => $faxnumber,"landline1" => $landline1,"landline2" => $landline2,"emergencynumber1" => $emergencynumber1,"emergencynumber2" => $emergencynumber2,"ambulance" => $ambulance,"ambulancecontact1" => $ambulancecontact1,"ambulancecontact2" => $ambulancecontact2,"nearestpolicestation" => $nearestpolicestation,"facility" => $facility,"facilitycharges" => $facilitycharges,"typeofroom" => $typeofroom,"roomchargeswithtax" => $roomchargeswithtax,"noofbed" => $noofbed,"availablestatus" => $availablestatus,"diagnosticcenteravailable" => $diagnosticcenteravailable,"department" => $department,"condition" => $condition,"description" => $description);
$query=$this->db->insert( "hospital_hospital", $data );
$id=$this->db->insert_id();
if(!$query)
return  0;
else
return  $id;
}
public function beforeedit($id)
{
$this->db->where("id",$id);
$query=$this->db->get("hospital_hospital")->row();
return $query;
}
function getsinglehospital($id){
$this->db->where("id",$id);
$query=$this->db->get("hospital_hospital")->row();
return $query;
}
public function edit($id,$name,$type,$address,$faxnumber,$landline1,$landline2,$emergencynumber1,$emergencynumber2,$ambulance,$ambulancecontact1,$ambulancecontact2,$nearestpolicestation,$facility,$facilitycharges,$typeofroom,$roomchargeswithtax,$noofbed,$availablestatus,$diagnosticcenteravailable,$department,$condition,$description)
{
$data=array("name" => $name,"type" => $type,"address" => $address,"faxnumber" => $faxnumber,"landline1" => $landline1,"landline2" => $landline2,"emergencynumber1" => $emergencynumber1,"emergencynumber2" => $emergencynumber2,"ambulance" => $ambulance,"ambulancecontact1" => $ambulancecontact1,"ambulancecontact2" => $ambulancecontact2,"nearestpolicestation" => $nearestpolicestation,"facility" => $facility,"facilitycharges" => $facilitycharges,"typeofroom" => $typeofroom,"roomchargeswithtax" => $roomchargeswithtax,"noofbed" => $noofbed,"availablestatus" => $availablestatus,"diagnosticcenteravailable" => $diagnosticcenteravailable,"department" => $department,"condition" => $condition,"description" => $description);
$this->db->where( "id", $id );
$query=$this->db->update( "hospital_hospital", $data );
return 1;
}
public function delete($id)
{
$query=$this->db->query("DELETE FROM `hospital_hospital` WHERE `id`='$id'");
return $query;
}
}
?>
