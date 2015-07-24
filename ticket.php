<?php
/**
*Plugin Name: B1st.Systems Ticketing
*Description: This provides an easily managed queue of all customer enquiries, organizes them by status, owner, originator, provides a remarkable facility to search post enquiries and run performance and backlog reports.

This removes the "mess" from email and email communications basically become obsolete as all emails converted to tickets and logged into the operator panel for your operators to respond.
*Version: 1.0
*Author: EgyFirst Software, LLC.
    
*/
define('TICKET_PLUGIN_PATH', dirname(__FILE__));
define('TICKET_PLUGIN_URL', plugin_dir_url(__FILE__));



global $jal_db_version;
$jal_db_version = '1.0';

function B1st_jal_install() {
    global $wpdb;
    global $jal_db_version;

    $charset_collate = $wpdb->get_charset_collate();

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
       
        $adminurl = admin_url();

        if ( file_exists( TICKET_PLUGIN_PATH . '/CI/application/config/config.php' ))
        {
              $config_file = file( TICKET_PLUGIN_PATH . '/CI/application/config/config.php' );
              // Not a PHP5-style by-reference foreach, as this file must be parseable by PHP4.
              foreach ( $config_file as $line_num => $line ) {

                if ( ! preg_match( '/^define\(\'([A-Z_]+)\',([ ]+)/', $line, $match ) )
                  continue;

                $constant = $match[1];
                $padding  = $match[2];

                switch ( $constant ) {
                    case 'DBNAME'     :
                 
                      $config_file[ $line_num ] = "define('" . $constant . "'," . $padding . "'".DB_NAME."');\r\n";
                    
                    break;
                       case 'DBUSER'     :
                 
                      $config_file[ $line_num ] = "define('" . $constant . "'," . $padding . "'".DB_USER."');\r\n";
                    
                    break;
                     case 'DBPASSWORD' :
                 
                      $config_file[ $line_num ] = "define('" . $constant . "'," . $padding . "'".DB_PASSWORD."');\r\n";
                    
                    break;
                  case 'DBHOST'     :
                 
                      $config_file[ $line_num ] = "define('" . $constant . "'," . $padding . "'".DB_HOST."');\r\n";
                    
                    break;
                  case 'DBCHARSET'  :
                 
                      $config_file[ $line_num ] = "define('" . $constant . "'," . $padding . "'utf8');\r\n";
                    
                    break;

                   case 'WP_TABLE_PREFIX'  :
                    
                      $config_file[ $line_num ] = "define('" . $constant . "'," . $padding . "'".$wpdb->prefix."');\r\n";
                    
                    break;
                   case 'TABLE_PREFIX'  :
                    
                      $config_file[ $line_num ] = "define('" . $constant . "'," . $padding . "'".$wpdb->prefix."b1st_"."');\r\n";
                    
                    break;

                    case 'DBCOLLATE'  :
                    
                      $config_file[ $line_num ] = "define('" . $constant . "'," . $padding . "'utf8_general_ci');\r\n";
                    
                    break;

                    case 'WPADMINURL'  :
              
                      $config_file[ $line_num ] = "define('" . $constant . "'," . $padding . "'".addcslashes($adminurl, "\\'" )."');\r\n";
                    
                    break;

                   case 'AUTH_KEY'  :
              
                      $config_file[ $line_num ] = "define('" . $constant . "'," . $padding . "'".AUTH_KEY."');\r\n";
                    
                    break;

                   case 'TICKET_PLUGIN_PATH'  :
              
                      $config_file[ $line_num ] = "define('" . $constant . "'," . $padding . "'".TICKET_PLUGIN_PATH."');\r\n";
                    
                    break;

                  case 'TICKET_PLUGIN_URL'  :
              
                      $config_file[ $line_num ] = "define('" . $constant . "'," . $padding . "'".TICKET_PLUGIN_URL."');\r\n";
                    
                    break;

                }
              }


              
                  $path_to_wp_config = TICKET_PLUGIN_PATH . '/CI/application/config/config.php';
                  
                  $handle = fopen( $path_to_wp_config, 'w' );
                  foreach( $config_file as $line ) {
                    fwrite( $handle, $line );
                  }
                  fclose( $handle );
        }
    require_once(TICKET_PLUGIN_PATH.'/tableconfig.php');

    if(!empty($instab))
    {
    	foreach($instab as $sql)
    	{
    	    dbDelta( $sql );
    	}

    }

    add_option( 'jal_db_version', $jal_db_version );

}



