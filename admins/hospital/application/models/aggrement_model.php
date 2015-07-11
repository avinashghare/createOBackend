<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class aggrement_model extends CI_Model
{
public function create($hospital,$doctor)
{
$data=array("hospital" => $hospital,"doctor" => $doctor);
$query=$this->db->insert( "hospital_aggrement", $data );
$id=$this->db->insert_id();
if(!$query)
return  0;
else
return  $id;
}
public function beforeedit($id)
{
$this->db->where("id",$id);
$query=$this->db->get("hospital_aggrement")->row();
return $query;
}
function getsingleaggrement($id){
$this->db->where("id",$id);
$query=$this->db->get("hospital_aggrement")->row();
return $query;
}
public function edit($id,$hospital,$doctor)
{
$data=array("hospital" => $hospital,"doctor" => $doctor);
$this->db->where( "id", $id );
$query=$this->db->update( "hospital_aggrement", $data );
return 1;
}
public function delete($id)
{
$query=$this->db->query("DELETE FROM `hospital_aggrement` WHERE `id`='$id'");
return $query;
}
}
?>
