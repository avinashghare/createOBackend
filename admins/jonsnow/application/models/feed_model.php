<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class feed_model extends CI_Model
{
public function create($title,$description)
{
$data=array("title" => $title,"description" => $description);
$query=$this->db->insert( "jonsnow_feed", $data );
$id=$this->db->insert_id();
if(!$query)
return  0;
else
return  $id;
}
public function beforeedit($id)
{
$this->db->where("id",$id);
$query=$this->db->get("jonsnow_feed")->row();
return $query;
}
function getsinglefeed($id){
$this->db->where("id",$id);
$query=$this->db->get("jonsnow_feed")->row();
return $query;
}
public function edit($id,$title,$description)
{
$data=array("title" => $title,"description" => $description);
$this->db->where( "id", $id );
$query=$this->db->update( "jonsnow_feed", $data );
return 1;
}
public function delete($id)
{
$query=$this->db->query("DELETE FROM `jonsnow_feed` WHERE `id`='$id'");
return $query;
}
}
?>
