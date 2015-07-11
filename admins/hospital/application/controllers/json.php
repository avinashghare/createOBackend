<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");
class Json extends CI_Controller 
{function getallhospital()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`hospital_hospital`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`hospital_hospital`.`name`";
$elements[1]->sort="1";
$elements[1]->header="Name";
$elements[1]->alias="name";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`hospital_hospital`.`type`";
$elements[2]->sort="1";
$elements[2]->header="Type";
$elements[2]->alias="type";

$elements=array();
$elements[3]=new stdClass();
$elements[3]->field="`hospital_hospital`.`address`";
$elements[3]->sort="1";
$elements[3]->header="Address";
$elements[3]->alias="address";

$elements=array();
$elements[4]=new stdClass();
$elements[4]->field="`hospital_hospital`.`faxnumber`";
$elements[4]->sort="1";
$elements[4]->header="Fax Number";
$elements[4]->alias="faxnumber";

$elements=array();
$elements[5]=new stdClass();
$elements[5]->field="`hospital_hospital`.`landline1`";
$elements[5]->sort="1";
$elements[5]->header="Landline Number 1";
$elements[5]->alias="landline1";

$elements=array();
$elements[6]=new stdClass();
$elements[6]->field="`hospital_hospital`.`landline2`";
$elements[6]->sort="1";
$elements[6]->header="Landline Number 2";
$elements[6]->alias="landline2";

$elements=array();
$elements[7]=new stdClass();
$elements[7]->field="`hospital_hospital`.`emergencynumber1`";
$elements[7]->sort="1";
$elements[7]->header="Emergency Number 1";
$elements[7]->alias="emergencynumber1";

$elements=array();
$elements[8]=new stdClass();
$elements[8]->field="`hospital_hospital`.`emergencynumber2`";
$elements[8]->sort="1";
$elements[8]->header="Emergency Number 2";
$elements[8]->alias="emergencynumber2";

$elements=array();
$elements[9]=new stdClass();
$elements[9]->field="`hospital_hospital`.`ambulance`";
$elements[9]->sort="1";
$elements[9]->header="Ambulance Service";
$elements[9]->alias="ambulance";

$elements=array();
$elements[10]=new stdClass();
$elements[10]->field="`hospital_hospital`.`ambulancecontact1`";
$elements[10]->sort="1";
$elements[10]->header="Ambulance Contact 1";
$elements[10]->alias="ambulancecontact1";

$elements=array();
$elements[11]=new stdClass();
$elements[11]->field="`hospital_hospital`.`ambulancecontact2`";
$elements[11]->sort="1";
$elements[11]->header="Ambulance Contact 2";
$elements[11]->alias="ambulancecontact2";

$elements=array();
$elements[12]=new stdClass();
$elements[12]->field="`hospital_hospital`.`nearestpolicestation`";
$elements[12]->sort="1";
$elements[12]->header="Nearest Police Station";
$elements[12]->alias="nearestpolicestation";

$elements=array();
$elements[13]=new stdClass();
$elements[13]->field="`hospital_hospital`.`facility`";
$elements[13]->sort="1";
$elements[13]->header="Facility";
$elements[13]->alias="facility";

$elements=array();
$elements[14]=new stdClass();
$elements[14]->field="`hospital_hospital`.`facilitycharges`";
$elements[14]->sort="1";
$elements[14]->header="Facility Charges";
$elements[14]->alias="facilitycharges";

$elements=array();
$elements[15]=new stdClass();
$elements[15]->field="`hospital_hospital`.`typeofroom`";
$elements[15]->sort="1";
$elements[15]->header="Type Of Room";
$elements[15]->alias="typeofroom";

$elements=array();
$elements[16]=new stdClass();
$elements[16]->field="`hospital_hospital`.`roomchargeswithtax`";
$elements[16]->sort="1";
$elements[16]->header="Room Charges With Tax";
$elements[16]->alias="roomchargeswithtax";

$elements=array();
$elements[17]=new stdClass();
$elements[17]->field="`hospital_hospital`.`noofbed`";
$elements[17]->sort="1";
$elements[17]->header="Number Of Beds";
$elements[17]->alias="noofbed";

$elements=array();
$elements[18]=new stdClass();
$elements[18]->field="`hospital_hospital`.`availablestatus`";
$elements[18]->sort="1";
$elements[18]->header="Available Status";
$elements[18]->alias="availablestatus";

$elements=array();
$elements[19]=new stdClass();
$elements[19]->field="`hospital_hospital`.`diagnosticcenteravailable`";
$elements[19]->sort="1";
$elements[19]->header="Diagnostic Center Available";
$elements[19]->alias="diagnosticcenteravailable";

$elements=array();
$elements[20]=new stdClass();
$elements[20]->field="`hospital_hospital`.`department`";
$elements[20]->sort="1";
$elements[20]->header="Department";
$elements[20]->alias="department";

$elements=array();
$elements[21]=new stdClass();
$elements[21]->field="`hospital_hospital`.`condition`";
$elements[21]->sort="1";
$elements[21]->header="Condition";
$elements[21]->alias="condition";

$elements=array();
$elements[22]=new stdClass();
$elements[22]->field="`hospital_hospital`.`description`";
$elements[22]->sort="1";
$elements[22]->header="Description";
$elements[22]->alias="description";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `hospital_hospital`");
$this->load->view("json",$data);
}
public function getsinglehospital()
{
$id=$this->input->get_post("id");
$data["message"]=$this->hospital_model->getsinglehospital($id);
$this->load->view("json",$data);
}
function getalltype()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`hospital_type`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`hospital_type`.`name`";
$elements[1]->sort="1";
$elements[1]->header="Name";
$elements[1]->alias="name";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`hospital_type`.`status`";
$elements[2]->sort="1";
$elements[2]->header="Status";
$elements[2]->alias="status";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `hospital_type`");
$this->load->view("json",$data);
}
public function getsingletype()
{
$id=$this->input->get_post("id");
$data["message"]=$this->type_model->getsingletype($id);
$this->load->view("json",$data);
}
function getallfacility()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`hospital_facility`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`hospital_facility`.`name`";
$elements[1]->sort="1";
$elements[1]->header="Name";
$elements[1]->alias="name";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`hospital_facility`.`emergencynumber`";
$elements[2]->sort="1";
$elements[2]->header="Emergency Number";
$elements[2]->alias="emergencynumber";

