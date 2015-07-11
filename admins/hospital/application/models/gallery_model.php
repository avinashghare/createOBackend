<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class gallery_model extends CI_Model
{
public function create($name,$description,$hospital,$type,$doctor)
{
$data=array("name" => $name,"description" => $description,"hospital" => $hospital,"type" => $type,"doctor" => $doctor);
$query=$this->db->insert( "hospital_gallery", $data );
$id=$this->db->insert_id();
if(!$query)
return  0;
else
return  $id;
}
public function beforeedit($id)
{
$this->db->where("id",$id);
$query=$this->db->get("hospital_gallery")->row();
return $query;
}
function getsinglegallery($id){
$this->db->where("id",$id);
$query=$this->db->get("hospital_gallery")->row();
return $query;
}
public function edit($id,$name,$description,$hospital,$type,$doctor)
{
$data=array("name" => $name,"description" => $description,"hospital" => $hospital,"type" => $type,"doctor" => $doctor);
$this->db->where( "id", $id );
$query=$this->db->update( "hospital_gallery", $data );
return 1;
}
public function delete($id)
{
$query=$this->db->query("DELETE FROM `hospital_gallery` WHERE `id`='$id'");
return $query;
}
}
?>
