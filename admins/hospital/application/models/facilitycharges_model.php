<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class facilitycharges_model extends CI_Model
{
public function create($name,$status)
{
$data=array("name" => $name,"status" => $status);
$query=$this->db->insert( "hospital_facilitycharges", $data );
$id=$this->db->insert_id();
if(!$query)
return  0;
else
return  $id;
}
public function beforeedit($id)
{
$this->db->where("id",$id);
$query=$this->db->get("hospital_facilitycharges")->row();
return $query;
}
function getsinglefacilitycharges($id){
$this->db->where("id",$id);
$query=$this->db->get("hospital_facilitycharges")->row();
return $query;
}
public function edit($id,$name,$status)
{
$data=array("name" => $name,"status" => $status);
$this->db->where( "id", $id );
$query=$this->db->update( "hospital_facilitycharges", $data );
return 1;
}
public function delete($id)
{
$query=$this->db->query("DELETE FROM `hospital_facilitycharges` WHERE `id`='$id'");
return $query;
}
}
?>
