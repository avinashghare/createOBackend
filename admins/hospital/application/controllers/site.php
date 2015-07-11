<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Site extends CI_Controller 
{
	public function __construct( )
	{
		parent::__construct();
		
		$this->is_logged_in();
	}
	function is_logged_in( )
	{
		$is_logged_in = $this->session->userdata( 'logged_in' );
		if ( $is_logged_in !== 'true' || !isset( $is_logged_in ) ) {
			redirect( base_url() . 'index.php/login', 'refresh' );
		} //$is_logged_in !== 'true' || !isset( $is_logged_in )
	}
	function checkaccess($access)
	{
		$accesslevel=$this->session->userdata('accesslevel');
		if(!in_array($accesslevel,$access))
			redirect( base_url() . 'index.php/site?alerterror=You do not have access to this page. ', 'refresh' );
	}
	public function index()
	{
		$access = array("1","2");
		$this->checkaccess($access);
		$data[ 'page' ] = 'dashboard';
		$data[ 'title' ] = 'Welcome';
		$this->load->view( 'template', $data );	
	}
	public function createuser()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['accesslevel']=$this->user_model->getaccesslevels();
		$data[ 'status' ] =$this->user_model->getstatusdropdown();
		$data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
//        $data['category']=$this->category_model->getcategorydropdown();
		$data[ 'page' ] = 'createuser';
		$data[ 'title' ] = 'Create User';
		$this->load->view( 'template', $data );	
	}
	function createusersubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required|max_length[30]');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email|is_unique[user.email]');
		$this->form_validation->set_rules('password','Password','trim|required|min_length[6]|max_length[30]');
		$this->form_validation->set_rules('confirmpassword','Confirm Password','trim|required|matches[password]');
		$this->form_validation->set_rules('accessslevel','Accessslevel','trim');
		$this->form_validation->set_rules('status','status','trim|');
		$this->form_validation->set_rules('socialid','Socialid','trim');
		$this->form_validation->set_rules('logintype','logintype','trim');
		$this->form_validation->set_rules('json','json','trim');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['accesslevel']=$this->user_model->getaccesslevels();
            $data[ 'status' ] =$this->user_model->getstatusdropdown();
            $data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
            $data['category']=$this->category_model->getcategorydropdown();
            $data[ 'page' ] = 'createuser';
            $data[ 'title' ] = 'Create User';
            $this->load->view( 'template', $data );	
		}
		else
		{
            $name=$this->input->post('name');
            $email=$this->input->post('email');
            $password=$this->input->post('password');
            $accesslevel=$this->input->post('accesslevel');
            $status=$this->input->post('status');
            $socialid=$this->input->post('socialid');
            $logintype=$this->input->post('logintype');
            $json=$this->input->post('json');
//            $category=$this->input->post('category');
            
            $config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$image="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];
                
                $config_r['source_image']   = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE;///add this
                $config_r['width']   = 800;
                $config_r['height'] = 800;
                $config_r['quality']    = 100;
                //end of configs

                $this->load->library('image_lib', $config_r); 
                $this->image_lib->initialize($config_r);
                if(!$this->image_lib->resize())
                {
                    echo "Failed." . $this->image_lib->display_errors();
                    //return false;
                }  
                else
                {
                    //print_r($this->image_lib->dest_image);
                    //dest_image
                    $image=$this->image_lib->dest_image;
                    //return false;
                }
                
			}
            
			if($this->user_model->create($name,$email,$password,$accesslevel,$status,$socialid,$logintype,$image,$json)==0)
			$data['alerterror']="New user could not be created.";
			else
			$data['alertsuccess']="User created Successfully.";
			$data['redirect']="site/viewusers";
			$this->load->view("redirect",$data);
		}
	}
    function viewusers()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='viewusers';
        $data['base_url'] = site_url("site/viewusersjson");
        
		$data['title']='View Users';
		$this->load->view('template',$data);
	} 
    function viewusersjson()
	{
		$access = array("1");
		$this->checkaccess($access);
        
        
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`user`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        
        $elements[1]=new stdClass();
        $elements[1]->field="`user`.`name`";
        $elements[1]->sort="1";
        $elements[1]->header="Name";
        $elements[1]->alias="name";
        
        $elements[2]=new stdClass();
        $elements[2]->field="`user`.`email`";
        $elements[2]->sort="1";
        $elements[2]->header="Email";
        $elements[2]->alias="email";
        
        $elements[3]=new stdClass();
        $elements[3]->field="`user`.`socialid`";
        $elements[3]->sort="1";
        $elements[3]->header="SocialId";
        $elements[3]->alias="socialid";
        
        $elements[4]=new stdClass();
        $elements[4]->field="`logintype`.`name`";
        $elements[4]->sort="1";
        $elements[4]->header="Logintype";
        $elements[4]->alias="logintype";
        
        $elements[5]=new stdClass();
        $elements[5]->field="`user`.`json`";
        $elements[5]->sort="1";
        $elements[5]->header="Json";
        $elements[5]->alias="json";
       
        $elements[6]=new stdClass();
        $elements[6]->field="`accesslevel`.`name`";
        $elements[6]->sort="1";
        $elements[6]->header="Accesslevel";
        $elements[6]->alias="accesslevelname";
       
        $elements[7]=new stdClass();
        $elements[7]->field="`statuses`.`name`";
        $elements[7]->sort="1";
        $elements[7]->header="Status";
        $elements[7]->alias="status";
       
        
        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
            $maxrow=20;
        }
        
        if($orderby=="")
        {
            $orderby="id";
            $orderorder="ASC";
        }
       
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `user` LEFT OUTER JOIN `logintype` ON `logintype`.`id`=`user`.`logintype` LEFT OUTER JOIN `accesslevel` ON `accesslevel`.`id`=`user`.`accesslevel` LEFT OUTER JOIN `statuses` ON `statuses`.`id`=`user`.`status`");
        
		$this->load->view("json",$data);
	} 
    
    
	function edituser()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'status' ] =$this->user_model->getstatusdropdown();
		$data['accesslevel']=$this->user_model->getaccesslevels();
		$data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
		$data['before']=$this->user_model->beforeedit($this->input->get('id'));
		$data['page']='edituser';
		$data['page2']='block/userblock';
		$data['title']='Edit User';
		$this->load->view('template',$data);
	}
	function editusersubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		
		$this->form_validation->set_rules('name','Name','trim|required|max_length[30]');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email');
		$this->form_validation->set_rules('password','Password','trim|min_length[6]|max_length[30]');
		$this->form_validation->set_rules('confirmpassword','Confirm Password','trim|matches[password]');
		$this->form_validation->set_rules('accessslevel','Accessslevel','trim');
		$this->form_validation->set_rules('status','status','trim|');
		$this->form_validation->set_rules('socialid','Socialid','trim');
		$this->form_validation->set_rules('logintype','logintype','trim');
		$this->form_validation->set_rules('json','json','trim');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data[ 'status' ] =$this->user_model->getstatusdropdown();
			$data['accesslevel']=$this->user_model->getaccesslevels();
            $data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
			$data['before']=$this->user_model->beforeedit($this->input->post('id'));
			$data['page']='edituser';
