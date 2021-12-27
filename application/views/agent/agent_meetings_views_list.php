<?php $this->load->view('widgets/meta_tags'); ?>
<body>
<section class="body">
  <?php $this->load->view('widgets/header'); ?>
  <div class="inner-wrapper"> 
	<?php $this->load->view('widgets/left_sidebar'); ?>
    <section role="main" class="content-body"> 
	<?php $this->load->view('widgets/breadcrumbs'); ?>
    <!-- start: page -->
	<?php  
	if($this->session->flashdata('success_msg')){ ?>
		<div class="row">
			<div class="col-lg-12">
			<div class="alert alert-success">
			  <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-times"></i></button>
			  <strong>Success!</strong> <?php echo $this->session->flashdata('success_msg'); ?> </div>
			</div>
		</div>
<?php }   
	 if($this->session->flashdata('error_msg')){ ?>
		<div class="row">
		 <div class="col-lg-12">
			<div class="alert alert-danger">
				<button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-times"></i></button>
			  <strong>Error!</strong> <?php echo $this->session->flashdata('error_msg'); ?> </div>
		   </div>
		 </div>
	<?php } ?>
	<section class="panel">
        <header class="panel-heading">
          <div class="panel-actions"> <a href="#" class="fa fa-caret-down"></a> </div>
          <h2 class="panel-title"><?php echo $page_headings; ?></h2>
        </header>
		 
        <div class="panel-body">  
          <table class="table table-bordered table-striped mb-none" <?php echo (isset($records) && count($records)>0) ? 'id="datatable-default"':''; ?>>
            <thead>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>No. of Meetings</th>
                <th>No. of Views</th>
                <th class="center">Dated </th> 	 
              </tr>
            </thead>
            <tbody>
			<?php 
				$sr=1; 
				if(isset($records) && count($records)>0){
					foreach($records as $record){ ?>
						<tr class="<?php echo ($sr%2==0)?'gradeX':'gradeC'; ?>">
						<td><?= $sr; ?></td>
						<td><?= stripslashes($record->agent_name); ?></td>
						<td><?= stripslashes($record->nos_of_meetings); ?></td>
						<td><?= stripslashes($record->nos_of_views); ?></td>
						<td class="center"><?= date('d-M-Y',strtotime($record->dated)); ?></td>
					  </tr>
				<?php 
					$sr++; 
					}
				}?>	  
            </tbody>
          </table>
        </div>
      </section>
	 
  <!-- end: page -->
  </section>
  </div> 
</section>
<?php $this->load->view('widgets/footer'); ?>
