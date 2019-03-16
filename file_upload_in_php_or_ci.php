/* Uploading document */
// This code is setup for Codeigniter with session created and if you don't created session then just remove the session check code
// Hope it will work fine if not then comment me with your requirment. Hope to help for your problem

// This is a view page where you get message for error or success when upload the file.
// Create one view page with your chooes of page

<div class="to-info">
      <div class="col-md-12">
        <div class="container">
            <div id="msg" style="display:none">
            <!-- <?php echo $error;?> -->
          <?php echo form_open_multipart('Dashboard/upload_doc');?> 
          <!-- <form action="" method="post" enctype="multipart/form-data" accept-charset="utf-8"> -->
            <b>Upload a file to current folder:&nbsp;</b> 
            <input type="file" name="doc" style="padding: 1px 7px;float: left;"> 
            <input type="submit" name="submit" value="Submit" style="background: #6f4a01;color: #fff;border: 0;padding: 4px 10px;">
        </form>
      </div><br/><br/>
    </div>
    </div>
    </div>
// End of View page code


//Controller code for uploading document

public function upload_doc()
  {
    if($this->session->userdata('user') && $this->session->userdata('user_type') == 'super' || $this->session->userdata('user_type') == 'admin') {
      if(!empty($_FILES['doc']['name'])) // doc is input type name="doc" 
      {
        $sales = $this->input->post('sales');
        $backend = $this->input->post('backend');
        $audit = $this->input->post('audit');
        $sub_admin = $this->session->userdata('subType');
        $attachment_file = $_FILES["doc"];
        $output_dir = "uploads/";
        $file = $_FILES["doc"]["name"];
        $file_size = number_format($_FILES["doc"]["size"] / 1048576, 2) . ' MB';
        $randum = date("dmyhis"); //use for add same name data.
        $fileName = $randum.$file;
        $document_path = $output_dir.$fileName;
        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
        $data = array(
                  'file_name' => $fileName,
                  'size' => $file_size,
                  'date_of_modify' => date("d/m/y"),
                  'admin_id' => $this->input->post('user_id'),
                  'sales' => $this->input->post('sales'),
                  'backend' => $this->input->post('backend'),
                  'audit' => $this->input->post('audit')
        );
<!--         var_dump($data);exit(); -->
        $result = $this->model->insertData('document', $data);
        if($result == TRUE) {
          move_uploaded_file($_FILES["doc"]["tmp_name"],$document_path);
          $this->session->set_flashdata('success', 'File uploaded successfully');
          redirect('Dashboard');  
        }else {
          $this->session->set_flashdata('error', 'Something wrong. Try again.');
          redirect('Dashboard');  
        }        
      }else{
        $this->session->set_flashdata('error', 'No attachment. Browse one and try again.');
        $this->index();
      }
    }else{
      $this->session->set_flashdata('warning', 'Something wrong. Try again');
      redirect('Login');
    }
}

//Model code for upload_doc controller
public function insertData($tableName, $array_data)
  {
    try {
      if(isset($tableName) && isset($array_data)) {
        $this->db->trans_start();
        $this->db->insert($tableName, $array_data);
        $globals_id = $this->db->insert_id();
        //print_r($globals_id);exit();
        $this->db->trans_complete();
        return TRUE;
      }else {
        return false;
      }
    } catch (Exception $e) {
        return false;
    }
  }


// For downloading the uploaded folder need this code

//First on view add button with id.
<td><a href="<?php echo base_url();?>Dashboard/download_doc/<?php echo $row['doc_id'];?>"><i class="fa fa-download" aria-hidden="true"></i></a></td>

// Then add this on controller
public function download_doc()
  {
    if($this->session->userdata('user') && $this->session->userdata('user_type') == 'super' || $this->session->userdata('user_type') == 'admin'){
      $doc_id = $this->uri->segment('3');
      $data = array();    
      // $this->load->dbutil();
      // $this->load->helper('file');
      $this->load->helper('download');
      $sql = "SELECT file_name from document where doc_id = $doc_id";
      $data = $this->model->getSqlData($sql);
      $file_name = substr($data[0]['file_name'], 12);
      $file_path = 'uploads/'.$data[0]['file_name'];
      force_download($file_name, file_get_contents($file_path));
    }else{
      $this->session->set_flashdata('warning', 'Something wrong. Try again');
      redirect('Login');
    }    
  }
//Model code for download_doc functon
public function getSqlData($sql)
  {
    $query = $this->db->query($sql);
    if($query->num_rows()>0) {
      $result = $query->result_array();
      // echo "<pre>";print_r($result);echo "<pre>";exit();
      return $result;
    }else {
      return FALSE;
    }
  }
  

// Code for Deleting the uploaded files on server.
// Add on view this button code
<td><a class="delete" href="<?php echo base_url();?>Dashboard/deleteDocument/<?php echo $row['doc_id'];?>" data-confirm="Are you sure to delete this item?"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td>

// Know add the controller code
public function deleteDocument()
  {    
    if($this->session->userdata('user') && $this->session->userdata('user_type') == 'super') {
      $doc_id = $this->uri->segment('3');
      $sql = "SELECT file_name FROM document WHERE doc_id=$doc_id";
      $fileName = $this->model->getSqlData($sql);
      $path = 'uploads/'.$fileName[0]['file_name'];
      if(is_readable($path) && unlink($path)) {
        $sql_doc = $this->model->deleteDoc('document', $doc_id);
        $this->session->set_flashdata('warning', 'Document deleted successfully.');
        redirect('Dashboard');
      }
    }else{
      $this->session->set_flashdata('warning', 'Something wrong. Try again');
      redirect('Login');
    }
  }

//Model code For deleteDocument function of controller used. This code work for when you pass query form your controller to here.
public function getSqlData($sql)
  {
    $query = $this->db->query($sql);
    if($query->num_rows()>0) {
      $result = $query->result_array();
      // echo "<pre>";print_r($result);echo "<pre>";exit();
      return $result;
    }else {
      return FALSE;
    }
  }
  
public function deleteDoc($tableName, $id)
  {
    if(isset($id)) {
      $this->db->trans_start();
      $this->db->where('doc_id', $id);
      $this->db->delete($tableName);
      $this->db->trans_complete();
      if($this->db->affected_rows() > 0) {
        return TRUE;
      }else {
        return FALSE;
      }
    }else {
      return FALSE;
    }
  }