//			$data['page2']='block/userblock';
			$data['title']='Edit User';
			$this->load->view('template',$data);
		}
		else
		{
            
            $id=$this->input->get_post('id');
            $name=$this->input->get_post('name');
            $email=$this->input->get_post('email');
            $password=$this->input->get_post('password');
            $accesslevel=$this->input->get_post('accesslevel');
            $status=$this->input->get_post('status');
            $socialid=$this->input->get_post('socialid');
            $logintype=$this->input->get_post('logintype');
            $json=$this->input->get_post('json');
//            $category=$this->input->get_post('category');
            
            $config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$image="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];
                
                $config_r['source_image']   = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE;///add this
                $config_r['width']   = 800;
                $config_r['height'] = 800;
                $config_r['quality']    = 100;
                //end of configs

                $this->load->library('image_lib', $config_r); 
                $this->image_lib->initialize($config_r);
                if(!$this->image_lib->resize())
                {
                    echo "Failed." . $this->image_lib->display_errors();
                    //return false;
                }  
                else
                {
                    //print_r($this->image_lib->dest_image);
                    //dest_image
                    $image=$this->image_lib->dest_image;
                    //return false;
                }
                
			}
            
            if($image=="")
            {
            $image=$this->user_model->getuserimagebyid($id);
               // print_r($image);
                $image=$image->image;
            }
            
			if($this->user_model->edit($id,$name,$email,$password,$accesslevel,$status,$socialid,$logintype,$image,$json)==0)
			$data['alerterror']="User Editing was unsuccesful";
			else
			$data['alertsuccess']="User edited Successfully.";
			
			$data['redirect']="site/viewusers";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
	
	function deleteuser()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->user_model->deleteuser($this->input->get('id'));
//		$data['table']=$this->user_model->viewusers();
		$data['alertsuccess']="User Deleted Successfully";
		$data['redirect']="site/viewusers";
			//$data['other']="template=$template";
		$this->load->view("redirect",$data);
	}
	function changeuserstatus()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->user_model->changestatus($this->input->get('id'));
		$data['table']=$this->user_model->viewusers();
		$data['alertsuccess']="Status Changed Successfully";
		$data['redirect']="site/viewusers";
        $data['other']="template=$template";
        $this->load->view("redirect",$data);
	}
    
    
    

public function viewhospital()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewhospital";
$data["base_url"]=site_url("site/viewhospitaljson");
$data["title"]="View hospital";
$this->load->view("template",$data);
}
function viewhospitaljson()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`hospital_hospital`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`hospital_hospital`.`name`";
$elements[1]->sort="1";
$elements[1]->header="Name";
$elements[1]->alias="name";
$elements[2]=new stdClass();
$elements[2]->field="`hospital_hospital`.`type`";
$elements[2]->sort="1";
$elements[2]->header="Type";
$elements[2]->alias="type";
$elements[3]=new stdClass();
$elements[3]->field="`hospital_hospital`.`address`";
$elements[3]->sort="1";
$elements[3]->header="Address";
$elements[3]->alias="address";
$elements[4]=new stdClass();
$elements[4]->field="`hospital_hospital`.`faxnumber`";
$elements[4]->sort="1";
$elements[4]->header="Fax Number";
$elements[4]->alias="faxnumber";
$elements[5]=new stdClass();
$elements[5]->field="`hospital_hospital`.`landline1`";
$elements[5]->sort="1";
$elements[5]->header="Landline Number 1";
$elements[5]->alias="landline1";
$elements[6]=new stdClass();
$elements[6]->field="`hospital_hospital`.`landline2`";
$elements[6]->sort="1";
$elements[6]->header="Landline Number 2";
$elements[6]->alias="landline2";
$elements[7]=new stdClass();
$elements[7]->field="`hospital_hospital`.`emergencynumber1`";
$elements[7]->sort="1";
$elements[7]->header="Emergency Number 1";
$elements[7]->alias="emergencynumber1";
$elements[8]=new stdClass();
$elements[8]->field="`hospital_hospital`.`emergencynumber2`";
$elements[8]->sort="1";
$elements[8]->header="Emergency Number 2";
$elements[8]->alias="emergencynumber2";
$elements[9]=new stdClass();
$elements[9]->field="`hospital_hospital`.`ambulance`";
$elements[9]->sort="1";
$elements[9]->header="Ambulance Service";
$elements[9]->alias="ambulance";
$elements[10]=new stdClass();
$elements[10]->field="`hospital_hospital`.`ambulancecontact1`";
$elements[10]->sort="1";
$elements[10]->header="Ambulance Contact 1";
$elements[10]->alias="ambulancecontact1";
$elements[11]=new stdClass();
$elements[11]->field="`hospital_hospital`.`ambulancecontact2`";
$elements[11]->sort="1";
$elements[11]->header="Ambulance Contact 2";
$elements[11]->alias="ambulancecontact2";
$elements[12]=new stdClass();
$elements[12]->field="`hospital_hospital`.`nearestpolicestation`";
$elements[12]->sort="1";
$elements[12]->header="Nearest Police Station";
$elements[12]->alias="nearestpolicestation";
$elements[13]=new stdClass();
$elements[13]->field="`hospital_hospital`.`facility`";
$elements[13]->sort="1";
$elements[13]->header="Facility";
$elements[13]->alias="facility";
$elements[14]=new stdClass();
$elements[14]->field="`hospital_hospital`.`facilitycharges`";
$elements[14]->sort="1";
$elements[14]->header="Facility Charges";
$elements[14]->alias="facilitycharges";
$elements[15]=new stdClass();
$elements[15]->field="`hospital_hospital`.`typeofroom`";
$elements[15]->sort="1";
$elements[15]->header="Type Of Room";
$elements[15]->alias="typeofroom";
$elements[16]=new stdClass();
$elements[16]->field="`hospital_hospital`.`roomchargeswithtax`";
$elements[16]->sort="1";
$elements[16]->header="Room Charges With Tax";
$elements[16]->alias="roomchargeswithtax";
$elements[17]=new stdClass();
$elements[17]->field="`hospital_hospital`.`noofbed`";
$elements[17]->sort="1";
$elements[17]->header="Number Of Beds";
$elements[17]->alias="noofbed";
$elements[18]=new stdClass();
$elements[18]->field="`hospital_hospital`.`availablestatus`";
$elements[18]->sort="1";
$elements[18]->header="Available Status";
$elements[18]->alias="availablestatus";
$elements[19]=new stdClass();
$elements[19]->field="`hospital_hospital`.`diagnosticcenteravailable`";
$elements[19]->sort="1";
$elements[19]->header="Diagnostic Center Available";
$elements[19]->alias="diagnosticcenteravailable";
$elements[20]=new stdClass();
$elements[20]->field="`hospital_hospital`.`department`";
$elements[20]->sort="1";
$elements[20]->header="Department";
$elements[20]->alias="department";
$elements[21]=new stdClass();
$elements[21]->field="`hospital_hospital`.`condition`";
$elements[21]->sort="1";
$elements[21]->header="Condition";
$elements[21]->alias="condition";
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
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `hospital_hospital`");
$this->load->view("json",$data);
}

