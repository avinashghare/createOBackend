<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class userlog_model extends CI_Model
{
public function create($hospital,$deciese)
{
$data=array("hospital" => $hospital,"deciese" => $deciese);
$query=$this->db->insert( "hospital_userlog", $data );
$id=$this->db->insert_id();
if(!$query)
return  0;
else
return  $id;
}
public function beforeedit($id)
{
$this->db->where("id",$id);
$query=$this->db->get("hospital_userlog")->row();
return $query;
}
function getsingleuserlog($id){
$this->db->where("id",$id);
$query=$this->db->get("hospital_userlog")->row();
return $query;
}
public function edit($id,$hospital,$deciese)
{
$data=array("hospital" => $hospital,"deciese" => $deciese);
$this->db->where( "id", $id );
$query=$this->db->update( "hospital_userlog", $data );
return 1;
}
public function delete($id)
{
$query=$this->db->query("DELETE FROM `hospital_userlog` WHERE `id`='$id'");
return $query;
}
}
?>