register_activation_hook( __FILE__, 'B1st_jal_install' );

add_action('admin_menu','B1st_register_custom_menu_page');

function B1st_register_custom_menu_page(){
    @session_start();
    
    global $wpdb;
    $sql='SELECT * FROM '.$wpdb->prefix.'b1st_moduletables';
    $results = $wpdb->get_results($sql);
    
    if(!empty($results))
    {
	$module_list=array();
	foreach($results as $res)
	{
	    $module_list[$res->name]=$res->status;
	}
    }
    
    if(!empty($_SESSION['privilege_group_id']))
    {
	$privilegegroupid=$_SESSION['privilege_group_id'];
    }
    else
    {
	$privilegegroupid="";
    }
    
    add_menu_page('B1st Systems','B1st Systems','edit_posts','b1st-ticket','B1st_ticket_function',TICKET_PLUGIN_URL.'CI/assets/images/bullseye.png');

    add_submenu_page('b1st-ticket','Ticket','Ticket','edit_posts','b1st-ticket','B1st_ticket_function');
    add_submenu_page('b1st-ticket','Ticket Priority','Ticket Priority','edit_posts','b1st-ticketpriority','B1st_ticketpriority_function');
    //for company condition
    if($module_list['company']==1)
    {
	add_submenu_page('b1st-ticket','Company','Company','edit_posts','b1st-companydet','B1st_company_function');
    }
    
    //for product condition
    if($module_list['product']==1 and $module_list['company']==1)
    {
	add_submenu_page('b1st-ticket','Product','Product','edit_posts','b1st-productdet','B1st_product_function');
    }
    if($module_list['product']==1 and $module_list['company']!=1)
    {
	add_submenu_page('b1st-ticket','Product','Product','edit_posts','b1st-productdet','B1st_product_function');
    }
    
    //for department condition
    if($module_list['company']==1)
    {
	add_submenu_page('b1st-ticket','Department','Department','edit_posts','b1st-departmentdet','B1st_department_function');
    }
    if($module_list['company']!=1 and $module_list['product']==1)
    {
	add_submenu_page('b1st-ticket','Department','Department','edit_posts','b1st-departmentdet','B1st_department_function');
    }
    if($module_list['company']!=1 and $module_list['product']!=1)
    {
	add_submenu_page('b1st-ticket','Department','Department','edit_posts','b1st-departmentdet','B1st_department_function');
    }
    
    if($module_list['knowledge_base_cat']==1 and $module_list['knowledge_base']==1 and $module_list['product'] ==1)
    {
	if(empty($privilegegroupid) or $privilegegroupid==1)
	{
	    add_submenu_page('b1st-ticket','Knowledge Base Category','Knowledge Base Category','edit_posts','b1st-kbcatdet','B1st_kbcat_function');
	}
    }
    if($module_list['knowledge_base']==1 and $module_list['product'] ==1)
    {
	if(empty($privilegegroupid) or $privilegegroupid==1)
	{
	    add_submenu_page('b1st-ticket','Knowledge Base','Knowledge Base','edit_posts','b1st-knowledgebase','B1st_knowledgebase_function');
	}
    }
    if($module_list['faq']==1 and $module_list['product'] ==1)
    {
	add_submenu_page('b1st-ticket','FAQ','FAQ','edit_posts','b1st-faq','B1st_faq_function');
    }
    if(empty($privilegegroupid) or $privilegegroupid==1)
    {
	add_submenu_page('b1st-ticket','Privilege','Privilege','edit_posts','b1st-privilagegroup','B1st_privilagegroup_function');
    }
    add_submenu_page('b1st-ticket','Admin/Clients','Admin/Clients','edit_posts','b1st-users','B1st_user_function');
    if(empty($privilegegroupid) or $privilegegroupid==1)
    {
	add_submenu_page('b1st-ticket','Settings','Settings','edit_posts','b1st-settings','B1st_settings_function');
    }
    if($module_list['email_mod']==1)
    {
	if(empty($privilegegroupid) or $privilegegroupid==1)
	{
	    add_submenu_page('b1st-ticket','Email','Email','edit_posts','b1st-imap','B1st_imap_function');
	}
    }
    if($module_list['twitter']==1)
    {
	if(empty($privilegegroupid) or $privilegegroupid==1)
	{
	    add_submenu_page('b1st-ticket','Twitter','Twitter','edit_posts','b1st-twitter','B1st_twitter_function');
	}
    }
    if($module_list['backup']==1)
    {

	    add_submenu_page('b1st-ticket','Backup','Backup','edit_posts','b1st-backup','B1st_backup_function');

    }
    add_submenu_page('b1st-ticket','Theme','Theme','edit_posts','b1st-theme','B1st_theme_function');
    if($module_list['statistics']==1)
    {
	add_submenu_page('b1st-ticket','Statistics','Statistics','edit_posts','b1st-statistics','B1st_statistics_function');
    }
    add_submenu_page('b1st-ticket','Language','Language','edit_posts','b1st-language','B1st_language_function');
    if(empty($privilegegroupid) or $privilegegroupid==1)
    {
	add_submenu_page('b1st-ticket','Configuration','Configuration','edit_posts','b1st-premium','B1st_premium_function');
    }
}