public function createhospital()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="createhospital";
$data["title"]="Create hospital";
$this->load->view("template",$data);
}
public function createhospitalsubmit() 
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("name","Name","trim");
$this->form_validation->set_rules("type","Type","trim");
$this->form_validation->set_rules("address","Address","trim");
$this->form_validation->set_rules("faxnumber","Fax Number","trim");
$this->form_validation->set_rules("landline1","Landline Number 1","trim");
$this->form_validation->set_rules("landline2","Landline Number 2","trim");
$this->form_validation->set_rules("emergencynumber1","Emergency Number 1","trim");
$this->form_validation->set_rules("emergencynumber2","Emergency Number 2","trim");
$this->form_validation->set_rules("ambulance","Ambulance Service","trim");
$this->form_validation->set_rules("ambulancecontact1","Ambulance Contact 1","trim");
$this->form_validation->set_rules("ambulancecontact2","Ambulance Contact 2","trim");
$this->form_validation->set_rules("nearestpolicestation","Nearest Police Station","trim");
$this->form_validation->set_rules("facility","Facility","trim");
$this->form_validation->set_rules("facilitycharges","Facility Charges","trim");
$this->form_validation->set_rules("typeofroom","Type Of Room","trim");
$this->form_validation->set_rules("roomchargeswithtax","Room Charges With Tax","trim");
$this->form_validation->set_rules("noofbed","Number Of Beds","trim");
$this->form_validation->set_rules("availablestatus","Available Status","trim");
$this->form_validation->set_rules("diagnosticcenteravailable","Diagnostic Center Available","trim");
$this->form_validation->set_rules("department","Department","trim");
$this->form_validation->set_rules("condition","Condition","trim");
$this->form_validation->set_rules("description","Description","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="createhospital";
$data["title"]="Create hospital";
$this->load->view("template",$data);
}
else
{
$name=$this->input->get_post("name");
$type=$this->input->get_post("type");
$address=$this->input->get_post("address");
$faxnumber=$this->input->get_post("faxnumber");
$landline1=$this->input->get_post("landline1");
$landline2=$this->input->get_post("landline2");
$emergencynumber1=$this->input->get_post("emergencynumber1");
$emergencynumber2=$this->input->get_post("emergencynumber2");
$ambulance=$this->input->get_post("ambulance");
$ambulancecontact1=$this->input->get_post("ambulancecontact1");
$ambulancecontact2=$this->input->get_post("ambulancecontact2");
$nearestpolicestation=$this->input->get_post("nearestpolicestation");
$facility=$this->input->get_post("facility");
$facilitycharges=$this->input->get_post("facilitycharges");
$typeofroom=$this->input->get_post("typeofroom");
$roomchargeswithtax=$this->input->get_post("roomchargeswithtax");
$noofbed=$this->input->get_post("noofbed");
$availablestatus=$this->input->get_post("availablestatus");
$diagnosticcenteravailable=$this->input->get_post("diagnosticcenteravailable");
$department=$this->input->get_post("department");
$condition=$this->input->get_post("condition");
$description=$this->input->get_post("description");
if($this->hospital_model->create($name,$type,$address,$faxnumber,$landline1,$landline2,$emergencynumber1,$emergencynumber2,$ambulance,$ambulancecontact1,$ambulancecontact2,$nearestpolicestation,$facility,$facilitycharges,$typeofroom,$roomchargeswithtax,$noofbed,$availablestatus,$diagnosticcenteravailable,$department,$condition,$description)==0)
$data["alerterror"]="New hospital could not be created.";
else
$data["alertsuccess"]="hospital created Successfully.";
$data["redirect"]="site/viewhospital";
$this->load->view("redirect",$data);
}
}
public function edithospital()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="edithospital";
$data["title"]="Edit hospital";
$data["before"]=$this->hospital_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function edithospitalsubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","ID","trim");
$this->form_validation->set_rules("name","Name","trim");
$this->form_validation->set_rules("type","Type","trim");
$this->form_validation->set_rules("address","Address","trim");
$this->form_validation->set_rules("faxnumber","Fax Number","trim");
$this->form_validation->set_rules("landline1","Landline Number 1","trim");
$this->form_validation->set_rules("landline2","Landline Number 2","trim");
$this->form_validation->set_rules("emergencynumber1","Emergency Number 1","trim");
$this->form_validation->set_rules("emergencynumber2","Emergency Number 2","trim");
$this->form_validation->set_rules("ambulance","Ambulance Service","trim");
$this->form_validation->set_rules("ambulancecontact1","Ambulance Contact 1","trim");
$this->form_validation->set_rules("ambulancecontact2","Ambulance Contact 2","trim");
$this->form_validation->set_rules("nearestpolicestation","Nearest Police Station","trim");
$this->form_validation->set_rules("facility","Facility","trim");
$this->form_validation->set_rules("facilitycharges","Facility Charges","trim");
$this->form_validation->set_rules("typeofroom","Type Of Room","trim");
$this->form_validation->set_rules("roomchargeswithtax","Room Charges With Tax","trim");
$this->form_validation->set_rules("noofbed","Number Of Beds","trim");
$this->form_validation->set_rules("availablestatus","Available Status","trim");
$this->form_validation->set_rules("diagnosticcenteravailable","Diagnostic Center Available","trim");
$this->form_validation->set_rules("department","Department","trim");
$this->form_validation->set_rules("condition","Condition","trim");
$this->form_validation->set_rules("description","Description","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="edithospital";
$data["title"]="Edit hospital";
$data["before"]=$this->hospital_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$name=$this->input->get_post("name");
$type=$this->input->get_post("type");
$address=$this->input->get_post("address");
$faxnumber=$this->input->get_post("faxnumber");
$landline1=$this->input->get_post("landline1");
$landline2=$this->input->get_post("landline2");
$emergencynumber1=$this->input->get_post("emergencynumber1");
$emergencynumber2=$this->input->get_post("emergencynumber2");
$ambulance=$this->input->get_post("ambulance");
$ambulancecontact1=$this->input->get_post("ambulancecontact1");
$ambulancecontact2=$this->input->get_post("ambulancecontact2");
$nearestpolicestation=$this->input->get_post("nearestpolicestation");
$facility=$this->input->get_post("facility");
$facilitycharges=$this->input->get_post("facilitycharges");
$typeofroom=$this->input->get_post("typeofroom");
$roomchargeswithtax=$this->input->get_post("roomchargeswithtax");
$noofbed=$this->input->get_post("noofbed");
$availablestatus=$this->input->get_post("availablestatus");
$diagnosticcenteravailable=$this->input->get_post("diagnosticcenteravailable");
$department=$this->input->get_post("department");
$condition=$this->input->get_post("condition");
$description=$this->input->get_post("description");
if($this->hospital_model->edit($id,$name,$type,$address,$faxnumber,$landline1,$landline2,$emergencynumber1,$emergencynumber2,$ambulance,$ambulancecontact1,$ambulancecontact2,$nearestpolicestation,$facility,$facilitycharges,$typeofroom,$roomchargeswithtax,$noofbed,$availablestatus,$diagnosticcenteravailable,$department,$condition,$description)==0)
$data["alerterror"]="New hospital could not be Updated.";
else
$data["alertsuccess"]="hospital Updated Successfully.";
$data["redirect"]="site/viewhospital";
$this->load->view("redirect",$data);
}
}
public function deletehospital()
{
$access=array("1");
$this->checkaccess($access);
$this->hospital_model->delete($this->input->get("id"));
$data["redirect"]="site/viewhospital";
$this->load->view("redirect",$data);
}
public function viewtype()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewtype";
$data["base_url"]=site_url("site/viewtypejson");
$data["title"]="View type";
$this->load->view("template",$data);
}
function viewtypejson()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`hospital_type`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`hospital_type`.`name`";
$elements[1]->sort="1";
$elements[1]->header="Name";
$elements[1]->alias="name";
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
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `hospital_type`");
$this->load->view("json",$data);
}

public function createtype()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="createtype";
$data["title"]="Create type";
$this->load->view("template",$data);
}
public function createtypesubmit() 
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("name","Name","trim");
$this->form_validation->set_rules("status","Status","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="createtype";
$data["title"]="Create type";
$this->load->view("template",$data);
}
else
{
$name=$this->input->get_post("name");
$status=$this->input->get_post("status");
if($this->type_model->create($name,$status)==0)
$data["alerterror"]="New type could not be created.";
else
$data["alertsuccess"]="type created Successfully.";
$data["redirect"]="site/viewtype";
$this->load->view("redirect",$data);
}
}
public function edittype()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="edittype";
$data["title"]="Edit type";
$data["before"]=$this->type_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function edittypesubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","ID","trim");
$this->form_validation->set_rules("name","Name","trim");
$this->form_validation->set_rules("status","Status","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="edittype";
$data["title"]="Edit type";
$data["before"]=$this->type_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$name=$this->input->get_post("name");
$status=$this->input->get_post("status");
if($this->type_model->edit($id,$name,$status)==0)
$data["alerterror"]="New type could not be Updated.";
else
$data["alertsuccess"]="type Updated Successfully.";
$data["redirect"]="site/viewtype";
$this->load->view("redirect",$data);
}
}
public function deletetype()
{
$access=array("1");
$this->checkaccess($access);
$this->type_model->delete($this->input->get("id"));
$data["redirect"]="site/viewtype";
$this->load->view("redirect",$data);
}
public function viewfacility()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewfacility";
$data["base_url"]=site_url("site/viewfacilityjson");
$data["title"]="View facility";
$this->load->view("template",$data);
}
function viewfacilityjson()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`hospital_facility`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`hospital_facility`.`name`";
$elements[1]->sort="1";
$elements[1]->header="Name";
$elements[1]->alias="name";
$elements[2]=new stdClass();
$elements[2]->field="`hospital_facility`.`emergencynumber`";
$elements[2]->sort="1";
$elements[2]->header="Emergency Number";
$elements[2]->alias="emergencynumber";
$elements[3]=new stdClass();
$elements[3]->field="`hospital_facility`.`ambulancecontact`";
$elements[3]->sort="1";
$elements[3]->header="Ambulance Contact";
$elements[3]->alias="ambulancecontact";
$elements[4]=new stdClass();
$elements[4]->field="`hospital_facility`.`charges`";
$elements[4]->sort="1";
$elements[4]->header="Charges";
$elements[4]->alias="charges";
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
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `hospital_facility`");
$this->load->view("json",$data);
}

