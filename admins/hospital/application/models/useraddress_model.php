<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class useraddress_model extends CI_Model
{
public function create($name,$parent,$external,$locationtype,$pin)
{
$data=array("name" => $name,"parent" => $parent,"external" => $external,"locationtype" => $locationtype,"pin" => $pin);
$query=$this->db->insert( "hospital_useraddress", $data );
$id=$this->db->insert_id();
if(!$query)
return  0;
else
return  $id;
}
public function beforeedit($id)
{
$this->db->where("id",$id);
$query=$this->db->get("hospital_useraddress")->row();
return $query;
}
function getsingleuseraddress($id){
$this->db->where("id",$id);
$query=$this->db->get("hospital_useraddress")->row();
return $query;
}
public function edit($id,$name,$parent,$external,$locationtype,$pin)
{
$data=array("name" => $name,"parent" => $parent,"external" => $external,"locationtype" => $locationtype,"pin" => $pin);
$this->db->where( "id", $id );
$query=$this->db->update( "hospital_useraddress", $data );
return 1;
}
public function delete($id)
{
$query=$this->db->query("DELETE FROM `hospital_useraddress` WHERE `id`='$id'");
return $query;
}
}
?>