function B1st_backup_function()
{
    echo '
    <script language="javascript" type="text/javascript">
            function resizeIframe(obj) {
              obj.style.height = obj.contentWindow.document.body.offsetHeight+80 + "px";
            }
          </script>
 <iframe id="mainFrame" style="width:100%;height:100vh;" src="'.TICKET_PLUGIN_URL.'CI/index.php/backup/index" onload="javascript:resizeIframe(this);"></iframe> ';

}

function B1st_settings_function()
{
    echo '<script language="javascript" type="text/javascript">
            function resizeIframe(obj) {
              obj.style.height = obj.contentWindow.document.body.offsetHeight+80 + "px";
            }
          </script>
           <iframe id="mainFrame" style="width:100%;height:100vh;" src="'.TICKET_PLUGIN_URL.'CI/index.php/settings/index" onload="javascript:resizeIframe(this);"></iframe>';   

}

function B1st_ticket_function()
{
    echo '<script language="javascript" type="text/javascript">
            function resizeIframe(obj) {
              obj.style.height = obj.contentWindow.document.body.offsetHeight+80 + "px";
            }
          </script>
           <iframe id="mainFrame" style="width:100%;height:100vh;" src="'.TICKET_PLUGIN_URL.'CI/index.php/ticket/index" onload="javascript:resizeIframe(this);"></iframe>';   
;
}


function B1st_product_function()
{
    echo '<script language="javascript" type="text/javascript">
            function resizeIframe(obj) {
              obj.style.height = obj.contentWindow.document.body.offsetHeight+80 + "px";
            }
          </script> <iframe id="mainFrame" style="width:100%;height:100vh;" src="'.TICKET_PLUGIN_URL.'CI/index.php/product/index" onload="javascript:resizeIframe(this);" ></iframe> ';

}

function B1st_department_function()
{
    echo '<script language="javascript" type="text/javascript">
            function resizeIframe(obj) {
              obj.style.height = obj.contentWindow.document.body.offsetHeight+80 + "px";
            }
          </script> <iframe id="mainFrame" style="width:100%;height:100vh;" src="'.TICKET_PLUGIN_URL.'CI/index.php/department/index" onload="javascript:resizeIframe(this);" ></iframe> ';

}

function B1st_company_function()
{
    echo '<script language="javascript" type="text/javascript">
            function resizeIframe(obj) {
              obj.style.height = obj.contentWindow.document.body.offsetHeight+80 + "px";
            }
          </script> <iframe id="mainFrame" style="width:100%;height:100vh;" src="'.TICKET_PLUGIN_URL.'CI/index.php/company/index" onload="javascript:resizeIframe(this);" ></iframe> ';

}

function B1st_kbcat_function()
{
    echo '<script language="javascript" type="text/javascript">
            function resizeIframe(obj) {
              obj.style.height = obj.contentWindow.document.body.offsetHeight+80 + "px";
            }
          </script> <iframe id="mainFrame" style="width:100%;height:100vh;" src="'.TICKET_PLUGIN_URL.'CI/index.php/kbcat/index" onload="javascript:resizeIframe(this);" ></iframe> ';

}

function B1st_knowledgebase_function()
{
    echo '<script language="javascript" type="text/javascript">
            function resizeIframe(obj) {
              obj.style.height = obj.contentWindow.document.body.offsetHeight+80 + "px";
            }
          </script> <iframe id="mainFrame" style="width:100%;" src="'.TICKET_PLUGIN_URL.'CI/index.php/knowledgebase/index" onload="javascript:resizeIframe(this);" ></iframe> ';

}

