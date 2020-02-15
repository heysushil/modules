// In this case I'm using form_validation which I'm going to define in config folder

//create file in application->config->form_validtion.php

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config = array(
			'admissionFormValidation' => array(
				array(
					'field' => 'admissionNo',
					'label' => 'Admission Number',
					'rules' => 'required|min_length[6]|max_length[18]|numeric|is_unique[students.admissionNo]',
					'errors' => array(
						'is_unique' => 'This %s is already exists.'
					)
				),
				array(
					'field' => 'rollNo',
					'label' => 'Roll Number',
					'rules' => 'required|max_length[16]|is_unique[students.rollNo]',
					'errors' => array(
						'is_unique' => 'This %s is already alloted to student. Try another number.'
					)
				)
);

//--------After defining validation rule go into controller----------
// In this controller create on function which have if else in whihc call the form_validation which also must to include in constructer
// at top to use it here or auto load it.	

public function studentRegistrationFormData()
	{
		if($this->form_validation->run('admissionFormValidation') == FALSE){
			$errors = validation_errors();
			$res['error'] = $errors; 
			echo json_encode($res);
			// echo json_encode(['error'=>$errors]);
		}else{
      $test = 'done';
      $res['success'] = $test; 
			echo json_encode($res);
    }
   }
   
//------For ajax response---------
// In this example pass the from value by ajax so here is the js code to pass the html form data to contreller at once.
// also after getting json response from controller show the success or error message on html page by the bootstrap alert.
// html alert div define at last in this page
	
$('#submit').submit(function(e){
        e.preventDefault(); 
         $.ajax({
             url: base_url + 'Student/studentRegistrationFormData/',
             type:"post",
             dataType: 'json',
             data:new FormData(this),
             processData:false,
             contentType:false,
             cache:false,
             async:false,
            success: function(data){
                // alert(data.success);
                console.log(data);
                if($.isEmptyObject(data.error)){
                    $(".print-error-msg").css('display','none');
                    $('.print-success-msg').css('display','block');
                    window.location.href = base_url+data.redirect;
                }else{
                    $(".print-error-msg").css('display','block');
                    $(".print-error-msg").html(data.error);
                }
            }
         });
    });
    
//-----------html code-----------------------
//In for showing the error and success message on html page add this div

<div class="alert alert-success print-success-msg" style="display:none;width: 100%;"></div>
<div class="alert alert-danger print-error-msg" style="display:none;width: 100%;"></div>

