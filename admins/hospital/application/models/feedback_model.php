<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class feedback_model extends CI_Model
{
public function create($user,$hospital,$doctor,$description)
{
$data=array("user" => $user,"hospital" => $hospital,"doctor" => $doctor,"description" => $description);
$query=$this->db->insert( "hospital_feedback", $data );
$id=$this->db->insert_id();
if(!$query)
return  0;
else
return  $id;
}
public function beforeedit($id)
{
$this->db->where("id",$id);
$query=$this->db->get("hospital_feedback")->row();
return $query;
}
function getsinglefeedback($id){
$this->db->where("id",$id);
$query=$this->db->get("hospital_feedback")->row();
return $query;
}
public function edit($id,$user,$hospital,$doctor,$description)
{
$data=array("user" => $user,"hospital" => $hospital,"doctor" => $doctor,"description" => $description);
$this->db->where( "id", $id );
$query=$this->db->update( "hospital_feedback", $data );
return 1;
}
public function delete($id)
{
$query=$this->db->query("DELETE FROM `hospital_feedback` WHERE `id`='$id'");
return $query;
}
}
?>