public function createfacility()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="createfacility";
$data["title"]="Create facility";
$this->load->view("template",$data);
}
public function createfacilitysubmit() 
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("name","Name","trim");
$this->form_validation->set_rules("emergencynumber","Emergency Number","trim");
$this->form_validation->set_rules("ambulancecontact","Ambulance Contact","trim");
$this->form_validation->set_rules("charges","Charges","trim");
$this->form_validation->set_rules("status","Status","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="createfacility";
$data["title"]="Create facility";
$this->load->view("template",$data);
}
else
{
$name=$this->input->get_post("name");
$emergencynumber=$this->input->get_post("emergencynumber");
$ambulancecontact=$this->input->get_post("ambulancecontact");
$charges=$this->input->get_post("charges");
$status=$this->input->get_post("status");
if($this->facility_model->create($name,$emergencynumber,$ambulancecontact,$charges,$status)==0)
$data["alerterror"]="New facility could not be created.";
else
$data["alertsuccess"]="facility created Successfully.";
$data["redirect"]="site/viewfacility";
$this->load->view("redirect",$data);
}
}
public function editfacility()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="editfacility";
$data["title"]="Edit facility";
$data["before"]=$this->facility_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function editfacilitysubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","ID","trim");
$this->form_validation->set_rules("name","Name","trim");
$this->form_validation->set_rules("emergencynumber","Emergency Number","trim");
$this->form_validation->set_rules("ambulancecontact","Ambulance Contact","trim");
$this->form_validation->set_rules("charges","Charges","trim");
$this->form_validation->set_rules("status","Status","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="editfacility";
$data["title"]="Edit facility";
$data["before"]=$this->facility_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$name=$this->input->get_post("name");
$emergencynumber=$this->input->get_post("emergencynumber");
$ambulancecontact=$this->input->get_post("ambulancecontact");
$charges=$this->input->get_post("charges");
$status=$this->input->get_post("status");
if($this->facility_model->edit($id,$name,$emergencynumber,$ambulancecontact,$charges,$status)==0)
$data["alerterror"]="New facility could not be Updated.";
else
$data["alertsuccess"]="facility Updated Successfully.";
$data["redirect"]="site/viewfacility";
$this->load->view("redirect",$data);
}
}
public function deletefacility()
{
$access=array("1");
$this->checkaccess($access);
$this->facility_model->delete($this->input->get("id"));
$data["redirect"]="site/viewfacility";
$this->load->view("redirect",$data);
}
public function viewfacilitycharges()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewfacilitycharges";
$data["base_url"]=site_url("site/viewfacilitychargesjson");
$data["title"]="View facilitycharges";
$this->load->view("template",$data);
}
function viewfacilitychargesjson()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`hospital_facilitycharges`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`hospital_facilitycharges`.`name`";
$elements[1]->sort="1";
$elements[1]->header="Name";
$elements[1]->alias="name";
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
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `hospital_facilitycharges`");
$this->load->view("json",$data);
}

public function createfacilitycharges()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="createfacilitycharges";
$data["title"]="Create facilitycharges";
$this->load->view("template",$data);
}
public function createfacilitychargessubmit() 
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("name","Name","trim");
$this->form_validation->set_rules("status","Status","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="createfacilitycharges";
$data["title"]="Create facilitycharges";
$this->load->view("template",$data);
}
else
{
$name=$this->input->get_post("name");
$status=$this->input->get_post("status");
if($this->facilitycharges_model->create($name,$status)==0)
$data["alerterror"]="New facilitycharges could not be created.";
else
$data["alertsuccess"]="facilitycharges created Successfully.";
$data["redirect"]="site/viewfacilitycharges";
$this->load->view("redirect",$data);
}
}
public function editfacilitycharges()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="editfacilitycharges";
$data["title"]="Edit facilitycharges";
$data["before"]=$this->facilitycharges_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function editfacilitychargessubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","ID","trim");
$this->form_validation->set_rules("name","Name","trim");
$this->form_validation->set_rules("status","Status","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="editfacilitycharges";
$data["title"]="Edit facilitycharges";
$data["before"]=$this->facilitycharges_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$name=$this->input->get_post("name");
$status=$this->input->get_post("status");
if($this->facilitycharges_model->edit($id,$name,$status)==0)
$data["alerterror"]="New facilitycharges could not be Updated.";
else
$data["alertsuccess"]="facilitycharges Updated Successfully.";
$data["redirect"]="site/viewfacilitycharges";
$this->load->view("redirect",$data);
}
}
public function deletefacilitycharges()
{
$access=array("1");
$this->checkaccess($access);
$this->facilitycharges_model->delete($this->input->get("id"));
$data["redirect"]="site/viewfacilitycharges";
$this->load->view("redirect",$data);
}
public function viewroomtype()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewroomtype";
$data["base_url"]=site_url("site/viewroomtypejson");
$data["title"]="View roomtype";
$this->load->view("template",$data);
}
function viewroomtypejson()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`hospital_roomtype`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`hospital_roomtype`.`name`";
$elements[1]->sort="1";
$elements[1]->header="Name";
$elements[1]->alias="name";
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
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `hospital_roomtype`");
$this->load->view("json",$data);
}

public function createroomtype()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="createroomtype";
$data["title"]="Create roomtype";
$this->load->view("template",$data);
}
public function createroomtypesubmit() 
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("name","Name","trim");
$this->form_validation->set_rules("status","Status","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="createroomtype";
$data["title"]="Create roomtype";
$this->load->view("template",$data);
}
else
{
$name=$this->input->get_post("name");
$status=$this->input->get_post("status");
if($this->roomtype_model->create($name,$status)==0)
$data["alerterror"]="New roomtype could not be created.";
else
$data["alertsuccess"]="roomtype created Successfully.";
$data["redirect"]="site/viewroomtype";
$this->load->view("redirect",$data);
}
}
public function editroomtype()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="editroomtype";
$data["title"]="Edit roomtype";
$data["before"]=$this->roomtype_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function editroomtypesubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","ID","trim");
$this->form_validation->set_rules("name","Name","trim");
$this->form_validation->set_rules("status","Status","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="editroomtype";
$data["title"]="Edit roomtype";
$data["before"]=$this->roomtype_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$name=$this->input->get_post("name");
$status=$this->input->get_post("status");
if($this->roomtype_model->edit($id,$name,$status)==0)
$data["alerterror"]="New roomtype could not be Updated.";
else
$data["alertsuccess"]="roomtype Updated Successfully.";
$data["redirect"]="site/viewroomtype";
$this->load->view("redirect",$data);
}
}
public function deleteroomtype()
{
$access=array("1");
$this->checkaccess($access);
$this->roomtype_model->delete($this->input->get("id"));
$data["redirect"]="site/viewroomtype";
$this->load->view("redirect",$data);
}
public function viewdiagnosticcenter()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewdiagnosticcenter";
$data["base_url"]=site_url("site/viewdiagnosticcenterjson");
$data["title"]="View diagnosticcenter";
$this->load->view("template",$data);
}
function viewdiagnosticcenterjson()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`hospital_diagnosticcenter`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`hospital_diagnosticcenter`.`name`";
$elements[1]->sort="1";
$elements[1]->header="Name";
$elements[1]->alias="name";
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
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `hospital_diagnosticcenter`");
$this->load->view("json",$data);
}