$elements=array();
$elements[3]=new stdClass();
$elements[3]->field="`hospital_facility`.`ambulancecontact`";
$elements[3]->sort="1";
$elements[3]->header="Ambulance Contact";
$elements[3]->alias="ambulancecontact";

$elements=array();
$elements[4]=new stdClass();
$elements[4]->field="`hospital_facility`.`charges`";
$elements[4]->sort="1";
$elements[4]->header="Charges";
$elements[4]->alias="charges";

$elements=array();
$elements[5]=new stdClass();
$elements[5]->field="`hospital_facility`.`status`";
$elements[5]->sort="1";
$elements[5]->header="Status";
$elements[5]->alias="status";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `hospital_facility`");
$this->load->view("json",$data);
}
public function getsinglefacility()
{
$id=$this->input->get_post("id");
$data["message"]=$this->facility_model->getsinglefacility($id);
$this->load->view("json",$data);
}
function getallfacilitycharges()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`hospital_facilitycharges`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`hospital_facilitycharges`.`name`";
$elements[1]->sort="1";
$elements[1]->header="Name";
$elements[1]->alias="name";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`hospital_facilitycharges`.`status`";
$elements[2]->sort="1";
$elements[2]->header="Status";
$elements[2]->alias="status";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `hospital_facilitycharges`");
$this->load->view("json",$data);
}
public function getsinglefacilitycharges()
{
$id=$this->input->get_post("id");
$data["message"]=$this->facilitycharges_model->getsinglefacilitycharges($id);
$this->load->view("json",$data);
}
function getallroomtype()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`hospital_roomtype`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`hospital_roomtype`.`name`";
$elements[1]->sort="1";
$elements[1]->header="Name";
$elements[1]->alias="name";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`hospital_roomtype`.`status`";
$elements[2]->sort="1";
$elements[2]->header="Status";
$elements[2]->alias="status";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `hospital_roomtype`");
$this->load->view("json",$data);
}
public function getsingleroomtype()
{
$id=$this->input->get_post("id");
$data["message"]=$this->roomtype_model->getsingleroomtype($id);
$this->load->view("json",$data);
}
function getalldiagnosticcenter()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`hospital_diagnosticcenter`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`hospital_diagnosticcenter`.`name`";
$elements[1]->sort="1";
$elements[1]->header="Name";
$elements[1]->alias="name";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`hospital_diagnosticcenter`.`status`";
$elements[2]->sort="1";
$elements[2]->header="Status";
$elements[2]->alias="status";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `hospital_diagnosticcenter`");
$this->load->view("json",$data);
}
public function getsinglediagnosticcenter()
{
$id=$this->input->get_post("id");
$data["message"]=$this->diagnosticcenter_model->getsinglediagnosticcenter($id);
$this->load->view("json",$data);
}
function getalldepartment()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`hospital_department`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`hospital_department`.`name`";
$elements[1]->sort="1";
$elements[1]->header="Name";
$elements[1]->alias="name";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`hospital_department`.`description`";
$elements[2]->sort="1";
$elements[2]->header="Description";
$elements[2]->alias="description";

