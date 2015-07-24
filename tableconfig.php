<?php

$table1 = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."b1st_ticket (
 id bigint(25) NOT NULL AUTO_INCREMENT,
 ticket_no varchar(255) NOT NULL,
 userid bigint(25) NOT NULL ,
 subject varchar(255) NOT NULL,
 customer varchar(255) NOT NULL,
 query text NOT NULL,
 department_id bigint(25) NOT NULL,
 company_id bigint(25) NOT NULL,
 product_id bigint(25) NOT NULL,
 priorty varchar(255) NOT NULL,
 state varchar(10) NOT NULL DEFAULT 'O',
 rating int(1) NOT NULL DEFAULT '0',
 email_no bigint(25) NULL,
 tweet_id bigint(25) NULL,
 spam int(1) NULL,
 status enum('1','0') NOT NULL DEFAULT '1',
 create_date datetime NOT NULL,
 modified_date datetime NOT NULL,
 PRIMARY KEY (id)
) $charset_collate;";

$table2 = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."b1st_product (
  id bigint(25) NOT NULL AUTO_INCREMENT,
  product_name varchar(255) NOT NULL,
  status enum('1','0') NOT NULL DEFAULT '1',
  create_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) $charset_collate;";

$table3 = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."b1st_department (
  id bigint(25) NOT NULL AUTO_INCREMENT,
  department_name varchar(255) NOT NULL,
  status enum('1','0') NOT NULL DEFAULT '1',
  create_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) $charset_collate;";

$table4 = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."b1st_company (
  id bigint(25) NOT NULL AUTO_INCREMENT,
  company_name varchar(255) NOT NULL,
  company_website varchar(255) NOT NULL,
  status enum('1','0') NOT NULL DEFAULT '1',
  create_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) $charset_collate;";

$table5 = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."b1st_faq (
  id bigint(25) NOT NULL AUTO_INCREMENT,
  product_id bigint(25) NOT NULL,
  question varchar(255) NOT NULL,
  answer text NOT NULL,
  status enum('1','0') NOT NULL DEFAULT '1',
  create_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) $charset_collate;";

$table6 = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."b1st_ticket_priority (
  id bigint(25) NOT NULL AUTO_INCREMENT,
  priority_name varchar(255) NOT NULL,
  priority_color varchar(10) NOT NULL,
  status enum('1','0') NOT NULL DEFAULT '1',
  create_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) $charset_collate;";

$table7 = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."b1st_privilege_group (
  id bigint(25) NOT NULL AUTO_INCREMENT,
  privilege_name varchar(255) NOT NULL,
  privileges text NOT NULL,
  description text NOT NULL,
  status enum('1','0') NOT NULL DEFAULT '1',
  create_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) $charset_collate;

INSERT INTO ".$wpdb->prefix."b1st_privilege_group (id,privilege_name, privileges, description, status, create_date) VALUES (NULL, 'Super Admin', '[\"AT\",\"DT\",\"CT\",\"ET\",\"ATTA\",\"TTAA\",\"RT\",\"RAT\",\"AAT\"]', 'Super Admin privilege with all the possible privileges in the application', '1', CURRENT_TIMESTAMP);

";


$table8 = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."b1st_privileges (
  id bigint(25) NOT NULL AUTO_INCREMENT,
  code varchar(255) NOT NULL,
  name varchar(255) NOT NULL,
  status enum('1','0') NOT NULL DEFAULT '1',
  create_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) $charset_collate;
INSERT INTO ".$wpdb->prefix."b1st_privileges (id, code, name, status,create_date) VALUES (NULL, 'AT', 'Add Ticket', '1', CURRENT_DATE()), (NULL, 'DT', 'Delete Ticket', '1', CURRENT_DATE()), (NULL, 'CT', 'Close Ticket', '1', CURRENT_DATE()), (NULL, 'ET', 'Edit Ticket', '1', CURRENT_DATE()), (NULL, 'ATTA', 'Assign ticket to Admin', '1', CURRENT_DATE()), (NULL, 'TTAA', 'Transfer ticket from one Admin to another Admin', '1', CURRENT_DATE()), (NULL, 'RT', 'Reopen Tickets', '1', CURRENT_DATE()), (NULL, 'RAT', 'Read all Tickets', '1', CURRENT_DATE()), (NULL, 'AAT', 'Answer any tickets', '1', CURRENT_DATE());
";


$table9 = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."b1st_ticket_reply (
  id bigint(25) NOT NULL AUTO_INCREMENT,
  ticket_id bigint(25) NOT NULL,
  body text NOT NULL,
  replier_id bigint(25) NOT NULL,
  replier varchar(255) NOT NULL,
  date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) $charset_collate;";