public function creatediagnosticcenter()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="creatediagnosticcenter";
$data["title"]="Create diagnosticcenter";
$this->load->view("template",$data);
}
public function creatediagnosticcentersubmit() 
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("name","Name","trim");
$this->form_validation->set_rules("status","Status","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="creatediagnosticcenter";
$data["title"]="Create diagnosticcenter";
$this->load->view("template",$data);
}
else
{
$name=$this->input->get_post("name");
$status=$this->input->get_post("status");
if($this->diagnosticcenter_model->create($name,$status)==0)
$data["alerterror"]="New diagnosticcenter could not be created.";
else
$data["alertsuccess"]="diagnosticcenter created Successfully.";
$data["redirect"]="site/viewdiagnosticcenter";
$this->load->view("redirect",$data);
}
}
public function editdiagnosticcenter()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="editdiagnosticcenter";
$data["title"]="Edit diagnosticcenter";
$data["before"]=$this->diagnosticcenter_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function editdiagnosticcentersubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","ID","trim");
$this->form_validation->set_rules("name","Name","trim");
$this->form_validation->set_rules("status","Status","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="editdiagnosticcenter";
$data["title"]="Edit diagnosticcenter";
$data["before"]=$this->diagnosticcenter_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$name=$this->input->get_post("name");
$status=$this->input->get_post("status");
if($this->diagnosticcenter_model->edit($id,$name,$status)==0)
$data["alerterror"]="New diagnosticcenter could not be Updated.";
else
$data["alertsuccess"]="diagnosticcenter Updated Successfully.";
$data["redirect"]="site/viewdiagnosticcenter";
$this->load->view("redirect",$data);
}
}
public function deletediagnosticcenter()
{
$access=array("1");
$this->checkaccess($access);
$this->diagnosticcenter_model->delete($this->input->get("id"));
$data["redirect"]="site/viewdiagnosticcenter";
$this->load->view("redirect",$data);
}
public function viewdepartment()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewdepartment";
$data["base_url"]=site_url("site/viewdepartmentjson");
$data["title"]="View department";
$this->load->view("template",$data);
}
function viewdepartmentjson()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`hospital_department`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`hospital_department`.`name`";
$elements[1]->sort="1";
$elements[1]->header="Name";
$elements[1]->alias="name";
$elements[2]=new stdClass();
$elements[2]->field="`hospital_department`.`description`";
$elements[2]->sort="1";
$elements[2]->header="Description";
$elements[2]->alias="description";
$elements[3]=new stdClass();
$elements[3]->field="`hospital_department`.`facility`";
$elements[3]->sort="1";
$elements[3]->header="Facility";
$elements[3]->alias="facility";
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
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `hospital_department`");
$this->load->view("json",$data);
}

public function createdepartment()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="createdepartment";
$data["title"]="Create department";
$this->load->view("template",$data);
}
public function createdepartmentsubmit() 
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("name","Name","trim");
$this->form_validation->set_rules("description","Description","trim");
$this->form_validation->set_rules("facility","Facility","trim");
$this->form_validation->set_rules("status","Status","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="createdepartment";
$data["title"]="Create department";
$this->load->view("template",$data);
}
else
{
$name=$this->input->get_post("name");
$description=$this->input->get_post("description");
$facility=$this->input->get_post("facility");
$status=$this->input->get_post("status");
if($this->department_model->create($name,$description,$facility,$status)==0)
$data["alerterror"]="New department could not be created.";
else
$data["alertsuccess"]="department created Successfully.";
$data["redirect"]="site/viewdepartment";
$this->load->view("redirect",$data);
}
}
public function editdepartment()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="editdepartment";
$data["title"]="Edit department";
$data["before"]=$this->department_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function editdepartmentsubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","ID","trim");
$this->form_validation->set_rules("name","Name","trim");
$this->form_validation->set_rules("description","Description","trim");
$this->form_validation->set_rules("facility","Facility","trim");
$this->form_validation->set_rules("status","Status","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="editdepartment";
$data["title"]="Edit department";
$data["before"]=$this->department_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$name=$this->input->get_post("name");
$description=$this->input->get_post("description");
$facility=$this->input->get_post("facility");
$status=$this->input->get_post("status");
if($this->department_model->edit($id,$name,$description,$facility,$status)==0)
$data["alerterror"]="New department could not be Updated.";
else
$data["alertsuccess"]="department Updated Successfully.";
$data["redirect"]="site/viewdepartment";
$this->load->view("redirect",$data);
}
}
public function deletedepartment()
{
$access=array("1");
$this->checkaccess($access);
$this->department_model->delete($this->input->get("id"));
$data["redirect"]="site/viewdepartment";
$this->load->view("redirect",$data);
}
public function viewprocedure()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewprocedure";
$data["base_url"]=site_url("site/viewprocedurejson");
$data["title"]="View procedure";
$this->load->view("template",$data);
}
function viewprocedurejson()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`hospital_procedure`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`hospital_procedure`.`name`";
$elements[1]->sort="1";
$elements[1]->header="Name";
$elements[1]->alias="name";
$elements[2]=new stdClass();
$elements[2]->field="`hospital_procedure`.`description`";
$elements[2]->sort="1";
$elements[2]->header="Description";
$elements[2]->alias="description";
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
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `hospital_procedure`");
$this->load->view("json",$data);
}

public function createprocedure()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="createprocedure";
$data["title"]="Create procedure";
$this->load->view("template",$data);
}
public function createproceduresubmit() 
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("name","Name","trim");
$this->form_validation->set_rules("description","Description","trim");
$this->form_validation->set_rules("status","Status","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="createprocedure";
$data["title"]="Create procedure";
$this->load->view("template",$data);
}
else
{
$name=$this->input->get_post("name");
$description=$this->input->get_post("description");
$status=$this->input->get_post("status");
if($this->procedure_model->create($name,$description,$status)==0)
$data["alerterror"]="New procedure could not be created.";
else
$data["alertsuccess"]="procedure created Successfully.";
$data["redirect"]="site/viewprocedure";
$this->load->view("redirect",$data);
}
}
public function editprocedure()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="editprocedure";
$data["title"]="Edit procedure";
$data["before"]=$this->procedure_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function editproceduresubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","ID","trim");
$this->form_validation->set_rules("name","Name","trim");
$this->form_validation->set_rules("description","Description","trim");
$this->form_validation->set_rules("status","Status","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="editprocedure";
$data["title"]="Edit procedure";
$data["before"]=$this->procedure_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$name=$this->input->get_post("name");
$description=$this->input->get_post("description");
$status=$this->input->get_post("status");
if($this->procedure_model->edit($id,$name,$description,$status)==0)
$data["alerterror"]="New procedure could not be Updated.";
else
$data["alertsuccess"]="procedure Updated Successfully.";
$data["redirect"]="site/viewprocedure";
$this->load->view("redirect",$data);
}
}
public function deleteprocedure()
{
$access=array("1");
$this->checkaccess($access);
$this->procedure_model->delete($this->input->get("id"));
$data["redirect"]="site/viewprocedure";
$this->load->view("redirect",$data);
}
public function viewoffer()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewoffer";
$data["base_url"]=site_url("site/viewofferjson");
$data["title"]="View offer";
$this->load->view("template",$data);
}
function viewofferjson()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`hospital_offer`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`hospital_offer`.`title`";
$elements[1]->sort="1";
$elements[1]->header="Title";
$elements[1]->alias="title";
$elements[2]=new stdClass();
$elements[2]->field="`hospital_offer`.`starttime`";
$elements[2]->sort="1";
$elements[2]->header="Start Time";
$elements[2]->alias="starttime";
$elements[3]=new stdClass();
$elements[3]->field="`hospital_offer`.`endtime`";
$elements[3]->sort="1";
$elements[3]->header="End Time";
$elements[3]->alias="endtime";
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
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `hospital_offer`");
$this->load->view("json",$data);
}