$elements=array();
$elements[3]=new stdClass();
$elements[3]->field="`hospital_department`.`facility`";
$elements[3]->sort="1";
$elements[3]->header="Facility";
$elements[3]->alias="facility";

$elements=array();
$elements[4]=new stdClass();
$elements[4]->field="`hospital_department`.`status`";
$elements[4]->sort="1";
$elements[4]->header="Status";
$elements[4]->alias="status";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `hospital_department`");
$this->load->view("json",$data);
}
public function getsingledepartment()
{
$id=$this->input->get_post("id");
$data["message"]=$this->department_model->getsingledepartment($id);
$this->load->view("json",$data);
}
function getallprocedure()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`hospital_procedure`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`hospital_procedure`.`name`";
$elements[1]->sort="1";
$elements[1]->header="Name";
$elements[1]->alias="name";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`hospital_procedure`.`description`";
$elements[2]->sort="1";
$elements[2]->header="Description";
$elements[2]->alias="description";

$elements=array();
$elements[3]=new stdClass();
$elements[3]->field="`hospital_procedure`.`status`";
$elements[3]->sort="1";
$elements[3]->header="Status";
$elements[3]->alias="status";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `hospital_procedure`");
$this->load->view("json",$data);
}
public function getsingleprocedure()
{
$id=$this->input->get_post("id");
$data["message"]=$this->procedure_model->getsingleprocedure($id);
$this->load->view("json",$data);
}
function getalloffer()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`hospital_offer`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`hospital_offer`.`title`";
$elements[1]->sort="1";
$elements[1]->header="Title";
$elements[1]->alias="title";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`hospital_offer`.`starttime`";
$elements[2]->sort="1";
$elements[2]->header="Start Time";
$elements[2]->alias="starttime";

$elements=array();
$elements[3]=new stdClass();
$elements[3]->field="`hospital_offer`.`endtime`";
$elements[3]->sort="1";
$elements[3]->header="End Time";
$elements[3]->alias="endtime";

$elements=array();
$elements[4]=new stdClass();
$elements[4]->field="`hospital_offer`.`status`";
$elements[4]->sort="1";
$elements[4]->header="Status";
$elements[4]->alias="status";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `hospital_offer`");
$this->load->view("json",$data);
}
public function getsingleoffer()
{
$id=$this->input->get_post("id");
$data["message"]=$this->offer_model->getsingleoffer($id);
$this->load->view("json",$data);
}
function getalluseraddress()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`hospital_useraddress`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`hospital_useraddress`.`name`";
$elements[1]->sort="1";
$elements[1]->header="Name";
$elements[1]->alias="name";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`hospital_useraddress`.`parent`";
$elements[2]->sort="1";
$elements[2]->header="Parent";
$elements[2]->alias="parent";

$elements=array();
$elements[3]=new stdClass();
$elements[3]->field="`hospital_useraddress`.`external`";
$elements[3]->sort="1";
$elements[3]->header="External";
$elements[3]->alias="external";

$elements=array();
$elements[4]=new stdClass();
$elements[4]->field="`hospital_useraddress`.`locationtype`";
$elements[4]->sort="1";
$elements[4]->header="Location Type";
$elements[4]->alias="locationtype";

$elements=array();
$elements[5]=new stdClass();
$elements[5]->field="`hospital_useraddress`.`pin`";
$elements[5]->sort="1";
$elements[5]->header="Pin";
$elements[5]->alias="pin";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `hospital_useraddress`");
$this->load->view("json",$data);
}
public function getsingleuseraddress()
{
$id=$this->input->get_post("id");
$data["message"]=$this->useraddress_model->getsingleuseraddress($id);
$this->load->view("json",$data);
}
function getallfeedback()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`hospital_feedback`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`hospital_feedback`.`user`";
$elements[1]->sort="1";
$elements[1]->header="User";
$elements[1]->alias="user";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`hospital_feedback`.`hospital`";
$elements[2]->sort="1";
$elements[2]->header="Hospital";
$elements[2]->alias="hospital";

$elements=array();
$elements[3]=new stdClass();
$elements[3]->field="`hospital_feedback`.`doctor`";
$elements[3]->sort="1";
$elements[3]->header="Doctor";
$elements[3]->alias="doctor";

$elements=array();
$elements[4]=new stdClass();
$elements[4]->field="`hospital_feedback`.`description`";
$elements[4]->sort="1";
$elements[4]->header="Description";
$elements[4]->alias="description";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `hospital_feedback`");
$this->load->view("json",$data);
}
public function getsinglefeedback()
{
$id=$this->input->get_post("id");
$data["message"]=$this->feedback_model->getsinglefeedback($id);
$this->load->view("json",$data);
}
function getallpatient()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`hospital_patient`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`hospital_patient`.`name`";
$elements[1]->sort="1";
$elements[1]->header="Name";
$elements[1]->alias="name";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`hospital_patient`.`contact`";
$elements[2]->sort="1";
$elements[2]->header="Contact";
$elements[2]->alias="contact";