$table10 = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."b1st_ticket_states (
  id bigint(25) NOT NULL AUTO_INCREMENT,
  code varchar(20) NOT NULL,
  name varchar(255) NOT NULL,
  status enum('1','0') NOT NULL DEFAULT '1',
  creation_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) $charset_collate;

INSERT INTO ".$wpdb->prefix."b1st_ticket_states (id, code, name, status, creation_date) VALUES (NULL, 'O', 'open', '1', CURRENT_TIMESTAMP), (NULL, 'C', 'close', '1', CURRENT_TIMESTAMP), (NULL, 'P', 'pending', '1', CURRENT_TIMESTAMP), (NULL, 'S', 'spam', '1', CURRENT_TIMESTAMP), (NULL, 'RO', 're-opened', '1', CURRENT_TIMESTAMP),(NULL, 'A', 'answered', '1', CURRENT_TIMESTAMP);
";

$table11 = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."b1st_ticket_users (
  id bigint(25) NOT NULL AUTO_INCREMENT,
  firstname varchar(255) NOT NULL,
  lastname varchar(255) NOT NULL,
  username varchar(255) NOT NULL,
  email varchar(255) NOT NULL,
  mobile varchar(30) NULL,
  password varchar(255) NOT NULL,
  admin varchar(255) NOT NULL DEFAULT '0',
  privilege_group_id varchar(255) DEFAULT NULL,
  responder_time_duration varchar(255) DEFAULT NULL,
  hash varchar(255) DEFAULT NULL,
  type varchar(255) DEFAULT NULL,
  online_status enum('1','0') NOT NULL DEFAULT '0' COMMENT 'Offline=0, Online=1',
  status enum('1','0') NOT NULL DEFAULT '1',
  creation_date datetime NOT NULL,
  modified_date datetime NOT NULL,
  PRIMARY KEY (id)
) $charset_collate;

INSERT INTO ".$wpdb->prefix."b1st_ticket_users (id,firstname,lastname,username,email,mobile,password,admin,privilege_group_id,responder_time_duration,hash,type,status,creation_date,modified_date) VALUES (NULL, 'Admin', 'Admin', 'admin', 'admin@admin.com', NULL,'1-6-K-2-5-K-7-8-A-7-9-C-6-1-1-M-2-8-L-7-8-G-9-8', '1','1', NULL, NULL, NULL, '1', NOW(), NOW());

INSERT INTO ".$wpdb->prefix."b1st_ticket_users (id, firstname, lastname, username, email, mobile, password, admin, privilege_group_id, responder_time_duration, hash, type, online_status, status, creation_date, modified_date) VALUES
(NULL, 'test', 'test', 'test', 'test@b1st.systems', '', '1-6-H-1-6-I-5-6-R-0-0-1-K-2-2-1-J-6-8-G-1-7-G-0-0-1', '0', '', NULL, NULL, 'ticket_posting', '0', '1', NOW(), NOW());
";


$table12 = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."b1st_settings (
  id bigint(25) NOT NULL AUTO_INCREMENT,
  name varchar(255) NOT NULL,
  value text NOT NULL,
  PRIMARY KEY (id)
) $charset_collate;

INSERT INTO ".$wpdb->prefix."b1st_settings (id, name, value) VALUES (NULL, 'adminemail', '{\"email\":\"admin@admin.com\"} ');
INSERT INTO ".$wpdb->prefix."b1st_settings (id, name, value) VALUES (NULL, 'tsemail', '{\"email\":\"b1st@b1st.systems\"} ');
INSERT INTO ".$wpdb->prefix."b1st_settings (id, name, value) VALUES (NULL, 'imapsetting', '{\"subject\":\"test\",\"login\":\"example@gmail.com\",\"pass\":\"your password\",\"host\":\"imap.gmail.com\",\"port\":\"993\",\"service_flags\":\"/imap/ssl/novalidate-cert\",\"mailbox\":\"[Gmail]/All Mail\",\"client\":\"gmail\"} ');

INSERT INTO ".$wpdb->prefix."b1st_settings (id, name, value) VALUES (NULL, 'ticket_attachment', '{\"extensions_allowed\":\"pdf,jpg,png,gif\",\"max_upload\":5} ');

INSERT INTO ".$wpdb->prefix."b1st_settings (id, name, value) VALUES (NULL, 'mobile_verification', '{\"app_id\":\"70b4b38655c94073b572e17\",\"access_token\":\"30c06747da7f649709c068ad931a275151e68e5e\",\"type\":\"2\"} ');

