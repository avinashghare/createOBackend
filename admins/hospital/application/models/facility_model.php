<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class facility_model extends CI_Model
{
public function create($name,$emergencynumber,$ambulancecontact,$charges,$status)
{
$data=array("name" => $name,"emergencynumber" => $emergencynumber,"ambulancecontact" => $ambulancecontact,"charges" => $charges,"status" => $status);
$query=$this->db->insert( "hospital_facility", $data );
$id=$this->db->insert_id();
if(!$query)
return  0;
else
return  $id;
}
public function beforeedit($id)
{
$this->db->where("id",$id);
$query=$this->db->get("hospital_facility")->row();
return $query;
}
function getsinglefacility($id){
$this->db->where("id",$id);
$query=$this->db->get("hospital_facility")->row();
return $query;
}
public function edit($id,$name,$emergencynumber,$ambulancecontact,$charges,$status)
{
$data=array("name" => $name,"emergencynumber" => $emergencynumber,"ambulancecontact" => $ambulancecontact,"charges" => $charges,"status" => $status);
$this->db->where( "id", $id );
$query=$this->db->update( "hospital_facility", $data );
return 1;
}
public function delete($id)
{
$query=$this->db->query("DELETE FROM `hospital_facility` WHERE `id`='$id'");
return $query;
}
}
?>
