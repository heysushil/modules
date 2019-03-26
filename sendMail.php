// For email service in Codeigniter
public function sendMail() {

//Incase of config not work then you also define this to make php.ini configration here.
// ini_set('SMTP', "smtp.rediffmailpro.com");
// ini_set('smtp_port', "25");
// ini_set('sendmail_from', "your email_id");

//Some time every thing ok but email functionality not working on that case that will be helpfull.
// curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$config = array(
      // for gmail setup
      'protocol' => 'smtp',
      'smtp_host' => 'ssl://smtp.googlemail.com',
      'smtp_port' => 465,
      'smtp_user' => 'your_email',
      'smtp_pass' => 'email_password',
      'mailtype' => 'html',
      'charset' => 'utf-8',
      'wordwrap' => TRUE
    );

$this->load->library('email', $config);
// $this->email->initialize($config); //Sometime only load email not work on that case this initialization will help.
$this->email->from('email-id','Hi'); // change it to yours 
$this->email->to('email-id');// change it to yours
$this->email->subject('Resume');
$this->email->message('hi');  
$this->email->set_newline("\r\n");
if($this->email->send())
 {
  echo 'Email sent.';
 }
else
{
 show_error($this->email->print_debugger());
}
}

//Also you can initialize all this config details on Codeigniters default email library just going to application->config->mail.php where you can get all spaces where you can put all the config details and just load the library on your controller and use it like
// Foldable Controller code for Mail

//On your any function you just need to do this
public function register() {
      
      $name = $this->input->post('admin_name');
      $password = $this->input->post('admin_password');
      $team = $this->input->post('sub_admin');
      $data = array(
        'to' => $this->input->post('officil_email'),
        'subject' => 'Congratulations your ftp account created by AG.',
        'message' => 'Your account detail is - <br \><br \>Name - '.$name.'<br />Team - '.$team.'<br \>Email ID - '.$email.'<br \> Password - '.$password.'<br \><br \>'.'In case you need further help. Feel free to contact us.'
      );
      $mailsend = $this->sendg_mail($data);
}

//Mail function
public function sendg_mail($data)
  {
     $this->load->library('email');    
     $this->email->from('email', 'Name'); 
     $this->email->to($data['to']);
     // $this->email->cc('email');
     // $this->email->bcc('email');
     $this->email->set_newline("\r\n");
     $this->email->subject($data['subject']); 
     $this->email->message($data['message']);    
     if($this->email->send()) {
      // $this->session->set_flashdata('success', 'AG | Email sended successfully.');
      // redirect('Dashboard');
      return TRUE;
     }else {
      // show_error($this->email->print_debugger());
      // $this->session->set_flashdata('warning', 'AG | Something wrong. Email not delivered.');
      // redirect('Dashboard');
      return false;
     }
  }