INSERT INTO ".$wpdb->prefix."b1st_settings (id, name, value) VALUES (NULL, 'reCAPTCHA', '{\"theme\":\"light\",\"language\":\"en\",\"sitekey\":\"6LdyqAQTAAAAAPQ-qjbTMvcFJp2xjHZ9pZsGmyM8\",\"type\":\"2\"} ');

INSERT INTO ".$wpdb->prefix."b1st_settings (id, name, value) VALUES (NULL, 'ticket_auto_close', '{\"number\":1,\"type\":\"day\",\"val\":\"1 day\"} ');

INSERT INTO ".$wpdb->prefix."b1st_settings (id, name, value) VALUES (NULL, 'scheduled_backup', '{\"number\":7,\"type\":\"day\",\"set_date\":\"".date('Y-m-d')."\"} ');

INSERT INTO ".$wpdb->prefix."b1st_settings (id, name, value) VALUES (NULL, 'register', '{\"active\":\"ticket_posting\"} ');

INSERT INTO ".$wpdb->prefix."b1st_settings (id, name, value) VALUES (NULL, 'pagination', '{\"active\":\"10\"} ');

INSERT INTO ".$wpdb->prefix."b1st_settings (id, name, value) VALUES (NULL, 'ticket_time', '{\"type\":\"1\"} ');

INSERT INTO ".$wpdb->prefix."b1st_settings (id, name, value) VALUES (NULL, 'delete_confirmation', '{\"type\":\"1\"} ');

INSERT INTO ".$wpdb->prefix."b1st_settings (id, name, value) VALUES (NULL, 'auto_responder', '{\"type\":\"1\"} ');

INSERT INTO ".$wpdb->prefix."b1st_settings (id, name, value) VALUES (NULL, 'akismet', '{\"api_key\":\"3e8237c022f0\"} ');

INSERT INTO ".$wpdb->prefix."b1st_settings (id, name, value) VALUES (NULL, 'opswat', '{\"api_key\":\"f805c9756059bd33725bfb97124b30ef\"} ');

INSERT INTO ".$wpdb->prefix."b1st_settings (id, name, value) VALUES (NULL, 'response_time', '{\"number\":\"5\",\"unit\":\"hour\"} ');

INSERT INTO ".$wpdb->prefix."b1st_settings (id, name, value) VALUES (NULL, 'twitter', '{\"oauth_access_token\":\"125841131-a9U29PXDXQZxrp6vCPVoAcJPalfWwV535pn1YJ1e\",\"oauth_access_token_secret\":\"C2yN21k72jEVYtcy5A1WJoQrFYMFcKUHoEaBM5NJniy0u\",\"consumer_key\":\"iqmD6uwJCanx9ACwAYyKwtfAE\",\"consumer_secret\":\"ykWXDU7Os71QSvuzs3h6Cz1YB6q4YR7uswJWi9PG4Mda0oq0Wo\",\"screen_name\":\"your username\",\"count\":\"5\"} ');

INSERT INTO ".$wpdb->prefix."b1st_settings (id, name, value) VALUES (NULL, 'email_verification', '{\"type\":\"2\"} ');

";

$table13 = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."b1st_attachments (
  id bigint(25) NOT NULL AUTO_INCREMENT,
  ticket_id bigint(25) NOT NULL,
  filename varchar(255) NOT NULL,
  PRIMARY KEY (id)
) $charset_collate;";

$table14 = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."b1st_temp_file (
  id bigint(25) NOT NULL AUTO_INCREMENT,
  filename varchar(255) NOT NULL,
  session_id text NOT NULL,
  PRIMARY KEY (id)
) $charset_collate;";

$table15 = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."b1st_theme (
  id bigint(25) NOT NULL AUTO_INCREMENT,
  theme_name varchar(255) NOT NULL,
  theme_color varchar(10) NOT NULL,
  set_default enum('1','0') NOT NULL DEFAULT '0',
  front_set_default enum('1','0') NOT NULL DEFAULT '0',
  status enum('1','0') NOT NULL DEFAULT '1',
  create_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) $charset_collate;


INSERT INTO ".$wpdb->prefix."b1st_theme (theme_name,theme_color,set_default,front_set_default,status,create_date) VALUES
('Default', '#da4c4c', '0', '0', '1', '2015-04-16 11:22:29'),
('Red', '#ff0000', '0', '0', '1', '2015-04-16 11:22:29'),
('Blue', '#0000ff', '0', '0', '1', '2015-04-16 11:22:45'),
('Green', '#00ff00', '0', '0', '1', '2015-04-16 11:23:22'),
('Orange', '#ff8c00', '0', '0', '1', '2015-04-16 11:23:38'),
('Grey', '#828282', '0', '0', '1', '2015-04-16 11:23:51'),
('Dark', '#333333', '0', '0', '1', '2015-04-16 11:24:13'),
('Light', '#ededed', '0', '0', '1', '2015-04-16 11:24:51');