function B1st_faq_function()
{
    echo '
    <script language="javascript" type="text/javascript">
            function resizeIframe(obj) {
              obj.style.height = obj.contentWindow.document.body.offsetHeight+80 + "px";
            }
          </script>
 <iframe id="mainFrame" style="width:100%;height:100vh;" src="'.TICKET_PLUGIN_URL.'CI/index.php/faq/index" onload="javascript:resizeIframe(this);"></iframe> ';

}

function B1st_ticketpriority_function()
{
    echo '
    <script language="javascript" type="text/javascript">
            function resizeIframe(obj) {
              obj.style.height = obj.contentWindow.document.body.offsetHeight+80 + "px";
            }
          </script>
 <iframe id="mainFrame" style="width:100%;height:100vh;" src="'.TICKET_PLUGIN_URL.'CI/index.php/ticketpriority/index" onload="javascript:resizeIframe(this);"></iframe> ';

}

function B1st_privilagegroup_function()
{
    echo '<script language="javascript" type="text/javascript">
            function resizeIframe(obj) {
              obj.style.height = obj.contentWindow.document.body.offsetHeight+80 + "px";
            }
          </script>
 <iframe id="mainFrame" style="width:100%;height:100vh;" src="'.TICKET_PLUGIN_URL.'CI/index.php/privilagegroup/index" onload="javascript:resizeIframe(this);"></iframe> ';

}

function B1st_user_function()
{
    echo '<script language="javascript" type="text/javascript">
            function resizeIframe(obj) {
              obj.style.height = obj.contentWindow.document.body.offsetHeight+80 + "px";
            }
          </script>
 <iframe id="mainFrame" style="width:100%;height:100vh;" src="'.TICKET_PLUGIN_URL.'CI/index.php/users/index" onload="javascript:resizeIframe(this);"></iframe> ';

}

function B1st_theme_function()
{
    echo '<script language="javascript" type="text/javascript">
            function resizeIframe(obj) {
              obj.style.height = obj.contentWindow.document.body.offsetHeight+80 + "px";
            }
          </script> <iframe id="mainFrame" style="width:100%;height:100vh;" src="'.TICKET_PLUGIN_URL.'CI/index.php/theme/index" onload="javascript:resizeIframe(this);" ></iframe> ';

}

function B1st_statistics_function()
{
    echo '<script language="javascript" type="text/javascript">
            function resizeIframe(obj) {
              obj.style.height = obj.contentWindow.document.body.offsetHeight+80 + "px";
            }
          </script> <iframe id="mainFrame" style="width:100%;height:100vh;" src="'.TICKET_PLUGIN_URL.'CI/index.php/statistics/index" onload="javascript:resizeIframe(this);" ></iframe> ';

}

function B1st_language_function()
{
    echo '<script language="javascript" type="text/javascript">
            function resizeIframe(obj) {
              obj.style.height = obj.contentWindow.document.body.offsetHeight+80 + "px";
            }
          </script> <iframe id="mainFrame" style="width:100%;height:100vh;" src="'.TICKET_PLUGIN_URL.'CI/index.php/language/index" onload="javascript:resizeIframe(this);" ></iframe> ';

}

function B1st_premium_function()
{
    echo '<script language="javascript" type="text/javascript">
            function resizeIframe(obj) {
              obj.style.height = obj.contentWindow.document.body.offsetHeight+80 + "px";
            }
          </script> <iframe id="mainFrame" style="width:100%;height:100vh;" src="'.TICKET_PLUGIN_URL.'CI/index.php/premium/index" onload="javascript:resizeIframe(this);" ></iframe> ';

}

function B1st_imap_function()
{
    echo '<script language="javascript" type="text/javascript">
            function resizeIframe(obj) {
              obj.style.height = obj.contentWindow.document.body.offsetHeight+80 + "px";
            }
          </script> <iframe id="mainFrame" style="width:100%;height:100vh;" src="'.TICKET_PLUGIN_URL.'CI/index.php/imap/index" onload="javascript:resizeIframe(this);" ></iframe> ';

}

function B1st_twitter_function()
{
    echo '<script language="javascript" type="text/javascript">
            function resizeIframe(obj) {
              obj.style.height = obj.contentWindow.document.body.offsetHeight+80 + "px";
            }
          </script> <iframe id="mainFrame" style="width:100%;height:100vh;" src="'.TICKET_PLUGIN_URL.'CI/index.php/twitter/index" onload="javascript:resizeIframe(this);" ></iframe> ';

}