$elements=array();
$elements[3]=new stdClass();
$elements[3]->field="`hospital_patient`.`lastselectedhospital`";
$elements[3]->sort="1";
$elements[3]->header="Last Selected Hospital";
$elements[3]->alias="lastselectedhospital";

$elements=array();
$elements[4]=new stdClass();
$elements[4]->field="`hospital_patient`.`lastreporteddeciese`";
$elements[4]->sort="1";
$elements[4]->header="Last Reported Deciese";
$elements[4]->alias="lastreporteddeciese";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `hospital_patient`");
$this->load->view("json",$data);
}
public function getsinglepatient()
{
$id=$this->input->get_post("id");
$data["message"]=$this->patient_model->getsinglepatient($id);
$this->load->view("json",$data);
}
function getalldoctor()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`hospital_doctor`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`hospital_doctor`.`name`";
$elements[1]->sort="1";
$elements[1]->header="Name";
$elements[1]->alias="name";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`hospital_doctor`.`degree`";
$elements[2]->sort="1";
$elements[2]->header="Degree";
$elements[2]->alias="degree";

$elements=array();
$elements[3]=new stdClass();
$elements[3]->field="`hospital_doctor`.`specialization`";
$elements[3]->sort="1";
$elements[3]->header="Specialization";
$elements[3]->alias="specialization";

$elements=array();
$elements[4]=new stdClass();
$elements[4]->field="`hospital_doctor`.`availabledays`";
$elements[4]->sort="1";
$elements[4]->header="Available Days";
$elements[4]->alias="availabledays";

$elements=array();
$elements[5]=new stdClass();
$elements[5]->field="`hospital_doctor`.`type`";
$elements[5]->sort="1";
$elements[5]->header="Type";
$elements[5]->alias="type";

$elements=array();
$elements[6]=new stdClass();
$elements[6]->field="`hospital_doctor`.`hospital`";
$elements[6]->sort="1";
$elements[6]->header="Hospital";
$elements[6]->alias="hospital";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `hospital_doctor`");
$this->load->view("json",$data);
}
public function getsingledoctor()
{
$id=$this->input->get_post("id");
$data["message"]=$this->doctor_model->getsingledoctor($id);
$this->load->view("json",$data);
}
function getallgallery()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`hospital_gallery`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`hospital_gallery`.`name`";
$elements[1]->sort="1";
$elements[1]->header="Name";
$elements[1]->alias="name";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`hospital_gallery`.`description`";
$elements[2]->sort="1";
$elements[2]->header="Description";
$elements[2]->alias="description";

$elements=array();
$elements[3]=new stdClass();
$elements[3]->field="`hospital_gallery`.`hospital`";
$elements[3]->sort="1";
$elements[3]->header="Hospital";
$elements[3]->alias="hospital";

$elements=array();
$elements[4]=new stdClass();
$elements[4]->field="`hospital_gallery`.`type`";
$elements[4]->sort="1";
$elements[4]->header="Type";
$elements[4]->alias="type";

$elements=array();
$elements[5]=new stdClass();
$elements[5]->field="`hospital_gallery`.`doctor`";
$elements[5]->sort="1";
$elements[5]->header="Doctor";
$elements[5]->alias="doctor";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `hospital_gallery`");
$this->load->view("json",$data);
}
public function getsinglegallery()
{
$id=$this->input->get_post("id");
$data["message"]=$this->gallery_model->getsinglegallery($id);
$this->load->view("json",$data);
}
function getallaggrement()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`hospital_aggrement`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`hospital_aggrement`.`hospital`";
$elements[1]->sort="1";
$elements[1]->header="Hospital";
$elements[1]->alias="hospital";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`hospital_aggrement`.`doctor`";
$elements[2]->sort="1";
$elements[2]->header="Doctor";
$elements[2]->alias="doctor";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `hospital_aggrement`");
$this->load->view("json",$data);
}
public function getsingleaggrement()
{
$id=$this->input->get_post("id");
$data["message"]=$this->aggrement_model->getsingleaggrement($id);
$this->load->view("json",$data);
}
function getalluserlog()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`hospital_userlog`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`hospital_userlog`.`hospital`";
$elements[1]->sort="1";
$elements[1]->header="Hospital";
$elements[1]->alias="hospital";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`hospital_userlog`.`deciese`";
$elements[2]->sort="1";
$elements[2]->header="Deciese";
$elements[2]->alias="deciese";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `hospital_userlog`");
$this->load->view("json",$data);
}
public function getsingleuserlog()
{
$id=$this->input->get_post("id");
$data["message"]=$this->userlog_model->getsingleuserlog($id);
$this->load->view("json",$data);
}
} ?>