public function createoffer()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="createoffer";
$data["title"]="Create offer";
$this->load->view("template",$data);
}
public function createoffersubmit() 
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("title","Title","trim");
$this->form_validation->set_rules("starttime","Start Time","trim");
$this->form_validation->set_rules("endtime","End Time","trim");
$this->form_validation->set_rules("status","Status","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="createoffer";
$data["title"]="Create offer";
$this->load->view("template",$data);
}
else
{
$title=$this->input->get_post("title");
$starttime=$this->input->get_post("starttime");
$endtime=$this->input->get_post("endtime");
$status=$this->input->get_post("status");
if($this->offer_model->create($title,$starttime,$endtime,$status)==0)
$data["alerterror"]="New offer could not be created.";
else
$data["alertsuccess"]="offer created Successfully.";
$data["redirect"]="site/viewoffer";
$this->load->view("redirect",$data);
}
}
public function editoffer()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="editoffer";
$data["title"]="Edit offer";
$data["before"]=$this->offer_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function editoffersubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","ID","trim");
$this->form_validation->set_rules("title","Title","trim");
$this->form_validation->set_rules("starttime","Start Time","trim");
$this->form_validation->set_rules("endtime","End Time","trim");
$this->form_validation->set_rules("status","Status","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="editoffer";
$data["title"]="Edit offer";
$data["before"]=$this->offer_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$title=$this->input->get_post("title");
$starttime=$this->input->get_post("starttime");
$endtime=$this->input->get_post("endtime");
$status=$this->input->get_post("status");
if($this->offer_model->edit($id,$title,$starttime,$endtime,$status)==0)
$data["alerterror"]="New offer could not be Updated.";
else
$data["alertsuccess"]="offer Updated Successfully.";
$data["redirect"]="site/viewoffer";
$this->load->view("redirect",$data);
}
}
public function deleteoffer()
{
$access=array("1");
$this->checkaccess($access);
$this->offer_model->delete($this->input->get("id"));
$data["redirect"]="site/viewoffer";
$this->load->view("redirect",$data);
}
public function viewuseraddress()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewuseraddress";
$data["base_url"]=site_url("site/viewuseraddressjson");
$data["title"]="View useraddress";
$this->load->view("template",$data);
}
function viewuseraddressjson()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`hospital_useraddress`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`hospital_useraddress`.`name`";
$elements[1]->sort="1";
$elements[1]->header="Name";
$elements[1]->alias="name";
$elements[2]=new stdClass();
$elements[2]->field="`hospital_useraddress`.`parent`";
$elements[2]->sort="1";
$elements[2]->header="Parent";
$elements[2]->alias="parent";
$elements[3]=new stdClass();
$elements[3]->field="`hospital_useraddress`.`external`";
$elements[3]->sort="1";
$elements[3]->header="External";
$elements[3]->alias="external";
$elements[4]=new stdClass();
$elements[4]->field="`hospital_useraddress`.`locationtype`";
$elements[4]->sort="1";
$elements[4]->header="Location Type";
$elements[4]->alias="locationtype";
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
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `hospital_useraddress`");
$this->load->view("json",$data);
}

public function createuseraddress()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="createuseraddress";
$data["title"]="Create useraddress";
$this->load->view("template",$data);
}
public function createuseraddresssubmit() 
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("name","Name","trim");
$this->form_validation->set_rules("parent","Parent","trim");
$this->form_validation->set_rules("external","External","trim");
$this->form_validation->set_rules("locationtype","Location Type","trim");
$this->form_validation->set_rules("pin","Pin","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="createuseraddress";
$data["title"]="Create useraddress";
$this->load->view("template",$data);
}
else
{
$name=$this->input->get_post("name");
$parent=$this->input->get_post("parent");
$external=$this->input->get_post("external");
$locationtype=$this->input->get_post("locationtype");
$pin=$this->input->get_post("pin");
if($this->useraddress_model->create($name,$parent,$external,$locationtype,$pin)==0)
$data["alerterror"]="New useraddress could not be created.";
else
$data["alertsuccess"]="useraddress created Successfully.";
$data["redirect"]="site/viewuseraddress";
$this->load->view("redirect",$data);
}
}
public function edituseraddress()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="edituseraddress";
$data["title"]="Edit useraddress";
$data["before"]=$this->useraddress_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function edituseraddresssubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","ID","trim");
$this->form_validation->set_rules("name","Name","trim");
$this->form_validation->set_rules("parent","Parent","trim");
$this->form_validation->set_rules("external","External","trim");
$this->form_validation->set_rules("locationtype","Location Type","trim");
$this->form_validation->set_rules("pin","Pin","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="edituseraddress";
$data["title"]="Edit useraddress";
$data["before"]=$this->useraddress_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$name=$this->input->get_post("name");
$parent=$this->input->get_post("parent");
$external=$this->input->get_post("external");
$locationtype=$this->input->get_post("locationtype");
$pin=$this->input->get_post("pin");
if($this->useraddress_model->edit($id,$name,$parent,$external,$locationtype,$pin)==0)
$data["alerterror"]="New useraddress could not be Updated.";
else
$data["alertsuccess"]="useraddress Updated Successfully.";
$data["redirect"]="site/viewuseraddress";
$this->load->view("redirect",$data);
}
}
public function deleteuseraddress()
{
$access=array("1");
$this->checkaccess($access);
$this->useraddress_model->delete($this->input->get("id"));
$data["redirect"]="site/viewuseraddress";
$this->load->view("redirect",$data);
}
public function viewfeedback()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewfeedback";
$data["base_url"]=site_url("site/viewfeedbackjson");
$data["title"]="View feedback";
$this->load->view("template",$data);
}
function viewfeedbackjson()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`hospital_feedback`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`hospital_feedback`.`user`";
$elements[1]->sort="1";
$elements[1]->header="User";
$elements[1]->alias="user";
$elements[2]=new stdClass();
$elements[2]->field="`hospital_feedback`.`hospital`";
$elements[2]->sort="1";
$elements[2]->header="Hospital";
$elements[2]->alias="hospital";
$elements[3]=new stdClass();
$elements[3]->field="`hospital_feedback`.`doctor`";
$elements[3]->sort="1";
$elements[3]->header="Doctor";
$elements[3]->alias="doctor";
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
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `hospital_feedback`");
$this->load->view("json",$data);
}

