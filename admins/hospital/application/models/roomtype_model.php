<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class roomtype_model extends CI_Model
{
public function create($name,$status)
{
$data=array("name" => $name,"status" => $status);
$query=$this->db->insert( "hospital_roomtype", $data );
$id=$this->db->insert_id();
if(!$query)
return  0;
else
return  $id;
}
public function beforeedit($id)
{
$this->db->where("id",$id);
$query=$this->db->get("hospital_roomtype")->row();
return $query;
}
function getsingleroomtype($id){
$this->db->where("id",$id);
$query=$this->db->get("hospital_roomtype")->row();
return $query;
}
public function edit($id,$name,$status)
{
$data=array("name" => $name,"status" => $status);
$this->db->where( "id", $id );
$query=$this->db->update( "hospital_roomtype", $data );
return 1;
}
public function delete($id)
{
$query=$this->db->query("DELETE FROM `hospital_roomtype` WHERE `id`='$id'");
return $query;
}
}
?>
