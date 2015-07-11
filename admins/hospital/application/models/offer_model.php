<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class offer_model extends CI_Model
{
public function create($title,$starttime,$endtime,$status)
{
$data=array("title" => $title,"starttime" => $starttime,"endtime" => $endtime,"status" => $status);
$query=$this->db->insert( "hospital_offer", $data );
$id=$this->db->insert_id();
if(!$query)
return  0;
else
return  $id;
}
public function beforeedit($id)
{
$this->db->where("id",$id);
$query=$this->db->get("hospital_offer")->row();
return $query;
}
function getsingleoffer($id){
$this->db->where("id",$id);
$query=$this->db->get("hospital_offer")->row();
return $query;
}
public function edit($id,$title,$starttime,$endtime,$status)
{
$data=array("title" => $title,"starttime" => $starttime,"endtime" => $endtime,"status" => $status);
$this->db->where( "id", $id );
$query=$this->db->update( "hospital_offer", $data );
return 1;
}
public function delete($id)
{
$query=$this->db->query("DELETE FROM `hospital_offer` WHERE `id`='$id'");
return $query;
}
}
?>
