<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//General service API class 
class Tasks extends Common_Admin_Controller{
    
    public function __construct(){
        parent::__construct();
          error_reporting(E_ALL);
        ini_set('display_errors', 1);
        $this->check_admin_service_auth();
    }
    public function add_post(){
       
        $this->form_validation->set_rules('name', 'name', 'trim|required');
     
        if($this->form_validation->run() == FALSE){
            $response = array('status' => FAIL, 'message' => strip_tags(validation_errors()));    
        }else{
          //  pr($_FILES);
			$data_val['name']       	= $this->post('name');
			$data_val['description']       	= $this->post('description');
			/*$text_meta_val['fileType'] ='TEXT';
            $text_meta_val['file'] = $this->post('textfile');*/
            /********/
            $total_element_text              = $this->post('total_element_text');
            $total_element_text              = !empty($total_element_text) ? $total_element_text :0;
            $textData                    = array();
            $textDeleteId             = array();
            $j = 0;
            for ($i=0; $i < $total_element_text ; $i++) { 
                $k                       = $i+1;
                $textfile                = $this->post('textfile_'.$k);
                $textfileId              = $this->post('textfileId_'.$k);
                if(!empty($textfileId) && $textfileId !=0){
                    $textDeleteId[]    = $textfileId;
                }
                if(isset($textfile) && !empty($textfile)){
                    $textData[$j]['textfileId']      = $textfileId;
                    $textData[$j]['textfile']        = $textfile;
                   
                    $j++;
                } 
            }
            /********/  
            /********/
            $this->load->model('Image_model');
          
            $total_element_image              = $this->post('total_element_image');
            $total_element_image              = !empty($total_element_image) ? $total_element_image :0;
            $imageData                    = array();
            $imageDeleteId             = array();
            $jm = 0;
            for ($im=0; $im < $total_element_image ; $im++) { 
                $km                       = $im+1;
                $imagefileId              = $this->post('imagefileId_'.$km);
                if (!empty($_FILES['fileImage_'.$km]['name'])) {
                      $imageF = $this->Image_model->updateDocument('fileImage_'.$km,'task_image');
                            //check for image name if present
                            if(array_key_exists("image_name",$imageF)):
                            $imageData[$jm]['imagefileId']      =  $imagefileId;
                            $imageData[$jm]['file']             =  $imageF['image_name'];
                            $jm++;

                            endif;

                    } 
              
            }

                    $total_element_video              = $this->post('total_element_video');
                    $total_element_video              = !empty($total_element_video) ? $total_element_video :0;
                    $videoData                    = array();
                    $videoDeleteId             = array();
                    $jv = 0;
                        for ($iv=0; $iv < $total_element_video ; $iv++) { 
                            $kv                       = $iv+1;
                            $videofileId              = $this->post('videofileId_'.$kv);
                            if (!empty($_FILES['videofile_'.$kv]['name'])) {
                            $videoF=$this->Image_model->updateDocument('videofile_'.$kv,'task_video');
                            //check for image name if present
                            if(array_key_exists("image_name",$videoF)):
                            $videoData[$jv]['videofileId']      =  $videofileId;
                            $videoData[$jv]['file']             =  $videoF['image_name'];
                            $jv++;

                            endif;

                        } 
                    }
            /********/
			$id                  = decoding($this->post('id'));
			$where                      = array('taskId'=>$id);
        	$isExist                    = $this->common_model->is_data_exists('tasks',$where);
        	if($isExist){
        		$result                 = $this->common_model->updateFields('tasks',$data_val,$where);
        		$msg                    = "Record updated successfully.";
                $taskId   = $id ;
        	}else{
        		$result                 = $this->common_model->insertData('tasks',$data_val);
        		$msg                    = "Record added successfully.";
                 $taskId   = $result ;
        	}

             if(!empty($taskId)){
                if(!empty($textDeleteId)){
                    $this->common_model->deleteDataTaskMeta('task_meta',array('taskId'=>$taskId),$textDeleteId);
                }    
                for ($x=0; $x <sizeof($textData) ; $x++) { 
                    $textDatatext                   = array();
                    $textId                            =  $textData[$x]['textfileId'];
                    $textDatatext['description']       = $textData[$x]['textfile'];
                    $textDatatext['fileType']              = 'TEXT';
                    
                    $isText                          = $this->common_model->is_data_exists('task_meta',array('taskmetaId'=>$textId));
                    if($isText){
                        $this->common_model->updateFields('task_meta',$textDatatext,array('taskmetaId'=>$textId));
                    }else{
                        $textDatatext['taskId']     = $taskId;
                        $this->common_model->insertData('task_meta',$textDatatext);
                    }
                }
                for ($xm=0; $xm <sizeof($imageData) ; $xm++) { 
                    $imageDataimage                         = array();
                    $imageId                                =  $imageData[$xm]['imagefileId'];
                    $imageDataimage['file']                 = $imageData[$xm]['file'];
                    $imageDataimage['fileType']             = 'IMAGE';
                    
                    $isText                                 = $this->common_model->is_data_exists('task_meta',array('taskmetaId'=>$imageId));
                    if($isText){
                        $this->common_model->updateFields('task_meta',$imageDataimage,array('taskmetaId'=>$imageId));
                    }else{
                        $imageDataimage['taskId']     = $taskId;
                        $this->common_model->insertData('task_meta',$imageDataimage);
                    }
                }
                  for ($xv=0; $xv <sizeof($videoData) ; $xv++) { 
                    $videoDatavideo                         = array();
                    $videoId                                =  $videoData[$xv]['videofileId'];
                    $videoDatavideo['file']                 = $videoData[$xv]['file'];
                    $videoDatavideo['fileType']             = 'VIDEO';
                    
                    $isTextv                                 = $this->common_model->is_data_exists('task_meta',array('taskmetaId'=>$videoId));
                    if($isTextv){
                        $this->common_model->updateFields('task_meta',$videoDatavideo,array('taskmetaId'=>$videoId));
                    }else{
                        $videoDatavideo['taskId']     = $taskId;
                        $this->common_model->insertData('task_meta',$videoDatavideo);
                    }
                }
                
            }
            if($result){
                //$text_meta_val['taskId'] = $result;
                //$this->common_model->insertData('task_meta',$text_meta_val);
                $response              = array('status'=>SUCCESS,'message'=>$msg,'url'=>base_url().'task-detail/'.encoding($result));
            }else{
                $response              = array('status'=>FAIL,'message'=>ResponseMessages::getStatusCodeMessage(118));
            }        
        }
        $this->response($response);
    }//end function 

