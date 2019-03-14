// This is code for using flash data on codeigniter
// This is very easy to use and just adding all messages on footer. It make easy to just add your message on controllers methods. No need to create exta php code in view file for showing the code.
// It's working and if any one have more shorter than this than welcome to explore this to make it more convenient and easy.
//version = 1.0.0

On Controller after creating session and don't forget to load session and url library.

$this->session->set_flashdata('warning', 'Oops. This email id already exist.' );

And on footer.php in view past this scrit code

<!-- Code for flashdata toaster -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
<script type="text/javascript">
	<?php if($this->session->flashdata('success')){ ?>
	    toastr.success("<?php echo $this->session->flashdata('success'); ?>");
	<?php }else if($this->session->flashdata('error')){  ?>
	    toastr.error("<?php echo $this->session->flashdata('error'); ?>");
	<?php }else if($this->session->flashdata('warning')){  ?>
	    toastr.warning("<?php echo $this->session->flashdata('warning'); ?>");
	<?php }else if($this->session->flashdata('info')){  ?>
	    toastr.info("<?php echo $this->session->flashdata('info'); ?>");
	<?php } ?>
</script>
<!-- End of flashdata script -->
