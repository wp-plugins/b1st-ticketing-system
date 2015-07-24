<?php $this->load->view('common/header'); ?>
       <!--page_title-->
       <div class="page_title">
         <div class="headline">
          <h1><span><i class="fa fa-graduation-cap"></i></span><?php echo $this->lang->line('Knowledge Base Category');?></h1>
         </div>
         <div class="right_panel">
           <a href="<?= TICKET_PLUGIN_URL;?>CI/index.php/kbcat" class="bttn pi-btn btn-no-border"><span class="edit_all"><i class="fa fa-inbox"></i></span><?php echo $this->lang->line('Manage Knowledge Base Categories');?></a>
         </div>
       </div>
       <!--/page_title-->
       <!--main_section-->
       <?php
	$valerror=validation_errors();
	 if(!empty($valerror))
	 {
	  ?>
	  <div class="errorMsg">
	      <?php echo validation_errors(); ?>
	  </div>
	 <?php
	 }
       ?>
       <div class="main_section">
       <!--another_extra_area-->
         <?php $this->load->view('common/ticketpanel');?>
	 
         <!--/another_extra_area-->
         <!--vertical_menu-->
          <!--<div class="left_ver" id="change_bar">
          <span><i class="fa fa-angle-double-right"></i></span>
          </div>-->
         <!--/vertical_menu-->
	 
	 
         <!--product_box-->
         <div class="product_box" id="side_area">
          <div class="headding_bl">
           <p><span><i class="fa fa-th-list"></i></span><?php echo $this->lang->line('Add Knowledge Base Category');?></p>
          </div>
	  
	  <form action="<?= TICKET_PLUGIN_URL;?>CI/index.php/kbcat/insert" method="post">
	  
          <div class="main_pro_pi">
               
               <div class="fileds">
               
		<div class="form_holder">
		  <label><span><?php echo $this->lang->line('Knowledge Base Category Name');?></span></label>
		  <input type="text" name="category_name" placeholder="<?php echo $this->lang->line('Enter');?> <?php echo $this->lang->line('Knowledge Base Category Name');?>" value="<?php echo set_value('category_name');?>">
		</div>
	       
               
               <!--<div class="form_holder">-->
                 <!--<label><span>Text area</span></label>-->
                 <!--<textarea name="" cols="" rows=""></textarea>-->
               <!--</div>-->
               
               <!--<div class="form_holder radio">-->
               <!--  <label><span>Radio</span></label>-->
               <!--  <input name="" type="radio" value=""> Radio-->
               <!--</div>-->
               <!---->
               <!--<div class="form_holder radio">-->
               <!--  <label><span>Radio</span></label>-->
               <!--  <input name="" type="checkbox" value=""> Checkbox-->
               <!--</div>-->
               
               
               <div class="form_holder">
               <button class="sbmt sbmt_base sbmt_base-no-border" type="submit"><i class="fa fa-spinner upload_icon"></i><?php echo $this->lang->line('Add');?></button>
               </div>
               
              </div>
	  
	      </form>
         
              </div>
          </div>
          
         </div>
           
         <!--/product_box-->
         
       
         
       </div>
       <!--/main_section-->
       
    </div>
    
  </div>
</div>
<?php
$this->load->view('common/footer');
?>