    public function addTaskStep_post(){
       
        $this->form_validation->set_rules('id', 'id', 'trim|required');
        $this->form_validation->set_rules('taskstepId', 'task step', 'trim|required');
     
        if($this->form_validation->run() == FALSE){
            $response = array('status' => FAIL, 'message' => strip_tags(validation_errors()));    
        }else{
            $taskId                  = decoding($this->post('id'));
            $where                      = array('taskId'=>$taskId);
            $isExist                    = $this->common_model->is_data_exists('tasks',$where);

            if($isExist){
            $taskstep = $this->post('taskstepId');
            switch ($taskstep) {
                case 'image':
                      $this->load->model('Image_model');
                    $imagefileId              = $this->post('imagefileId_1');
                    if (!empty($_FILES['fileImage_1']['name'])) {
                    $imageF = $this->Image_model->updateDocument('fileImage_1','task_image');
                 
                    if(array_key_exists("image_name",$imageF)):
                        
                        $file             =  $imageF['image_name'];

                        $data_val['fileType']              = 'IMAGE';
                        $data_val['file']              = $file;

                        $isImage                          = $this->common_model->is_data_exists('task_meta',array('taskmetaId'=>$imagefileId));
                        if($isImage){
                            $this->common_model->updateFields('task_meta',$data_val,array('taskmetaId'=>$imagefileId));
                            $status = SUCCESS;
                            $msg    = "Layer record updated successfully.";
                        }else{
                            $data_val['taskId']     = $taskId;
                            $this->common_model->insertData('task_meta',$data_val);
                            $status = SUCCESS;
                            $msg    = "Layer record added successfully.";
                        }

                    endif;

                    } 
                    break;
                case 'video':
                      $this->load->model('Image_model');
                    $videofileId              = $this->post('videofileId_1');
                    if (!empty($_FILES['videofile_1']['name'])) {
                    $videoF=$this->Image_model->updateDocument('videofile_1','task_video');
                    //check for image name if present
                        if(array_key_exists("image_name",$videoF)):
                        $file            =  $videoF['image_name'];
                        $data_val['fileType']              = 'VIDEO';
                        $data_val['file']              = $file;

                        $isVideo                          = $this->common_model->is_data_exists('task_meta',array('taskmetaId'=>$videofileId));
                        if($isVideo){
                            $this->common_model->updateFields('task_meta',$data_val,array('taskmetaId'=>$videofileId));
                            $status = SUCCESS;
                            $msg    = "Layer record updated successfully.";
                        }else{
                            $data_val['taskId']     = $taskId;
                            $this->common_model->insertData('task_meta',$data_val);
                            $status = SUCCESS;
                            $msg    = "Layer record added successfully.";
                        }

                        endif;
                    }
                    break;
                
                default:
                    $textfile                = $this->post('textfile_1');
                    $textfileId              = $this->post('textfileId_1');
                    $data_val['description']       = $textfile;
                    $data_val['fileType']              = 'TEXT';
                    
                    $isText                          = $this->common_model->is_data_exists('task_meta',array('taskmetaId'=>$textfileId));
                    if($isText){
                        $this->common_model->updateFields('task_meta',$data_val,array('taskmetaId'=>$textfileId));
                        $status = SUCCESS;
                        $msg    = "Layer record updated successfully.";
                    }else{
                        $data_val['taskId']     = $taskId;
                        $this->common_model->insertData('task_meta',$data_val);
                         $status = SUCCESS;
                        $msg    = "Layer record added successfully.";
                    }
                    break;
            }
             $response              = array('status'=>$status,'message'=>$msg);

            }else{
                $response              = array('status'=>FAIL,'message'=>ResponseMessages::getStatusCodeMessage(118));
            }        
        }
        $this->response($response);
    }//end function 




   
    public function list_post(){
        $this->load->helper('text');
        $this->load->model('task_model');
        $this->task_model->set_data();
        $list       = $this->task_model->get_list();
        $data       = array();
        $no         = $_POST['start'];
        foreach ($list as $serData) { 
            $action = '';
            $no++;
            $row    = array();
            $row[]  = $no;
           
           
            $row[]  = display_placeholder_text($serData->name); 
            $row[]      = display_placeholder_text((mb_substr($serData->description, 0,100, 'UTF-8') .((strlen($serData->description) >100) ? '...' : ''))); 
            if($serData->status){
            $row[]  = '<label class="label label-success">'.$serData->statusShow.'</label>';
            }else{ 
            $row[]  = '<label class="label label-danger">'.$serData->statusShow.'</label>'; 
            } 
            $link    = 'javascript:void(0)';
            $action .= "";
             if($serData->status){

                $action .= '<a href="'.$link.'" onclick="confirmAction(this);" data-message="You want to change status!" data-id="'.encoding($serData->taskId).'" data-url="adminapi/tasks/activeInactiveStatus" data-list="1"  class="on-default edit-row table_action" title="Status"><i class="fa fa-check" aria-hidden="true"></i></a>';
            }else{
                $action .= '<a href="'.$link.'" onclick="confirmAction(this);" data-message="You want to change status!" data-id="'.encoding($serData->taskId).'" data-url="adminapi/tasks/activeInactiveStatus" data-list="1"  class="on-default edit-row table_action" title="Status"><i class="fa fa-times" aria-hidden="true"></i></a>';
            }
            $link_url      = base_url().'task-detail/'.encoding($serData->taskId);
            $action .= '&nbsp;&nbsp;|&nbsp;&nbsp;<a href="'.$link_url.'"  class="on-default edit-row table_action" title="Detail"><i class="fa fa-eye"  aria-hidden="true"></i></a>';
            $action .= '&nbsp;&nbsp;|&nbsp;&nbsp;<a href="'.$link.'" onclick="confirmAction(this);" data-message="You want to Delete this record!" data-id="'.encoding($serData->taskId).'" data-url="adminapi/tasks/recordDelete" data-list="1"  class="on-default edit-row table_action" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a>';
            $row[]  = $action;
            $data[] = $row;

        }
        $output = array(
            "draw"              => $_POST['draw'],
            "recordsTotal"      => $this->task_model->count_all(),
            "recordsFiltered"   => $this->task_model->count_filtered(),
            "data"              => $data,
        );
        //output to json format
        $this->response($output);
    }//end function     
       function activeInactiveStatus_post(){
        $id            = decoding($this->post('id'));
        $where              = array('taskId'=>$id);
        $dataExist          = $this->common_model->is_data_exists('tasks',$where);
        if($dataExist){
            $status         = $dataExist->status ? 0:1;
            $dataExist      = $this->common_model->updateFields('tasks',array('status'=>$status),$where);
            $showmsg        = ($status==1)? 'Active' : 'Inactive';
            $response       = array('status'=>SUCCESS,'message'=>$showmsg." ".ResponseMessages::getStatusCodeMessage(128));
        }else{
            $response       = array('status'=>FAIL,'message'=>ResponseMessages::getStatusCodeMessage(118));  
        }
        $this->response($response);
    }//end function
    function recordDelete_post(){
          $id            = decoding($this->post('id'));
        $where              = array('taskId'=>$id);
        $dataExist      = $this->common_model->is_data_exists('tasks',$where);
        if($dataExist){
            $dataExist  = $this->common_model->deleteData('tasks',$where);
            $response   = array('status'=>SUCCESS,'message'=>ResponseMessages::getStatusCodeMessage(124));
        }else{
            $response  = array('status'=>FAIL,'message'=>ResponseMessages::getStatusCodeMessage(118));  
        }
        $this->response($response);
    }//end function
    function recordDeleteMeta_post(){
          $id            = decoding($this->post('id'));
        $where              = array('taskmetaId'=>$id);
        ///pr($where);
        $dataExist      = $this->common_model->is_data_exists('task_meta',$where);
        if($dataExist){
            $dataExist  = $this->common_model->deleteData('task_meta',$where);
            $response   = array('status'=>SUCCESS,'message'=>ResponseMessages::getStatusCodeMessage(124));
        }else{
            $response  = array('status'=>FAIL,'message'=>ResponseMessages::getStatusCodeMessage(118));  
        }
        $this->response($response);
    }//end function
    function recordorderMeta_post(){
          $data            = $this->post();
          pr($data);
        /*$where              = array('taskmetaId'=>$id);
        ///pr($where);
        $dataExist      = $this->common_model->is_data_exists('task_meta',$where);
        if($dataExist){
            $dataExist  = $this->common_model->deleteData('task_meta',$where);
            $response   = array('status'=>SUCCESS,'message'=>ResponseMessages::getStatusCodeMessage(124));
        }else{
            $response  = array('status'=>FAIL,'message'=>ResponseMessages::getStatusCodeMessage(118));  
        }*/
        $this->response($response);
    }//end function
    
    
    // Compress image
    function compressedImage($source, $path, $quality) 
    {

        $info = getimagesize($source);

        if ($info['mime'] == 'image/jpeg') 
            $image = imagecreatefromjpeg($source);

        elseif ($info['mime'] == 'image/gif') 
            $image = imagecreatefromgif($source);

        elseif ($info['mime'] == 'image/png') 
            $image = imagecreatefrompng($source);

        // Save image 
        imagejpeg($image, $path, $quality);
        // sReturn compressed image 
        return $path;

    }//End function
}//End Class 