";

$table16 = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."b1st_ticket_register_types (
  id int(11) NOT NULL AUTO_INCREMENT,
  type varchar(255) NOT NULL,
  PRIMARY KEY (id)
) $charset_collate;

INSERT INTO ".$wpdb->prefix."b1st_ticket_register_types (id, type) VALUES
(NULL,'ticket_posting'),
(NULL,'read_reply'),
(NULL,'register');";

$table17 = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."b1st_ticket_rating (
  id bigint(25) NOT NULL AUTO_INCREMENT,
  ticket_id bigint(25) NOT NULL,
  user_id bigint(25) NOT NULL,
  rating tinyint(1) NOT NULL,
  dateAdded timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) $charset_collate;";

$table18 = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."b1st_chatsession (
  id bigint(25) NOT NULL AUTO_INCREMENT,
  to_userid bigint(25) NOT NULL,
  from_userid bigint(25) NOT NULL,
  seen enum('1','0') NOT NULL DEFAULT '0' COMMENT 'seen=1, unseen=0',
  chat text NOT NULL,
  create_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) $charset_collate;";

$table19 = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."b1st_kb_cat (
  id bigint(25) NOT NULL AUTO_INCREMENT,
  category_name varchar(255) NOT NULL,
  status enum('1','0') NOT NULL DEFAULT '1',
  create_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) $charset_collate;";

$table20 = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."b1st_knowledgebasemod (
  id bigint(25) NOT NULL AUTO_INCREMENT,
  category_id bigint(25) NOT NULL,
  product_id bigint(25) NOT NULL,
  topic varchar(255) NOT NULL,
  content text NOT NULL,
  status enum('1','0') NOT NULL DEFAULT '1',
  create_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) $charset_collate;";


$table21 = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."b1st_language (
  id bigint(25) NOT NULL AUTO_INCREMENT,
  language_name varchar(255) NOT NULL,
  language_code varchar(255) NOT NULL,
  default_status enum('1','0') NOT NULL,
  back_default_status enum('1','0') NOT NULL DEFAULT '0',
  PRIMARY KEY (id)
) $charset_collate;

INSERT INTO ".$wpdb->prefix."b1st_language (language_name, language_code, default_status,back_default_status) VALUES
('English', 'eng', '1','1'),
('French', 'fra', '0', '0'),
('German', 'ger', '0', '0'),
('Spanish', 'spa', '0', '0'),
('Arabic', 'ara', '0', '0'),
('Indian', 'hin', '0', '0');";

$table22 = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."b1st_admin_ticket_assignment (
  id bigint(25) NOT NULL AUTO_INCREMENT,
  admin_id bigint(25) NOT NULL,
  ticket_id bigint(25) NOT NULL,
  PRIMARY KEY (id)
) $charset_collate;";

$table23 = "CREATE TABLE ".$wpdb->prefix."b1st_ticket_backup (
  id bigint(25) NOT NULL AUTO_INCREMENT,
  backup_name varchar(255) NOT NULL,
  backup_description text  NULL,
  backup_type varchar(255) NOT NULL,
  creation_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) $charset_collate;";

$table24 = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."b1st_moduletables (
  id bigint(25) NOT NULL AUTO_INCREMENT,
  name varchar(255) NOT NULL,
  status enum('1','0') NOT NULL DEFAULT '0',
  install_status enum('1','0') NOT NULL DEFAULT '0',
  PRIMARY KEY (id)
) $charset_collate;

INSERT INTO ".$wpdb->prefix."b1st_moduletables (name, status, install_status) VALUES
('faq', '0', '0'),
('knowledge_base_cat', '0', '0'),
('knowledge_base', '0', '0'),
('backup', '0', '0'),
('chat', '0', '0'),
('response_time', '0', '0'),
('rating', '0', '0'),
('opswat', '0', '0'),
('akismet', '0', '0'),
('email_mod', '0', '0'),
('twitter', '0', '0'),
('mob_ver', '0', '0'),
('statistics', '0', '0'),
('company', '0', '0'),
('product', '0', '0');";

$table25 = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."b1st_emails (
  id bigint(20) NOT NULL AUTO_INCREMENT,
  eid bigint(20) NOT NULL,
  subject varchar(255) NOT NULL,
  body text NOT NULL,
  deleted int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (id)
)$charset_collate;";

