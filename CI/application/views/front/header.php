<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>>B1st Ticketing System</title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<!-- <link href="<?= TICKET_PLUGIN_URL;?>CI/assets/css/style.css" rel="stylesheet" type="text/css" /> -->
<?php
    $theme=B1st_getFrontTheme();
   // echo "<pre>";
    //print_r($theme);
   // echo "</pre>";
  if(!empty($theme)){
    $themecolor=$theme->theme_name;
  }
else
{
$theme = '';
}
    ?>
    <?php
    if(!empty($themecolor))
    {
    ?>
    <link href="<?= TICKET_PLUGIN_URL;?>CI/assets/css/<?php echo $themecolor;?>front_style.css" rel="stylesheet" type="text/css" />
    <?php
    }
    else
    {
    ?>
    <link href="<?= TICKET_PLUGIN_URL;?>CI/assets/css/front_style.css" rel="stylesheet" type="text/css" />
    <?php
    }
    ?>
<script type="text/javascript" src="<?= TICKET_PLUGIN_URL;?>CI/assets/js/jquery1.6.2.min.js"></script>
<script type="text/javascript" src="<?= TICKET_PLUGIN_URL;?>CI/assets/js/jquery.min.js"></script>
<link href="<?= TICKET_PLUGIN_URL;?>CI/assets/css/responsive.css" rel="stylesheet" type="text/css" />

<link href="<?= TICKET_PLUGIN_URL;?>CI/assets/css/front_responsive.css" rel="stylesheet" type="text/css" />

<link href="<?= TICKET_PLUGIN_URL;?>CI/assets/css/google-font.css" rel="stylesheet" type="text/css" />
<link href="<?= TICKET_PLUGIN_URL;?>CI/assets/font-awesome-4.3.0/css/font-awesome.css" rel="stylesheet" type="text/css" />
<link href="<?= TICKET_PLUGIN_URL;?>CI/assets/font-awesome-4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="<?= TICKET_PLUGIN_URL;?>CI/assets/css/jRating.jquery.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?= TICKET_PLUGIN_URL;?>CI/assets/js/jRating.jquery.js"></script>
<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>-->
<script type="text/javascript">
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
</script>
</head>


<body>
<div id="pi-all">
<!--navigation-->
             <div class="nav_all">             
               
                     <div class="navigation"><i class="fa fa-bars"></i></div>             
               
               <nav> 
                  <ul>
                    <li class="bar_Side bar_side"><a href="<?php echo TICKET_PLUGIN_URL;?>CI/index.php/register/ListTicket" ><span><i class="fa fa-ticket"></i></span><?php echo $this->lang->line('Ticket');?><br/></a></li>
                    <li><a href="<?php echo TICKET_PLUGIN_URL;?>CI/index.php/register/postTicket"><span><i class="fa fa-users"></i></span><?php echo $this->lang->line('Post Ticket');?></a>
                    </li> 
                    <!-- <li><a href="services.html"><span><i class="fa fa-minus-square"></i></span>Divisions</a>
                        </li>
                        <li><a href="quote.html"><span><i class="fa fa-envelope-o"></i></span>Emails
                        </a> 
                        </li> -->    
<!--                     <li><a href="<?php echo TICKET_PLUGIN_URL;?>CI/index.php/faq/index"><span><i class="fa fa-question-circle"></i></span>Faqs</a></li>
<li><a href="<?php echo TICKET_PLUGIN_URL;?>CI/index.php/settings/index"><span><i class="fa fa-cog"></i></span>Settings</a></li>
 <li><a href="<?php echo TICKET_PLUGIN_URL;?>CI/index.php/backup/index"><span><i class="fa fa-database"></i></span>Backup</a></li>
         <li><a href="<?php echo TICKET_PLUGIN_URL;?>CI/index.php/statistics/index"><span><i class="fa fa-fax"></i></span>Statistics</a></li> -->
                      <?php
                      $kbcat=B1st_fetchmod('knowledge_base_cat');
                      if($kbcat==1)
                      {
                      ?>
                     <li><a href="<?= TICKET_PLUGIN_URL ?>CI/index.php/register/knowledge_base"><span><i class="fa fa-graduation-cap"></i></span><?php echo $this->lang->line('Knowledge Base');?></a></li>
                     <?php
                      }
                      $faq=B1st_fetchmod('faq');
                      if($faq==1)
                      {
                      ?>
                    <li><a href="<?= TICKET_PLUGIN_URL ?>CI/index.php/register/faq"><span><i class="fa fa-question-circle"></i></span><?php echo $this->lang->line('FAQ');?></a></li>
                    <?php
                      }
                      ?>
                     <li><a href="<?= TICKET_PLUGIN_URL ?>CI/index.php/register/logout"><span><i class="fa fa-sign-out"></i></span><?php echo $this->lang->line('Logout');?></a></li>
                  </ul>
                </nav>
             </div>
           <!--navigation-->
  <div class="main_wrpper">
  
  <script type="text/javascript">

	function getsize(){
		if($(window).width()<411)
	{
		$('.navigation').css({'display':'block'});
		$('nav').hide();
	}
   else
   {
	   $('.navigation').css({'display':'none'});
         $('nav').show();
   }
}
getsize(); 
$(window).resize(function(){ getsize() });
   
   
$(document).ready(function() {
	$(".navigation").click(function() {
		$("nav").slideToggle();
	});
	
}); 
</script> 