// Uninstalling tables data & structure on plugin deactivation
function B1st_db_ticket_remove(){
	@session_start();
	unset($_SESSION['userid']);
	unset($_SESSION['email']);
	global $wpdb;
	
	$charset_collate = $wpdb->get_charset_collate();
	 
	require_once(TICKET_PLUGIN_PATH.'/tableconfig.php');
	
        //Delete any options thats stored also?


	$dropsql="DROP TABLE IF EXISTS $table";
	
	if(!empty($droptab))
	{
	    foreach($droptab as $dropsql)
	    {
		$wpdb->query($dropsql);
	    }
	}
	
	$attachmentpath= TICKET_PLUGIN_PATH.'/CI/assets/attachments/';
	$files = glob($attachmentpath.'*'); 
	foreach($files as $file)
	{ 
	  if(is_file($file))
	  {
	    unlink($file); 
	  }
	}
	session_destroy();
}
	
register_deactivation_hook(__FILE__, 'B1st_db_ticket_remove' );

function B1st_showtable()
{
	$url = TICKET_PLUGIN_URL;
  $r = <<<HTML
<script language="javascript" type="text/javascript">
            function resizeIframe(obj) {
              obj.style.height = obj.contentWindow.document.body.offsetHeight+80 + "px";
            }
			
          </script>
          <style>          
				#iframe{width:625px;}
				
				@media screen and (max-width: 900px) {
					#iframe{width:410px;} 
				}
				
				@media screen and (max-width: 460px) {
					#iframe{width:300px;
					        margin:0 auto;
							display:table;
							} 
				}
          </style>
		  
<iframe style="height:100vh;" src="$url/CI/index.php/register/postTicket" frameborder="0" scrolling="no" id="iframe" onload="javascript:resizeIframe(this);"></iframe> 

HTML;
  return $r;
}

function B1st_knowledgebase()
{
  $url = TICKET_PLUGIN_URL;
  $r = <<<HTML
<script language="javascript" type="text/javascript">
            function resizeIframe(obj) {
              obj.style.height = obj.contentWindow.document.body.offsetHeight+80 + "px";

              obj.contentWindow.document.getElementsByClassName('nav_all')[0].style.display = "none";

              console.log(obj.contentWindow.document.getElementsByClassName('nav_all')[0].style.display);
              
            }
  
          </script>
          <style>          
        #iframe{width:625px;}
       
        @media screen and (max-width: 900px) {
          #iframe{width:410px;} 
        }
        
        @media screen and (max-width: 460px) {
          #iframe{width:300px;
                  margin:0 auto;
              display:table;
              } 
        }

          </style>
      
<iframe style="height:100vh;" src="$url/CI/index.php/register/knowledge_base" frameborder="0" scrolling="no" id="iframe" onload="javascript:resizeIframe(this);"></iframe> 


HTML;
  return $r;
}

function B1st_faq($atts)
{

 $url = TICKET_PLUGIN_URL.'/CI/index.php/register/faq';

 extract(shortcode_atts(
    array(
      'product' => ''
    ), $atts, 'faq' ));

$product = trim($product);
if(!empty($product))
{
  $p = base64_encode($product);
  $url .= '/'.urlencode($p);
} 

 
  $r = <<<HTML
<script language="javascript" type="text/javascript">
            function resizeIframe(obj) {
              obj.style.height = obj.contentWindow.document.body.offsetHeight+80 + "px";

              obj.contentWindow.document.getElementsByClassName('nav_all')[0].style.display = "none";

              console.log(obj.contentWindow.document.getElementsByClassName('nav_all')[0].style.display);
              
            }
  
          </script>
          <style>          
        #iframe{width:625px;}
       
        @media screen and (max-width: 900px) {
          #iframe{width:410px;} 
        }
        
        @media screen and (max-width: 460px) {
          #iframe{width:300px;
                  margin:0 auto;
              display:table;
              } 
        }

          </style>
      
<iframe style="height:100vh;" src="$url" frameborder="0" scrolling="no" id="iframe" onload="javascript:resizeIframe(this);"></iframe> 


HTML;
  return $r;
}



add_shortcode('B1st.Systems Ticketing','B1st_showtable');
add_shortcode('B1st.Systems KB','B1st_knowledgebase');
add_shortcode('B1st.SystemsFAQ','B1st_faq');
?>