$table26 = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."b1st_tweets (
  id bigint(20) NOT NULL AUTO_INCREMENT,
  tid bigint(20) NOT NULL,
  body text NOT NULL,
  deleted tinyint(4) DEFAULT '0',
  PRIMARY KEY (id)
)$charset_collate;";

$table27 = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."b1st_responder_time_duration (
  id bigint(25) NOT NULL AUTO_INCREMENT,
  userid bigint(25) NOT NULL,
  responder_time_duration varchar(255) NOT NULL,
  currentdate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
)$charset_collate;";

$droptable1="DROP TABLE IF EXISTS ".$wpdb->prefix."b1st_ticket";

$droptable2="DROP TABLE IF EXISTS ".$wpdb->prefix."b1st_product";

$droptable3="DROP TABLE IF EXISTS ".$wpdb->prefix."b1st_department";

$droptable4="DROP TABLE IF EXISTS ".$wpdb->prefix."b1st_company";

$droptable5="DROP TABLE IF EXISTS ".$wpdb->prefix."b1st_faq";

$droptable6="DROP TABLE IF EXISTS ".$wpdb->prefix."b1st_ticket_priority";

$droptable7="DROP TABLE IF EXISTS ".$wpdb->prefix."b1st_privilege_group";

$droptable8="DROP TABLE IF EXISTS ".$wpdb->prefix."b1st_privileges";

$droptable9="DROP TABLE IF EXISTS ".$wpdb->prefix."b1st_ticket_reply";

$droptable10="DROP TABLE IF EXISTS ".$wpdb->prefix."b1st_ticket_states";

$droptable11="DROP TABLE IF EXISTS ".$wpdb->prefix."b1st_ticket_users";

$droptable12="DROP TABLE IF EXISTS ".$wpdb->prefix."b1st_settings";

$droptable13="DROP TABLE IF EXISTS ".$wpdb->prefix."b1st_attachments";

$droptable14="DROP TABLE IF EXISTS ".$wpdb->prefix."b1st_temp_file";

$droptable15="DROP TABLE IF EXISTS ".$wpdb->prefix."b1st_theme";

$droptable16="DROP TABLE IF EXISTS ".$wpdb->prefix."b1st_ticket_register_types";

$droptable17="DROP TABLE IF EXISTS ".$wpdb->prefix."b1st_ticket_rating";

$droptable18="DROP TABLE IF EXISTS ".$wpdb->prefix."b1st_chatsession";

$droptable19="DROP TABLE IF EXISTS ".$wpdb->prefix."b1st_kb_cat";

$droptable20="DROP TABLE IF EXISTS ".$wpdb->prefix."b1st_knowledgebasemod";

$droptable21="DROP TABLE IF EXISTS ".$wpdb->prefix."b1st_language";

$droptable22="DROP TABLE IF EXISTS ".$wpdb->prefix."b1st_admin_ticket_assignment";

$droptable23="DROP TABLE IF EXISTS ".$wpdb->prefix."b1st_ticket_backup";

$droptable24="DROP TABLE IF EXISTS ".$wpdb->prefix."b1st_moduletables"; 

$droptable25="DROP TABLE IF EXISTS ".$wpdb->prefix."b1st_emails"; 

$droptable26="DROP TABLE IF EXISTS ".$wpdb->prefix."b1st_tweets";

$droptable27="DROP TABLE IF EXISTS ".$wpdb->prefix."b1st_responder_time_duration"; 

$instab=array($table1,$table2,$table3,$table4,$table5,$table6,$table7,$table8,$table9,$table10,$table11,$table12,$table13,$table14,$table15,$table16,$table17,$table18,$table19,$table20,$table21,$table22,$table23,$table24,$table25,$table26,$table27);

$droptab=array($droptable1,$droptable2,$droptable3,$droptable4,$droptable5,$droptable6,$droptable7,$droptable8,$droptable9,$droptable10,$droptable11,$droptable12,$droptable13,$droptable14,$droptable15,$droptable16,$droptable17,$droptable18,$droptable19,$droptable20,$droptable21,$droptable22,$droptable23,$droptable24,$droptable25,$droptable26,$droptable27);

$tables = array("ticket","product","department","company","faq","ticket_priority","privilege_group","privileges","ticket_reply","ticket_states","ticket_users","settings","attachments","temp_file","theme","ticket_register_types","ticket_rating","chatsession","kb_cat","knowledgebasemod","language","admin_ticket_assignment","ticket_backup","moduletables","emails","tweets","responder_time_duration");
?>