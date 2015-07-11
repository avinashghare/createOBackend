<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class department_model extends CI_Model
{
public function create($name,$description,$facility,$status)
{
$data=array("name" => $name,"description" => $description,"facility" => $facility,"status" => $status);
$query=$this->db->insert( "hospital_department", $data );
$id=$this->db->insert_id();
if(!$query)
return  0;
else
return  $id;
}
public function beforeedit($id)
{
$this->db->where("id",$id);
$query=$this->db->get("hospital_department")->row();
return $query;
}
function getsingledepartment($id){
$this->db->where("id",$id);
$query=$this->db->get("hospital_department")->row();
return $query;
}
public function edit($id,$name,$description,$facility,$status)
{
$data=array("name" => $name,"description" => $description,"facility" => $facility,"status" => $status);
$this->db->where( "id", $id );
$query=$this->db->update( "hospital_department", $data );
return 1;
}
public function delete($id)
{
$query=$this->db->query("DELETE FROM `hospital_department` WHERE `id`='$id'");
return $query;
}
}
?>
