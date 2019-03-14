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

// This is a controller code 

  public function upload_doc()
  {
    if($this->session->userdata('user') && $this->session->userdata('user_type') == 'super') {
      if(!empty($_FILES['doc']['name'])) // doc is input type name="doc" 
      {
        //Check whether user upload picture
        $attachment_file = $_FILES["doc"];
        $output_dir = "uploads/";
        $fileName = $_FILES["doc"]["name"];
        $document_path = $output_dir.$fileName;
        // print_r($document_path);exit();
        $allowed =  array('*');
        // $allowed =  array('gif','png','jpg','jpeg','zip');
        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
        // $max_filesize = 314572800;   // set max file size
        if(!in_array($ext,$allowed) ) {
          $this->session->set_flashdata('warning', 'Wrong type file choosen. Choose right one.');
          redirect('Dashboard');
          exit();
        } // Code for checking max size of file.
        /*elseif(filesize($_FILES['doc']['tmp_name']) > $min_filesize){
          $this->session->set_flashdata('warning', 'File size is more than 300 MB. Try to reduce size.');
          redirect('Dashboard');
          exit();
        }*/

        move_uploaded_file($_FILES["doc"]["tmp_name"],$document_path);
        $this->session->set_flashdata('success', 'File uploaded successfully');
        redirect('Dashboard');
      }else{
        $this->session->set_flashdata('error', 'No attachment. Browse one and try again.');
        $this->index();
      }
    }else{
      $this->session->set_flashdata('warning', 'Something wrong. Try again');
      redirect('Login');
    }
