<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class patient_model extends CI_Model
{
public function create($name,$contact,$lastselectedhospital,$lastreporteddeciese)
{
$data=array("name" => $name,"contact" => $contact,"lastselectedhospital" => $lastselectedhospital,"lastreporteddeciese" => $lastreporteddeciese);
$query=$this->db->insert( "hospital_patient", $data );
$id=$this->db->insert_id();
if(!$query)
return  0;
else
return  $id;
}
public function beforeedit($id)
{
$this->db->where("id",$id);
$query=$this->db->get("hospital_patient")->row();
return $query;
}
function getsinglepatient($id){
$this->db->where("id",$id);
$query=$this->db->get("hospital_patient")->row();
return $query;
}
public function edit($id,$name,$contact,$lastselectedhospital,$lastreporteddeciese)
{
$data=array("name" => $name,"contact" => $contact,"lastselectedhospital" => $lastselectedhospital,"lastreporteddeciese" => $lastreporteddeciese);
$this->db->where( "id", $id );
$query=$this->db->update( "hospital_patient", $data );
return 1;
}
public function delete($id)
{
$query=$this->db->query("DELETE FROM `hospital_patient` WHERE `id`='$id'");
return $query;
}
}
?>