public function createfeedback()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="createfeedback";
$data["title"]="Create feedback";
$this->load->view("template",$data);
}
public function createfeedbacksubmit() 
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("user","User","trim");
$this->form_validation->set_rules("hospital","Hospital","trim");
$this->form_validation->set_rules("doctor","Doctor","trim");
$this->form_validation->set_rules("description","Description","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="createfeedback";
$data["title"]="Create feedback";
$this->load->view("template",$data);
}
else
{
$user=$this->input->get_post("user");
$hospital=$this->input->get_post("hospital");
$doctor=$this->input->get_post("doctor");
$description=$this->input->get_post("description");
if($this->feedback_model->create($user,$hospital,$doctor,$description)==0)
$data["alerterror"]="New feedback could not be created.";
else
$data["alertsuccess"]="feedback created Successfully.";
$data["redirect"]="site/viewfeedback";
$this->load->view("redirect",$data);
}
}
public function editfeedback()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="editfeedback";
$data["title"]="Edit feedback";
$data["before"]=$this->feedback_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function editfeedbacksubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","ID","trim");
$this->form_validation->set_rules("user","User","trim");
$this->form_validation->set_rules("hospital","Hospital","trim");
$this->form_validation->set_rules("doctor","Doctor","trim");
$this->form_validation->set_rules("description","Description","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="editfeedback";
$data["title"]="Edit feedback";
$data["before"]=$this->feedback_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$user=$this->input->get_post("user");
$hospital=$this->input->get_post("hospital");
$doctor=$this->input->get_post("doctor");
$description=$this->input->get_post("description");
if($this->feedback_model->edit($id,$user,$hospital,$doctor,$description)==0)
$data["alerterror"]="New feedback could not be Updated.";
else
$data["alertsuccess"]="feedback Updated Successfully.";
$data["redirect"]="site/viewfeedback";
$this->load->view("redirect",$data);
}
}
public function deletefeedback()
{
$access=array("1");
$this->checkaccess($access);
$this->feedback_model->delete($this->input->get("id"));
$data["redirect"]="site/viewfeedback";
$this->load->view("redirect",$data);
}
public function viewpatient()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewpatient";
$data["base_url"]=site_url("site/viewpatientjson");
$data["title"]="View patient";
$this->load->view("template",$data);
}
function viewpatientjson()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`hospital_patient`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`hospital_patient`.`name`";
$elements[1]->sort="1";
$elements[1]->header="Name";
$elements[1]->alias="name";
$elements[2]=new stdClass();
$elements[2]->field="`hospital_patient`.`contact`";
$elements[2]->sort="1";
$elements[2]->header="Contact";
$elements[2]->alias="contact";
$elements[3]=new stdClass();
$elements[3]->field="`hospital_patient`.`lastselectedhospital`";
$elements[3]->sort="1";
$elements[3]->header="Last Selected Hospital";
$elements[3]->alias="lastselectedhospital";
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
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `hospital_patient`");
$this->load->view("json",$data);
}

public function createpatient()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="createpatient";
$data["title"]="Create patient";
$this->load->view("template",$data);
}
public function createpatientsubmit() 
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("name","Name","trim");
$this->form_validation->set_rules("contact","Contact","trim");
$this->form_validation->set_rules("lastselectedhospital","Last Selected Hospital","trim");
$this->form_validation->set_rules("lastreporteddeciese","Last Reported Deciese","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="createpatient";
$data["title"]="Create patient";
$this->load->view("template",$data);
}
else
{
$name=$this->input->get_post("name");
$contact=$this->input->get_post("contact");
$lastselectedhospital=$this->input->get_post("lastselectedhospital");
$lastreporteddeciese=$this->input->get_post("lastreporteddeciese");
if($this->patient_model->create($name,$contact,$lastselectedhospital,$lastreporteddeciese)==0)
$data["alerterror"]="New patient could not be created.";
else
$data["alertsuccess"]="patient created Successfully.";
$data["redirect"]="site/viewpatient";
$this->load->view("redirect",$data);
}
}
public function editpatient()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="editpatient";
$data["title"]="Edit patient";
$data["before"]=$this->patient_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function editpatientsubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","ID","trim");
$this->form_validation->set_rules("name","Name","trim");
$this->form_validation->set_rules("contact","Contact","trim");
$this->form_validation->set_rules("lastselectedhospital","Last Selected Hospital","trim");
$this->form_validation->set_rules("lastreporteddeciese","Last Reported Deciese","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="editpatient";
$data["title"]="Edit patient";
$data["before"]=$this->patient_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$name=$this->input->get_post("name");
$contact=$this->input->get_post("contact");
$lastselectedhospital=$this->input->get_post("lastselectedhospital");
$lastreporteddeciese=$this->input->get_post("lastreporteddeciese");
if($this->patient_model->edit($id,$name,$contact,$lastselectedhospital,$lastreporteddeciese)==0)
$data["alerterror"]="New patient could not be Updated.";
else
$data["alertsuccess"]="patient Updated Successfully.";
$data["redirect"]="site/viewpatient";
$this->load->view("redirect",$data);
}
}
public function deletepatient()
{
$access=array("1");
$this->checkaccess($access);
$this->patient_model->delete($this->input->get("id"));
$data["redirect"]="site/viewpatient";
$this->load->view("redirect",$data);
}
public function viewdoctor()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewdoctor";
$data["base_url"]=site_url("site/viewdoctorjson");
$data["title"]="View doctor";
$this->load->view("template",$data);
}
function viewdoctorjson()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`hospital_doctor`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`hospital_doctor`.`name`";
$elements[1]->sort="1";
$elements[1]->header="Name";
$elements[1]->alias="name";
$elements[2]=new stdClass();
$elements[2]->field="`hospital_doctor`.`degree`";
$elements[2]->sort="1";
$elements[2]->header="Degree";
$elements[2]->alias="degree";
$elements[3]=new stdClass();
$elements[3]->field="`hospital_doctor`.`specialization`";
$elements[3]->sort="1";
$elements[3]->header="Specialization";
$elements[3]->alias="specialization";
$elements[4]=new stdClass();
$elements[4]->field="`hospital_doctor`.`availabledays`";
$elements[4]->sort="1";
$elements[4]->header="Available Days";
$elements[4]->alias="availabledays";
$elements[5]=new stdClass();
$elements[5]->field="`hospital_doctor`.`type`";
$elements[5]->sort="1";
$elements[5]->header="Type";
$elements[5]->alias="type";
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
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `hospital_doctor`");
$this->load->view("json",$data);
}

public function createdoctor()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="createdoctor";
$data["title"]="Create doctor";
$this->load->view("template",$data);
}
public function createdoctorsubmit() 
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("name","Name","trim");
$this->form_validation->set_rules("degree","Degree","trim");
$this->form_validation->set_rules("specialization","Specialization","trim");
$this->form_validation->set_rules("availabledays","Available Days","trim");
$this->form_validation->set_rules("type","Type","trim");
$this->form_validation->set_rules("hospital","Hospital","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="createdoctor";
$data["title"]="Create doctor";
$this->load->view("template",$data);
}
else
{
$name=$this->input->get_post("name");
$degree=$this->input->get_post("degree");
$specialization=$this->input->get_post("specialization");
$availabledays=$this->input->get_post("availabledays");
$type=$this->input->get_post("type");
$hospital=$this->input->get_post("hospital");
if($this->doctor_model->create($name,$degree,$specialization,$availabledays,$type,$hospital)==0)
$data["alerterror"]="New doctor could not be created.";
else
$data["alertsuccess"]="doctor created Successfully.";
$data["redirect"]="site/viewdoctor";
$this->load->view("redirect",$data);
}
}
public function editdoctor()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="editdoctor";
$data["title"]="Edit doctor";
$data["before"]=$this->doctor_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function editdoctorsubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","ID","trim");
$this->form_validation->set_rules("name","Name","trim");
$this->form_validation->set_rules("degree","Degree","trim");
$this->form_validation->set_rules("specialization","Specialization","trim");
$this->form_validation->set_rules("availabledays","Available Days","trim");
$this->form_validation->set_rules("type","Type","trim");
$this->form_validation->set_rules("hospital","Hospital","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="editdoctor";
$data["title"]="Edit doctor";
$data["before"]=$this->doctor_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$name=$this->input->get_post("name");
$degree=$this->input->get_post("degree");
$specialization=$this->input->get_post("specialization");
$availabledays=$this->input->get_post("availabledays");
$type=$this->input->get_post("type");
$hospital=$this->input->get_post("hospital");
if($this->doctor_model->edit($id,$name,$degree,$specialization,$availabledays,$type,$hospital)==0)
$data["alerterror"]="New doctor could not be Updated.";
else
$data["alertsuccess"]="doctor Updated Successfully.";
$data["redirect"]="site/viewdoctor";
$this->load->view("redirect",$data);
}
}
public function deletedoctor()
{
$access=array("1");
$this->checkaccess($access);
$this->doctor_model->delete($this->input->get("id"));
$data["redirect"]="site/viewdoctor";
$this->load->view("redirect",$data);
}
public function viewgallery()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewgallery";
$data["base_url"]=site_url("site/viewgalleryjson");
$data["title"]="View gallery";
$this->load->view("template",$data);
}
function viewgalleryjson()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`hospital_gallery`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`hospital_gallery`.`name`";
$elements[1]->sort="1";
$elements[1]->header="Name";
$elements[1]->alias="name";
$elements[2]=new stdClass();
$elements[2]->field="`hospital_gallery`.`description`";
$elements[2]->sort="1";
$elements[2]->header="Description";
$elements[2]->alias="description";
$elements[3]=new stdClass();
$elements[3]->field="`hospital_gallery`.`hospital`";
$elements[3]->sort="1";
$elements[3]->header="Hospital";
$elements[3]->alias="hospital";
$elements[4]=new stdClass();
$elements[4]->field="`hospital_gallery`.`type`";
$elements[4]->sort="1";
$elements[4]->header="Type";
$elements[4]->alias="type";
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
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `hospital_gallery`");
$this->load->view("json",$data);
}

