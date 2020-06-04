<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//General service API class 
class Users extends Common_Admin_Controller{
    
    public function __construct(){
        parent::__construct();
    }

    public function changePassword_post()
    {

        $authCheck  = $this->check_admin_service_auth();
        $authToken  = $this->authData->authToken;
        $userId     = $this->authData->id;
        $this->load->library('form_validation');
        $this->form_validation->set_rules('password', 'password', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('npassword', 'new password', 'trim|required|matches[rnpassword]|min_length[6]');
        $this->form_validation->set_rules('rnpassword', 'retype new password ','trim|required|min_length[6]');
       if($this->form_validation->run($this) == FALSE){
            $messages       = (validation_errors()) ? validation_errors() : '';
            $response       = array('status' => 0, 'message' => $messages);
        }else{
            $password       = $this->input->post('password');
            $npassword      = $this->input->post('npassword');
            $select         = "password";
            $where          = array('id' => $userId); 
            $admin          = $this->common_model->getsingle('admin', $where,'password');
            if(password_verify($password, $admin['password'])){
                $set        = array('password'=> password_hash($this->input->post('npassword') , PASSWORD_DEFAULT)); 
                $update     = $this->common_model->updateFields('admin', $set, $where);
                if($update){
                    $res = array();
                    if($update){
                        $response = array('status' =>SUCCESS, 'message' => 'Successfully Updated', 'url' => base_url('users/userDetail'));
                    }else{
                        $response = array('status' => FAIL, 'message' => 'Failed! Please try again', 'url' => base_url('users/userDetail'));
                    }    
                } 
            }else{
                $response = array('status' =>FAIL, 'message' => 'Your Current Password is Wrong !', 'url' => base_url('users/userDetail'));                 
            }
        }
       $this->response($response);
    }//End Function
    function updateUser_post(){
        $authCheck  = $this->check_admin_service_auth();
        $authToken  = $this->authData->authToken;
        $userId     = $this->authData->id;
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('contact', 'Contact Number', 'trim|required|min_length[10]|max_length[20]');
        $this->form_validation->set_rules('fullName', 'full Name', 'trim|required|min_length[2]');
        if($this->form_validation->run() == FALSE){
            $response = array('status' => FAIL, 'message' => strip_tags(validation_errors()));  
        }else{
        
            $userid             =  $this->post('userauth');
            $userauth           =  decoding($userid);
            $email              =  $this->post('email');
            $fullName           =  $this->post('fullName');
         //   $weatherTemperature           =  $this->post('weatherTemperature');
            $isExist            =  $this->common_model->is_data_exists('admin',array('id'=>$userauth));
            if($isExist){
                $isExistEmail   = $this->common_model->is_data_exists('admin',array('id  !='=>$userauth,'email'=>$email));
                if(!$isExistEmail){
                    //update
                    //user info
                    $userData['fullName']           =   $fullName;
                    $userData['email']              =   $email;
                    $userData['contactNumber']      =   $this->post('contact');
                   // $userData['weatherTemperature'] =   $this->post('weatherTemperature');
                    //user info
                    // profile pic upload
                    $this->load->model('Image_model');

                    $image          = array(); $profileImage = '';
                    if (!empty($_FILES['profileImage']['name'])) {
                        $folder     = 'admin';
                        $image      = $this->Image_model->upload_image('profileImage',$folder); //upload media of Seller
                        //check for error
                        if(array_key_exists("error",$image) && !empty($image['error'])){
                            $response = array('status' => FAIL, 'message' => strip_tags($image['error'].'(In user Image)'));
                           $this->response($response);die;
                        }
                        //check for image name if present
                        if(array_key_exists("image_name",$image)):
                            $profileImage = $image['image_name'];
                            if(!empty($isExist->profileImage)){
                                $this->Image_model->delete_image('uploads/admin/',$isExist->profileImage);
                            }
                        endif;
                        }
                        if(!empty($profileImage)){
                            $userData['profileImage']           =   $profileImage;
                        } 
                    //update
                    $result = $this->common_model->updateFields('admin',$userData,array('id'=>$userauth));
                    if($result){
                        $response   = array('status'=>SUCCESS,'message'=>ResponseMessages::getStatusCodeMessage(123),'url'=>$userid);
                    }else{
                        $response   = array('status'=>FAIL,'message'=>ResponseMessages::getStatusCodeMessage(118),'userDetail'=>array());
                    }  
                }else{
                    $response       = array('status'=>FAIL,'message'=>ResponseMessages::getStatusCodeMessage(117),'userDetail'=>array());
                }
            }else{
                $response = array('status'=>FAIL,'message'=>ResponseMessages::getStatusCodeMessage(126),'userDetail'=>array()); 
            }
        }
        $this->response($response);
    }//end function
}//End Class 