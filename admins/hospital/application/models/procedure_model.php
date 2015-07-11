<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class procedure_model extends CI_Model
{
public function create($name,$description,$status)
{
$data=array("name" => $name,"description" => $description,"status" => $status);
$query=$this->db->insert( "hospital_procedure", $data );
$id=$this->db->insert_id();
if(!$query)
return  0;
else
return  $id;
}
public function beforeedit($id)
{
$this->db->where("id",$id);
$query=$this->db->get("hospital_procedure")->row();
return $query;
}
function getsingleprocedure($id){
$this->db->where("id",$id);
$query=$this->db->get("hospital_procedure")->row();
return $query;
}
public function edit($id,$name,$description,$status)
{
$data=array("name" => $name,"description" => $description,"status" => $status);
$this->db->where( "id", $id );
$query=$this->db->update( "hospital_procedure", $data );
return 1;
}
public function delete($id)
{
$query=$this->db->query("DELETE FROM `hospital_procedure` WHERE `id`='$id'");
return $query;
}
}
?>