public function creategallery()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="creategallery";
$data["title"]="Create gallery";
$this->load->view("template",$data);
}
public function creategallerysubmit() 
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("name","Name","trim");
$this->form_validation->set_rules("description","Description","trim");
$this->form_validation->set_rules("hospital","Hospital","trim");
$this->form_validation->set_rules("type","Type","trim");
$this->form_validation->set_rules("doctor","Doctor","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="creategallery";
$data["title"]="Create gallery";
$this->load->view("template",$data);
}
else
{
$name=$this->input->get_post("name");
$description=$this->input->get_post("description");
$hospital=$this->input->get_post("hospital");
$type=$this->input->get_post("type");
$doctor=$this->input->get_post("doctor");
if($this->gallery_model->create($name,$description,$hospital,$type,$doctor)==0)
$data["alerterror"]="New gallery could not be created.";
else
$data["alertsuccess"]="gallery created Successfully.";
$data["redirect"]="site/viewgallery";
$this->load->view("redirect",$data);
}
}
public function editgallery()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="editgallery";
$data["title"]="Edit gallery";
$data["before"]=$this->gallery_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function editgallerysubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","ID","trim");
$this->form_validation->set_rules("name","Name","trim");
$this->form_validation->set_rules("description","Description","trim");
$this->form_validation->set_rules("hospital","Hospital","trim");
$this->form_validation->set_rules("type","Type","trim");
$this->form_validation->set_rules("doctor","Doctor","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="editgallery";
$data["title"]="Edit gallery";
$data["before"]=$this->gallery_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$name=$this->input->get_post("name");
$description=$this->input->get_post("description");
$hospital=$this->input->get_post("hospital");
$type=$this->input->get_post("type");
$doctor=$this->input->get_post("doctor");
if($this->gallery_model->edit($id,$name,$description,$hospital,$type,$doctor)==0)
$data["alerterror"]="New gallery could not be Updated.";
else
$data["alertsuccess"]="gallery Updated Successfully.";
$data["redirect"]="site/viewgallery";
$this->load->view("redirect",$data);
}
}
public function deletegallery()
{
$access=array("1");
$this->checkaccess($access);
$this->gallery_model->delete($this->input->get("id"));
$data["redirect"]="site/viewgallery";
$this->load->view("redirect",$data);
}
public function viewaggrement()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewaggrement";
$data["base_url"]=site_url("site/viewaggrementjson");
$data["title"]="View aggrement";
$this->load->view("template",$data);
}
function viewaggrementjson()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`hospital_aggrement`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`hospital_aggrement`.`hospital`";
$elements[1]->sort="1";
$elements[1]->header="Hospital";
$elements[1]->alias="hospital";
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
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `hospital_aggrement`");
$this->load->view("json",$data);
}

public function createaggrement()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="createaggrement";
$data["title"]="Create aggrement";
$this->load->view("template",$data);
}
public function createaggrementsubmit() 
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("hospital","Hospital","trim");
$this->form_validation->set_rules("doctor","Doctor","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="createaggrement";
$data["title"]="Create aggrement";
$this->load->view("template",$data);
}
else
{
$hospital=$this->input->get_post("hospital");
$doctor=$this->input->get_post("doctor");
if($this->aggrement_model->create($hospital,$doctor)==0)
$data["alerterror"]="New aggrement could not be created.";
else
$data["alertsuccess"]="aggrement created Successfully.";
$data["redirect"]="site/viewaggrement";
$this->load->view("redirect",$data);
}
}
public function editaggrement()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="editaggrement";
$data["title"]="Edit aggrement";
$data["before"]=$this->aggrement_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function editaggrementsubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","ID","trim");
$this->form_validation->set_rules("hospital","Hospital","trim");
$this->form_validation->set_rules("doctor","Doctor","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="editaggrement";
$data["title"]="Edit aggrement";
$data["before"]=$this->aggrement_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$hospital=$this->input->get_post("hospital");
$doctor=$this->input->get_post("doctor");
if($this->aggrement_model->edit($id,$hospital,$doctor)==0)
$data["alerterror"]="New aggrement could not be Updated.";
else
$data["alertsuccess"]="aggrement Updated Successfully.";
$data["redirect"]="site/viewaggrement";
$this->load->view("redirect",$data);
}
}
public function deleteaggrement()
{
$access=array("1");
$this->checkaccess($access);
$this->aggrement_model->delete($this->input->get("id"));
$data["redirect"]="site/viewaggrement";
$this->load->view("redirect",$data);
}
public function viewuserlog()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewuserlog";
$data["base_url"]=site_url("site/viewuserlogjson");
$data["title"]="View userlog";
$this->load->view("template",$data);
}
function viewuserlogjson()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`hospital_userlog`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`hospital_userlog`.`hospital`";
$elements[1]->sort="1";
$elements[1]->header="Hospital";
$elements[1]->alias="hospital";
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
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `hospital_userlog`");
$this->load->view("json",$data);
}

public function createuserlog()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="createuserlog";
$data["title"]="Create userlog";
$this->load->view("template",$data);
}
public function createuserlogsubmit() 
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("hospital","Hospital","trim");
$this->form_validation->set_rules("deciese","Deciese","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="createuserlog";
$data["title"]="Create userlog";
$this->load->view("template",$data);
}
else
{
$hospital=$this->input->get_post("hospital");
$deciese=$this->input->get_post("deciese");
if($this->userlog_model->create($hospital,$deciese)==0)
$data["alerterror"]="New userlog could not be created.";
else
$data["alertsuccess"]="userlog created Successfully.";
$data["redirect"]="site/viewuserlog";
$this->load->view("redirect",$data);
}
}
public function edituserlog()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="edituserlog";
$data["title"]="Edit userlog";
$data["before"]=$this->userlog_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function edituserlogsubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","ID","trim");
$this->form_validation->set_rules("hospital","Hospital","trim");
$this->form_validation->set_rules("deciese","Deciese","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="edituserlog";
$data["title"]="Edit userlog";
$data["before"]=$this->userlog_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$hospital=$this->input->get_post("hospital");
$deciese=$this->input->get_post("deciese");
if($this->userlog_model->edit($id,$hospital,$deciese)==0)
$data["alerterror"]="New userlog could not be Updated.";
else
$data["alertsuccess"]="userlog Updated Successfully.";
$data["redirect"]="site/viewuserlog";
$this->load->view("redirect",$data);
}
}
public function deleteuserlog()
{
$access=array("1");
$this->checkaccess($access);
$this->userlog_model->delete($this->input->get("id"));
$data["redirect"]="site/viewuserlog";
$this->load->view("redirect",$data);
}

}
?>
