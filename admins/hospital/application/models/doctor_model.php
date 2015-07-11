<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class doctor_model extends CI_Model
{
public function create($name,$degree,$specialization,$availabledays,$type,$hospital)
{
$data=array("name" => $name,"degree" => $degree,"specialization" => $specialization,"availabledays" => $availabledays,"type" => $type,"hospital" => $hospital);
$query=$this->db->insert( "hospital_doctor", $data );
$id=$this->db->insert_id();
if(!$query)
return  0;
else
return  $id;
}
public function beforeedit($id)
{
$this->db->where("id",$id);
$query=$this->db->get("hospital_doctor")->row();
return $query;
}
function getsingledoctor($id){
$this->db->where("id",$id);
$query=$this->db->get("hospital_doctor")->row();
return $query;
}
public function edit($id,$name,$degree,$specialization,$availabledays,$type,$hospital)
{
$data=array("name" => $name,"degree" => $degree,"specialization" => $specialization,"availabledays" => $availabledays,"type" => $type,"hospital" => $hospital);
$this->db->where( "id", $id );
$query=$this->db->update( "hospital_doctor", $data );
return 1;
}
public function delete($id)
{
$query=$this->db->query("DELETE FROM `hospital_doctor` WHERE `id`='$id'");
return $query;
}
}
?>
