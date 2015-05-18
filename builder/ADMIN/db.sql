CREATE TABLE websiteadmin_admin_users (
  id int(11) NOT NULL AUTO_INCREMENT,
  username varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `type` varchar(30) NOT NULL DEFAULT 'Administrators',
  first_name varchar(100) DEFAULT NULL,
  last_name varchar(100) DEFAULT NULL,
  telephone varchar(50) NOT NULL DEFAULT '',
  email varchar(100) NOT NULL DEFAULT '',
  bo_lang char(2) NOT NULL DEFAULT 'en',
  `language` char(2) NOT NULL DEFAULT 'en',
  country varchar(100) NOT NULL DEFAULT '',
  birthday_month varchar(10) NOT NULL DEFAULT '',
  birthday_day varchar(10) NOT NULL DEFAULT '',
  birthday_year varchar(10) NOT NULL DEFAULT '',
  subdomain varchar(100) NOT NULL DEFAULT '',
  card_type varchar(100) NOT NULL DEFAULT '',
  card_number varchar(100) NOT NULL DEFAULT '',
  card_exp_month varchar(10) NOT NULL DEFAULT '',
  card_exp_year varchar(10) NOT NULL DEFAULT '',
  card_name varchar(255) NOT NULL DEFAULT '',
  card_security_code varchar(10) NOT NULL DEFAULT '',
  address_address1 varchar(255) NOT NULL DEFAULT '',
  address_address2 varchar(255) NOT NULL DEFAULT '',
  address_city varchar(100) NOT NULL DEFAULT '',
  address_state varchar(100) NOT NULL DEFAULT '',
  address_zip varchar(50) NOT NULL DEFAULT '',
  address_country varchar(255) NOT NULL DEFAULT '',
  plan int(11) NOT NULL DEFAULT '0',
  last_update int(11) NOT NULL DEFAULT '0',
  blog_created int(11) NOT NULL DEFAULT '0',
  blog_category varchar(10) NOT NULL DEFAULT '0',
  fax varchar(50) NOT NULL DEFAULT '',
  blog_lang char(2) NOT NULL DEFAULT 'en',
  blog_active tinyint(4) NOT NULL DEFAULT '1',
  activation_code varchar(50) NOT NULL DEFAULT '',
  animated_characters tinyint(4) NOT NULL DEFAULT '1',
  message text NOT NULL,
  payment varchar(50) NOT NULL DEFAULT '',
  blog_expires int(11) NOT NULL DEFAULT '0',
  new_plan int(11) NOT NULL DEFAULT '0',
  profile_about text NOT NULL,
  profile_age tinyint(4) NOT NULL DEFAULT '0',
  profile_interests varchar(255) NOT NULL DEFAULT '',
  profile_profession varchar(255) NOT NULL DEFAULT '',
  profile_languages varchar(255) NOT NULL DEFAULT '',
  profile_sign tinyint(4) NOT NULL DEFAULT '0',
  profile_height int(4) NOT NULL DEFAULT '0',
  profile_weight tinyint(4) NOT NULL DEFAULT '0',
  profile_eyes tinyint(4) NOT NULL DEFAULT '0',
  profile_hair tinyint(4) NOT NULL DEFAULT '0',
  profile_status tinyint(4) NOT NULL DEFAULT '0',
  profile_gender tinyint(4) NOT NULL DEFAULT '0',
  profile_searchable tinyint(4) NOT NULL DEFAULT '1',
  profile_blog tinyint(4) NOT NULL DEFAULT '0',
  private_messages tinyint(4) NOT NULL DEFAULT '1',
  friendship_proposals tinyint(4) NOT NULL DEFAULT '1',
  ignore_users text NOT NULL,
  visits bigint(20) NOT NULL DEFAULT '0',
  last_action int(11) NOT NULL DEFAULT '0',
  facebook_id bigint(20) NOT NULL,
  company varchar(255) NOT NULL,
  PRIMARY KEY (id),
  KEY username_2 (username),
  KEY `password` (`password`),
  KEY blog_active (blog_active),
  KEY profile_searchable (profile_searchable),
  KEY profile_age (profile_age),
  KEY blog_created (blog_created),
  KEY last_update (last_update),
  KEY blog_category (blog_category)
) ENGINE=MyISAM;

INSERT INTO websiteadmin_admin_users (id, username, `password`, `type`, first_name, last_name, telephone, email, bo_lang, `language`, country, birthday_month, birthday_day, birthday_year, subdomain, card_type, card_number, card_exp_month, card_exp_year, card_name, card_security_code, address_address1, address_address2, address_city, address_state, address_zip, address_country, plan, last_update, blog_created, blog_category, fax, blog_lang, blog_active, activation_code, animated_characters, message, payment, blog_expires, new_plan, profile_about, profile_age, profile_interests, profile_profession, profile_languages, profile_sign, profile_height, profile_weight, profile_eyes, profile_hair, profile_status, profile_gender, profile_searchable, profile_blog, private_messages, friendship_proposals, ignore_users, visits, last_action, facebook_id, company) VALUES(35, 'administrator', 'c6db97c0a3e03f51a0cc34762d8a36de', 'Administrators', NULL, NULL, '', '', 'EN', 'en', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, 0, '0', '2', 'en', 1, '', 1, '', '', 0, 0, '', 0, '', '', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 1, '', 0, 0, 0, '');

CREATE TABLE websiteadmin_admin_users_permissions (
  id int(11) NOT NULL AUTO_INCREMENT,
  permission varchar(100) NOT NULL DEFAULT '0',
  PRIMARY KEY (id)
) ENGINE=MyISAM;

INSERT INTO websiteadmin_admin_users_permissions (id, permission) VALUES(45, '@Basic@home@welcome');
INSERT INTO websiteadmin_admin_users_permissions (id, permission) VALUES(46, '@Premium@home@welcome');
INSERT INTO websiteadmin_admin_users_permissions (id, permission) VALUES(47, '@Basic@home@connections');
INSERT INTO websiteadmin_admin_users_permissions (id, permission) VALUES(48, '@Premium@home@connections');
INSERT INTO websiteadmin_admin_users_permissions (id, permission) VALUES(49, '@Basic@home@history');
INSERT INTO websiteadmin_admin_users_permissions (id, permission) VALUES(50, '@Premium@home@history');
INSERT INTO websiteadmin_admin_users_permissions (id, permission) VALUES(51, '@Basic@home@password');
INSERT INTO websiteadmin_admin_users_permissions (id, permission) VALUES(52, '@Premium@home@password');
INSERT INTO websiteadmin_admin_users_permissions (id, permission) VALUES(53, '@Basic@site_management@pages');
INSERT INTO websiteadmin_admin_users_permissions (id, permission) VALUES(54, '@Premium@site_management@pages');
INSERT INTO websiteadmin_admin_users_permissions (id, permission) VALUES(55, '@Basic@site_management@menu');
INSERT INTO websiteadmin_admin_users_permissions (id, permission) VALUES(56, '@Premium@site_management@menu');
INSERT INTO websiteadmin_admin_users_permissions (id, permission) VALUES(57, '@Basic@templates@select');
INSERT INTO websiteadmin_admin_users_permissions (id, permission) VALUES(58, '@Premium@templates@select');
INSERT INTO websiteadmin_admin_users_permissions (id, permission) VALUES(59, '@Basic@templates@add');
INSERT INTO websiteadmin_admin_users_permissions (id, permission) VALUES(60, '@Premium@templates@add');
INSERT INTO websiteadmin_admin_users_permissions (id, permission) VALUES(61, '@Basic@languages@languages');
INSERT INTO websiteadmin_admin_users_permissions (id, permission) VALUES(62, '@Premium@languages@languages');
INSERT INTO websiteadmin_admin_users_permissions (id, permission) VALUES(63, '@Basic@server_side_forms@posted_data');
INSERT INTO websiteadmin_admin_users_permissions (id, permission) VALUES(64, '@Premium@server_side_forms@posted_data');
INSERT INTO websiteadmin_admin_users_permissions (id, permission) VALUES(65, '@Basic@server_side_forms@design');
INSERT INTO websiteadmin_admin_users_permissions (id, permission) VALUES(66, '@Premium@server_side_forms@design');
INSERT INTO websiteadmin_admin_users_permissions (id, permission) VALUES(67, '@Basic@server_side_forms@manage');
INSERT INTO websiteadmin_admin_users_permissions (id, permission) VALUES(68, '@Premium@server_side_forms@manage');
INSERT INTO websiteadmin_admin_users_permissions (id, permission) VALUES(69, '@Basic@settings@style');
INSERT INTO websiteadmin_admin_users_permissions (id, permission) VALUES(70, '@Premium@settings@style');
INSERT INTO websiteadmin_admin_users_permissions (id, permission) VALUES(71, '@Basic@settings@interface');
INSERT INTO websiteadmin_admin_users_permissions (id, permission) VALUES(72, '@Premium@settings@interface');
INSERT INTO websiteadmin_admin_users_permissions (id, permission) VALUES(73, '@Basic@statistics@reports');
INSERT INTO websiteadmin_admin_users_permissions (id, permission) VALUES(74, '@Premium@statistics@reports');
INSERT INTO websiteadmin_admin_users_permissions (id, permission) VALUES(75, '@Basic@statistics@referals');
INSERT INTO websiteadmin_admin_users_permissions (id, permission) VALUES(76, '@Premium@statistics@referals');
INSERT INTO websiteadmin_admin_users_permissions (id, permission) VALUES(77, '@Basic@statistics@google');
INSERT INTO websiteadmin_admin_users_permissions (id, permission) VALUES(78, '@Premium@statistics@google');
INSERT INTO websiteadmin_admin_users_permissions (id, permission) VALUES(79, '@Basic@site_promotion@index_report');
INSERT INTO websiteadmin_admin_users_permissions (id, permission) VALUES(80, '@Premium@site_promotion@index_report');
INSERT INTO websiteadmin_admin_users_permissions (id, permission) VALUES(81, '@Basic@site_promotion@popularity_report');
INSERT INTO websiteadmin_admin_users_permissions (id, permission) VALUES(82, '@Premium@site_promotion@popularity_report');
INSERT INTO websiteadmin_admin_users_permissions (id, permission) VALUES(83, '@Basic@site_promotion@google');
INSERT INTO websiteadmin_admin_users_permissions (id, permission) VALUES(84, '@Premium@site_promotion@google');
INSERT INTO websiteadmin_admin_users_permissions (id, permission) VALUES(85, '@Premium@help@sample');
INSERT INTO websiteadmin_admin_users_permissions (id, permission) VALUES(86, '@Basic@exit@exit');
INSERT INTO websiteadmin_admin_users_permissions (id, permission) VALUES(87, '@Premium@exit@exit');

CREATE TABLE websiteadmin_admin_users_type (
  id int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(100) NOT NULL DEFAULT '',
  message text NOT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM;

INSERT INTO websiteadmin_admin_users_type (id, `type`, message) VALUES(4, 'Group2', '');
INSERT INTO websiteadmin_admin_users_type (id, `type`, message) VALUES(3, 'Group1', '');

CREATE TABLE websiteadmin_blog_band (
  id int(11) NOT NULL AUTO_INCREMENT,
  `date` int(11) NOT NULL DEFAULT '0',
  `user` varchar(100) NOT NULL DEFAULT '',
  size int(11) NOT NULL DEFAULT '0',
  ip varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (id)
) ENGINE=MyISAM;

CREATE TABLE websiteadmin_blog_documents (
  id int(11) NOT NULL AUTO_INCREMENT,
  title varchar(255) DEFAULT NULL,
  description text,
  file_id bigint(20) NOT NULL DEFAULT '0',
  `user` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (id)
) ENGINE=MyISAM;

CREATE TABLE websiteadmin_blog_files (
  file_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  file_type varchar(50) NOT NULL DEFAULT '',
  content longblob NOT NULL,
  file_size bigint(20) NOT NULL DEFAULT '0',
  file_name varchar(255) NOT NULL DEFAULT '',
  file_date datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user` varchar(100) NOT NULL DEFAULT '',
  UNIQUE KEY file_id (file_id),
  KEY `user` (`user`)
) ENGINE=MyISAM;

CREATE TABLE websiteadmin_blog_packages (
  id int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL DEFAULT '',
  description text NOT NULL,
  space int(11) NOT NULL DEFAULT '0',
  traffic int(11) NOT NULL DEFAULT '0',
  price decimal(10,2) NOT NULL DEFAULT '0.00',
  billed int(11) NOT NULL DEFAULT '1',
  paypal tinyint(4) NOT NULL DEFAULT '1',
  cheque tinyint(4) NOT NULL DEFAULT '1',
  bank_wire tinyint(4) NOT NULL DEFAULT '0',
  adv tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (id)
) ENGINE=MyISAM;

INSERT INTO websiteadmin_blog_packages (id, `name`, description, space, traffic, price, billed, paypal, cheque, bank_wire, adv) VALUES(1, 'Basic', '', 2048, 20480, '0.00', 3, 1, 1, 0, 1);

CREATE TABLE websiteadmin_blog_payments (
  id int(11) NOT NULL AUTO_INCREMENT,
  `date` int(11) NOT NULL DEFAULT '0',
  `user` varchar(100) NOT NULL DEFAULT '',
  method varchar(100) NOT NULL DEFAULT '',
  validated tinyint(4) NOT NULL DEFAULT '0',
  amount varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (id)
) ENGINE=MyISAM;

CREATE TABLE websiteadmin_bo_slog (
  id int(11) NOT NULL AUTO_INCREMENT,
  ip varchar(20) NOT NULL DEFAULT '',
  args text,
  uid varchar(40) NOT NULL DEFAULT '',
  `date` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (id)
) ENGINE=MyISAM;

CREATE TABLE websiteadmin_comments (
  id int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(100) NOT NULL DEFAULT '',
  title text,
  html text,
  note_id int(11) NOT NULL DEFAULT '0',
  author varchar(100) DEFAULT NULL,
  email varchar(100) DEFAULT NULL,
  `user` varchar(100) DEFAULT NULL,
  ip varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (id),
  KEY `user` (`user`),
  KEY note_id (note_id)
) ENGINE=MyISAM;

CREATE TABLE websiteadmin_contact (
  id int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(100) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  email varchar(100) NOT NULL DEFAULT '',
  message text NOT NULL,
  `date` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (id),
  KEY `user` (`user`)
) ENGINE=MyISAM;

CREATE TABLE websiteadmin_contact_settings (
  id int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(100) NOT NULL DEFAULT '',
  send_email varchar(10) NOT NULL DEFAULT 'YES',
  email varchar(255) DEFAULT NULL,
  show_contact_link tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (id),
  KEY `user` (`user`)
) ENGINE=MyISAM;

CREATE TABLE websiteadmin_faq (
  id int(11) NOT NULL AUTO_INCREMENT,
  `date` int(100) NOT NULL DEFAULT '0',
  title text,
  html text,
  PRIMARY KEY (id)
) ENGINE=MyISAM;

CREATE TABLE websiteadmin_forms (
  id int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  description text NOT NULL,
  `code` text NOT NULL,
  active tinyint(4) NOT NULL DEFAULT '1',
  `page` varchar(255) NOT NULL DEFAULT '',
  submit varchar(250) NOT NULL DEFAULT 'submit',
  message text NOT NULL,
  email varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (id)
) ENGINE=MyISAM;

CREATE TABLE websiteadmin_forms_data (
  id int(11) NOT NULL AUTO_INCREMENT,
  form_id int(11) NOT NULL DEFAULT '0',
  `data` text NOT NULL,
  `date` varchar(250) NOT NULL DEFAULT '',
  ip varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (id)
) ENGINE=MyISAM;

CREATE TABLE websiteadmin_image (
  image_id int(10) unsigned NOT NULL AUTO_INCREMENT,
  image_type varchar(50) NOT NULL DEFAULT '',
  image longblob NOT NULL,
  image_size bigint(20) NOT NULL DEFAULT '0',
  image_name varchar(255) NOT NULL DEFAULT '',
  image_date datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user` varchar(100) DEFAULT NULL,
  UNIQUE KEY image_id (image_id),
  KEY `user` (`user`)
) ENGINE=MyISAM;

CREATE TABLE websiteadmin_languages (
  id int(11) NOT NULL AUTO_INCREMENT,
  active tinyint(1) NOT NULL DEFAULT '1',
  `name` varchar(50) NOT NULL DEFAULT '',
  `code` varchar(10) NOT NULL DEFAULT '',
  default_language tinyint(4) NOT NULL DEFAULT '0',
  html text NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY `code` (`code`)
) ENGINE=MyISAM;

INSERT INTO websiteadmin_languages (id, active, `name`, code, default_language, html) VALUES(1, 1, 'English', 'EN', 1, 'html_Angliiski');

CREATE TABLE websiteadmin_linksmanager (
  id int(11) NOT NULL AUTO_INCREMENT,
  title varchar(255) NOT NULL DEFAULT '',
  url varchar(255) NOT NULL DEFAULT '',
  short_description text NOT NULL,
  long_description text NOT NULL,
  rank int(11) NOT NULL DEFAULT '0',
  cat int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (id)
) ENGINE=MyISAM;

CREATE TABLE websiteadmin_lm_categories (
  id int(11) NOT NULL AUTO_INCREMENT,
  parent_id varchar(20) NOT NULL DEFAULT '0',
  active_en tinyint(4) NOT NULL DEFAULT '1',
  name_en varchar(255) NOT NULL DEFAULT '',
  description_en text NOT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM;

CREATE TABLE websiteadmin_login_log (
  id int(11) NOT NULL AUTO_INCREMENT,
  username varchar(100) NOT NULL DEFAULT '',
  ip varchar(100) NOT NULL DEFAULT '',
  `date` varchar(100) NOT NULL DEFAULT '',
  `action` varchar(10) NOT NULL DEFAULT '',
  cookie varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (id)
) ENGINE=MyISAM;

CREATE TABLE websiteadmin_messages (
  id int(11) NOT NULL AUTO_INCREMENT,
  `time` int(11) NOT NULL DEFAULT '0',
  user_from varchar(50) NOT NULL DEFAULT '',
  user_to varchar(50) NOT NULL DEFAULT '',
  message text NOT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM;

CREATE TABLE websiteadmin_news (
  id int(11) NOT NULL AUTO_INCREMENT,
  `date` int(100) NOT NULL DEFAULT '0',
  title text,
  html text,
  accept_comments varchar(10) NOT NULL DEFAULT 'YES',
  active varchar(10) NOT NULL DEFAULT 'YES',
  PRIMARY KEY (id)
) ENGINE=MyISAM;

CREATE TABLE websiteadmin_newsletter (
  id int(11) NOT NULL AUTO_INCREMENT,
  html text NOT NULL,
  `subject` text NOT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM;

CREATE TABLE websiteadmin_newsletter_log (
  id int(11) NOT NULL AUTO_INCREMENT,
  email varchar(255) NOT NULL DEFAULT '',
  `date` varchar(30) NOT NULL DEFAULT '',
  newsletter_id int(11) NOT NULL DEFAULT '0',
  `status` varchar(25) NOT NULL DEFAULT '',
  PRIMARY KEY (id)
) ENGINE=MyISAM;

CREATE TABLE websiteadmin_notes (
  id int(11) NOT NULL AUTO_INCREMENT,
  `date` int(100) NOT NULL DEFAULT '0',
  title text,
  html text,
  accept_comments varchar(10) NOT NULL DEFAULT 'YES',
  active varchar(10) NOT NULL DEFAULT 'YES',
  category_id int(11) NOT NULL DEFAULT '0',
  `user` varchar(100) DEFAULT NULL,
  accept_trackbacks tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (id),
  KEY `user` (`user`),
  KEY active (active),
  KEY category_id (category_id),
  KEY `date` (`date`),
  FULLTEXT KEY title (title),
  FULLTEXT KEY html (html)
) ENGINE=MyISAM;

CREATE TABLE websiteadmin_note_categories (
  id int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `user` varchar(100) NOT NULL DEFAULT '',
  `date` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (id),
  KEY `user` (`user`)
) ENGINE=MyISAM;

CREATE TABLE websiteadmin_note_settings (
  id int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(100) NOT NULL DEFAULT '',
  notes_visible tinyint(4) NOT NULL DEFAULT '5',
  notes_order tinyint(4) NOT NULL DEFAULT '1',
  date_format tinyint(4) NOT NULL DEFAULT '1',
  allow_comments tinyint(4) NOT NULL DEFAULT '1',
  comments_order tinyint(4) NOT NULL DEFAULT '1',
  send_comments_email tinyint(4) NOT NULL DEFAULT '0',
  blacklist text NOT NULL,
  background varchar(20) NOT NULL DEFAULT '',
  allow_trackbacks tinyint(4) NOT NULL DEFAULT '1',
  blacklist_trackbacks text NOT NULL,
  ping_weblogs tinyint(4) NOT NULL DEFAULT '0',
  ping_blogs tinyint(4) NOT NULL DEFAULT '0',
  ping_pingomatic tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (id),
  KEY `user` (`user`)
) ENGINE=MyISAM;

CREATE TABLE websiteadmin_pages (
  id int(11) NOT NULL AUTO_INCREMENT,
  parent_id varchar(20) NOT NULL DEFAULT '0',
  active_en tinyint(4) NOT NULL DEFAULT '0',
  name_en varchar(255) NOT NULL DEFAULT '',
  link_en varchar(255) NOT NULL DEFAULT '',
  description_en text NOT NULL,
  keywords_en text NOT NULL,
  html_en text NOT NULL,
  custom_link_en text NOT NULL,
  template_id int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (id),
  KEY parent_id (parent_id)
) ENGINE=MyISAM;

INSERT INTO websiteadmin_pages (id, parent_id, active_en, name_en, link_en, description_en, keywords_en, html_en, custom_link_en, template_id) VALUES(30, '0', 1, 'Signup', 'Signup', '', '', 'wsa:extension:signup', '', 0);
INSERT INTO websiteadmin_pages (id, parent_id, active_en, name_en, link_en, description_en, keywords_en, html_en, custom_link_en, template_id) VALUES(29, '0', 1, 'Home', 'Home', '', '', '<div id="main_header">\r\n	<div  class="container padding-20">\r\n	\r\n		<div class="block-623px">\r\n			<img src="images/slogan.gif" width="560" height="58" alt="Create Online Your Website with Ease"/>\r\n			<br/><br/>\r\n			- Click on the link below to sign up\r\n			and \r\n			create your own professional website in minutes\r\n			\r\n			<br/><br/>\r\n			- Choose between dozens of templates, \r\n			manage the structure of your website - add new pages or \r\n			rename or remove the existing ones and edit their content with ease\r\n			<br/><br/><br/>\r\n			\r\n			<a href="index.php?mod=signup" style="font-weight:800;font-size:14px;margin-right:15px">Click here to sign up now</a>\r\n			or\r\n			<a href="index.php?mod=login" style="font-weight:800;font-size:14px;margin-left:15px">Log in</a>\r\n		\r\n		</div>\r\n		\r\n		<img class="rfloat" alt="" src="images/websites_collage.png" width="319" height="202"/>\r\n	</div>\r\n</div>\r\n<center>\r\n<div class="block-990px">\r\n\r\n<br/><br/>\r\n<img src="images/multiple_tools.gif" width="970" height="53" alt="Multiple templates and features available to customize your website design and content"/>\r\n<br/><br/><br/>\r\n<div class="clear"></div>\r\n\r\n	<div class="block-320px">\r\n		<img src="images/dashboard.jpg">\r\n		<br>\r\n		\r\n		<div class="justified-text-300px">\r\n		\r\n		Your own admin space will offer\r\n		you plenty of features allowing you \r\n		to customize and manage your website.\r\n		The dashboard on the home page provides\r\n		quick overview of the website current\r\n		template, pages and statistics and also a\r\n		form allowing to post quickly news on the website.\r\n		\r\n		</div>\r\n	</div>\r\n	\r\n	<div  class="left-margin-10 lfloat">\r\n		<img src="images/templates.gif">\r\n		<br>\r\n		\r\n		<div class="justified-text-300px">\r\n		Dozens of templates \r\n		are available to you to choose from.\r\n		You can also design your own template or \r\n		customize the current ones, by changing\r\n		the styles, colors, upload your own logo \r\n		etc.\r\n		</div>\r\n		\r\n	</div>\r\n\r\n	\r\n\r\n	<div class="left-margin-10 lfloat">\r\n		<img alt="" src="images/site_management.gif"/>\r\n		<br/>\r\n		<div class="justified-text-300px">\r\n		The website manager in the admin space\r\n		allows you to manage the website structure\r\n		and content with simple drag and drop moves - \r\n		for example adding a new page is as easy \r\n		as dragging the icon for a new page over the desired\r\n		position in the website tree.\r\n		\r\n		</div>\r\n		\r\n	</div>\r\n	\r\n	\r\n	\r\n</div>\r\n</center>\r\n<div class="clear"></div>\r\n<br/><br/>', '', 0);
INSERT INTO websiteadmin_pages (id, parent_id, active_en, name_en, link_en, description_en, keywords_en, html_en, custom_link_en, template_id) VALUES(40, '0', 1, 'News', 'News', '', '', 'wsa:extension:news', '', 0);
INSERT INTO websiteadmin_pages (id, parent_id, active_en, name_en, link_en, description_en, keywords_en, html_en, custom_link_en, template_id) VALUES(43, '0', 1, 'FAQ', 'FAQ', '', '', 'wsa:extension:faq', '', 0);
INSERT INTO websiteadmin_pages (id, parent_id, active_en, name_en, link_en, description_en, keywords_en, html_en, custom_link_en, template_id) VALUES(47, '0', 1, 'Contact', 'Contact', '', '', '-', '', 0);
INSERT INTO websiteadmin_pages (id, parent_id, active_en, name_en, link_en, description_en, keywords_en, html_en, custom_link_en, template_id) VALUES(39, '0', 1, 'Websites', 'Websites', '', '', 'wsa:extension:websites', '', 0);

CREATE TABLE websiteadmin_photo (
  id int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(100) NOT NULL DEFAULT '',
  `name` text NOT NULL,
  description text NOT NULL,
  `date` varchar(100) NOT NULL DEFAULT '',
  format varchar(100) NOT NULL DEFAULT '',
  home_thumbnails_columns tinyint(4) NOT NULL DEFAULT '3',
  home_thumbnails_size tinyint(4) NOT NULL DEFAULT '2',
  thumbnails_size tinyint(4) NOT NULL DEFAULT '2',
  show_title varchar(10) NOT NULL DEFAULT 'OUI',
  show_date varchar(10) NOT NULL DEFAULT 'OUI',
  show_legende varchar(10) NOT NULL DEFAULT 'OUI',
  show_place varchar(10) NOT NULL DEFAULT 'OUI',
  show_description varchar(10) NOT NULL DEFAULT 'OUI',
  home_page_format tinyint(4) NOT NULL DEFAULT '1',
  album_format tinyint(4) NOT NULL DEFAULT '1',
  place varchar(255) NOT NULL DEFAULT '',
  legend text NOT NULL,
  PRIMARY KEY (id),
  KEY `user` (`user`)
) ENGINE=MyISAM;

CREATE TABLE websiteadmin_photo_images (
  id int(11) NOT NULL AUTO_INCREMENT,
  image_id bigint(20) NOT NULL DEFAULT '0',
  photo_id int(11) NOT NULL DEFAULT '0',
  description text NOT NULL,
  legend text,
  place varchar(255) DEFAULT NULL,
  title text,
  `date` varchar(50) NOT NULL DEFAULT '',
  ext varchar(20) NOT NULL,
  PRIMARY KEY (id),
  KEY photo_id (photo_id)
) ENGINE=MyISAM;

CREATE TABLE websiteadmin_settings (
  id_key int(11) NOT NULL AUTO_INCREMENT,
  id int(11) NOT NULL DEFAULT '0',
  description varchar(255) NOT NULL DEFAULT '',
  `value` text NOT NULL,
  PRIMARY KEY (id_key)
) ENGINE=MyISAM;

INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(1064, 7, 'Menu direction', 'HORIZONTAL');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(1066, 9, 'Menu direction', 'HORIZONTAL');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(1065, 8, 'Show separator', 'FALSE');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(1067, 10, 'Selected template', '5');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(1068, 11, 'Music file to play', 'sounds/sample.wav');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(1063, 6, 'Show separator', 'TRUE');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(1062, 5, 'Show selected', 'FALSE');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(1061, 4, 'Menu alignment', 'CENTER');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(1059, 2, 'Menu type', 'custom');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(1060, 3, 'Languages Menu Type', 'standart');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(1058, 1, 'Default Page', '29');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(24, 204, 'Secondes display', 'YES');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(23, 203, 'Font color', '00347b');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(21, 201, 'Active', 'YES');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(22, 202, 'Background color', '#FFFFFF');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(1069, 12, 'Default template HTML code', '<html>\r\n\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">\r\n<title><wsm title/></title>\r\n<meta name="description" content="<wsm description/>">\r\n<meta name="keywords" content="<wsm keywords/>">\r\n</head>\r\n<body rightmargin="0" bottommargin="0" leftmargin="0" topmargin="0">\r\n\r\n<div style="position:absolute;top:2;left:15">\r\n<wsm languages_menu/>\r\n</div>\r\n\r\n<table border="0" WIDTH="100%" cellpadding="0" cellspacing="0">\r\n	<tr>\r\n		<td align=left>\r\n\r\n<img src="images/44.gif" border="0" width="636" height="103" alt="">\r\n<br>\r\n<img src="images/spacer.gif" border="0" width="19" height="1" alt="">\r\n<font color="#c62429" face="Comic Sans MS" size="2">Home | Sitemap | Impressum</font>\r\n	\r\n		</td>\r\n		<td align=right>\r\n\r\n<img src="images/5.jpg" border="0" width="302" height="171" alt="">\r\n</td>\r\n	</tr>\r\n</table>\r\n<table summary="" border="0" width=100%>\r\n	<tr>\r\n		<td width=14>\r\n			 \r\n		</td>\r\n		<td width=200 valign=top>\r\n		\r\n			<wsm menu/>\r\n   \r\n		\r\n		</td>\r\n		\r\n		<td width=14>\r\n			 \r\n		</td>\r\n		<td valign=top>\r\n		\r\n		\r\n\r\n  			<wsm content/>\r\n		<wsm form/>\r\n		\r\n		</td>\r\n	</tr>\r\n</table>\r\n<br><br>\r\n<center>\r\n<font color=#c62429 face="Comic Sans MS" size=1>2004 ? L?HR Projektmanagement</font>\r\n</center>\r\n\r\n</body>\r\n</html>\r\n');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(1070, 21, 'Menu direction', 'HORIZONTAL');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(1071, 22, 'Links Back Color', '#f7f7ff');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(1072, 23, 'Links Fore color', '#313031');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(1073, 24, 'SubLinks Back color', '#e7e7ff');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(1074, 25, 'SubLinks Fore color', '#313031');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(1075, 26, 'Border style', 'solid');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(1076, 27, 'Border width', '1');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(1077, 28, 'Border color', '#e7e7e7');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(1078, 29, 'Links Font', 'Arial');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(1079, 30, 'SubLinks Font', 'Arial');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(1080, 31, 'Links Font size', '12');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(1081, 32, 'SubLinks Font size', '10');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(1082, 33, 'Links Font color', '#ffffff');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(1083, 34, 'SubLinks Font color', '#3d3d3d');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(1084, 35, 'Menu width', '220');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(1085, 36, 'Links row height', '23');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(1086, 37, 'SubLinks row height', '22');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(1014, 301, 'Menu Level 1 - Style', 'font-family:verdana,arial; font-size:11px;border-left:1px solid #2971c6;border-top:1px solid #2971c6;padding-left:3;padding-top:2;background-color:#2971c6;color:white;font-weight:800;height:18;position:absolute; overflow:hidden;  height:25; cursor:pointer; cursor:hand');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(1015, 302, 'Menu Level 1 - Mouse Over Style', 'font-family:verdana,arial; font-size:11px;border-left:1px solid #528ed6;border-top:1px solid #528ed6;padding-left:3;padding-top:2;background-color:#528ed6;color:white;font-weight:800;height:18;position:absolute; overflow:hidden;  height:25; cursor:pointer; cursor:hand');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(1016, 303, 'Menu Sub Levels  - Style', 'font-family:verdana,arial; font-size:11px;background-color:#528ed6;color:#ffffff;padding:2px; font-size:11px; font-weight:bold;border-style:solid;border-color:#528ed6;border-width:0px 1px 1px 1px');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(1017, 304, 'Menu Sub Levels - Mouse Over Style', 'font-family:verdana,arial; font-size:11px;background-color:#2971c6;color:#ffffff;padding:2px; font-size:11px; font-weight:bold;border-style:solid;border-color:#2971c6;border-width:0px 1px 1px 1px');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(1087, 51, 'Position Top', '98');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(1088, 52, 'Position Left', '-20');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(1089, 53, 'Level 1 - Width', '120');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(1090, 54, 'Level 2 - Width', '140px');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(1091, 55, 'Level 1 - Height', '28');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(1092, 56, 'Level 2 - Height', '20px');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(1093, 61, 'Default Font', 'Arial');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(1094, 62, 'Default Font Size', '12');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(1095, 63, 'Default Font Color', '#404040');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(1096, 71, 'History Records', '1000');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(1097, 72, 'Security log Records', '1000');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(1099, 100, 'Custom Tags', 'a:2:{i:0;a:2:{i:0;s:11:"bottom_menu";i:1;s:15:"bottom_menu.php";}i:1;a:2:{i:0;s:10:"login_form";i:1;s:14:"login_form.php";}}');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5156, 401, 'User sites URL format', 'SUBFOLDERS (www.domain.com/user)');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5157, 402, 'Store the uploaded images in the database', 'NO');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5158, 403, 'Maximum Allowed Image Size', '1000000');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5159, 404, 'Maximum Allowed File Size', '2000000');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5153, 1502, 'Zone 2', '');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5154, 1503, 'Zone 3', '');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5155, 1504, 'Zone 4', '');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5136, 60, 'Disable these styles', 'NO');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(1098, 5001, 'Service Price', '0');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(1100, 333, 'Custom links template', '<a rplc href="[LINK_HREF]">[LINK_TEXT]</a>\r\n<!--sep-->\r\n<img style="margin-left:20px;margin-right:20px" src="images/menu_separator.png" width="1" height="9">');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5160, 405, 'Error message if the maximum image size is exceeded', 'The image size should be < 1Mb');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5142, 804, 'Category Browser Template', '   <table cellpadding="0" cellspacing="0">\r\n               	<tbody>\r\n					<tr>\r\n						<td>\r\n							<img src="images/m24.gif" height="40" width="207">\r\n						</td>\r\n					</tr>\r\n               		<tr>\r\n						<td class="bg1" style="border-style:solid;border-color:#d6d7d6;border-width:0px 1px 0px 1px">\r\n                    		\r\n							<table align="center" cellpadding="0" cellspacing="0" width="167">\r\n                     			<tbody>\r\n									<tr>\r\n										<td height="18"></td>\r\n									</tr>\r\n									\r\n									<!--ITEM-->\r\n									<tr>\r\n										<td>\r\n											<img src="images/m25.gif" align="middle" height="5" width="5">   \r\n											<a class="ml1" href="[CATEGORY_LINK]">[CATEGORY_NAME]</a><br><br class="px4">\r\n										</td>\r\n									</tr>\r\n									<tr>\r\n										<td>\r\n											<img src="images/m26.gif" height="1" width="167">\r\n											<br>\r\n											<br class="px2">\r\n										</td>\r\n									</tr>\r\n									<!--ITEM-->\r\n								</tbody>\r\n							</table>\r\n			\r\n		               </td>\r\n				</tr>\r\n               <tr>\r\n			   		<td>\r\n						<img src="images/m27.gif" height="6" width="207">\r\n					</td>\r\n				</tr>\r\n               <tr>\r\n			   		<td height="3"></td>\r\n				</tr>\r\n             </tbody>\r\n	</table>');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5119, 65, 'Visited Links Color', '#f8625c');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5120, 66, 'Hover Links Color', '#c8322c');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5121, 67, 'Headers Font Color', '#009fdc');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(1101, 334, 'Use template', 'TRUE');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(1102, 1111, 'Url type', '1');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(1103, 1112, 'Url language', 'YES');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5140, 40, 'Links Text Decoration Mouseover', 'none');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5141, 41, 'SubLinks Text Decoration Mouseover', 'none');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5118, 64, 'Links color', '#f8625c');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5098, 5001, 'Service Price', '16.99');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5100, 5002, 'Maximum image width', '');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5101, 5003, 'Maximum image height', '');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5102, 5004, 'Search page image width', '100');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5103, 5005, 'Search page image height', '76');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5104, 5006, 'Details page image width', '248');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5105, 5007, 'Details page image height', '200');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5106, 5008, 'Rotator image width', '214');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5107, 5009, 'Rotator image height', '150');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5108, 5010, 'Sell page text', '');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5109, 5011, 'Search page text', '');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5110, 5012, 'Payment by check message', ' ');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5111, 6000, 'Auto email', '  ');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5112, 3000, 'Unsubscribe message', 'Your email has been successfully removed from our mailing list!');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5113, 3001, 'Email unsubscribe message', 'In order to unsubscribe to our newsletter, simply click on the following link');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5114, 3002, 'Add unsubscribe link to the newsletter', 'YES');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5115, 3003, 'Email address (From)', 'zamov@online.fr');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5116, 3004, 'Email address (Reply to)', 'zamov@online.fr');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5117, 50, 'Multilevel Menu Direction', 'HORIZONTAL');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5122, 310, 'Level 1 - Links Offset', '0');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5123, 311, 'Sub Levels - Links Offset', '0');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5125, 312, 'Level 1 - Background color', '#77b2ea');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5126, 313, 'Sub Levels - Background color', '#ffffff');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5127, 314, 'Level 1 - Background color - Mouseover', '#5792ca');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5128, 315, 'Sub Levels - Background color - Mouseover', '#f6f6f6');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5129, 316, 'Level 1 - Border style', 'none');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5130, 317, 'Sub Levels - Border style', 'solid');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5131, 318, 'Level 1 - Border color', '#f95c17');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5132, 319, 'Sub Levels - Border color', '#e7e7e7');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5133, 320, 'Use the available images(*)', 'NO');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5134, 57, 'Links Padding', '4px');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5139, 39, 'SubLinks Text Decoration', 'none');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5135, 58, 'SubLevels Links Padding', '4px');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5137, 321, 'Menu Direction', 'HORIZONTAL');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5138, 38, 'Links Text Decoration', 'bold');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5143, 805, 'Product Search Template', '<table cellpadding="0" cellspacing="0">\r\n    <tbody>\r\n		<tr>\r\n			<td>\r\n				<img src="images/m28.gif" height="40" width="207">\r\n			</td>\r\n		</tr>\r\n          <tr>\r\n			  <td class="bg1" style="border-style:solid;border-color:#d6d7d6;border-width:0px 1px 0px 1px">\r\n			  \r\n                	[SEARCH_FORM]\r\n						\r\n               	</td>\r\n			</tr>\r\n           <tr>\r\n		   		<td>\r\n					<img src="images/m27.gif" height="6" width="207">\r\n				</td>\r\n			</tr>\r\n    </tbody>\r\n</table>');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5144, 806, 'Category Products Template', '<table cellspacing=0 cellpadding=0>\r\n     <tr><td colspan=10 class=cy2 height=38><b>      Category : [CATEGORY_NAME]</a></b></td></tr>\r\n     <tr><td colspan=10><img src=images/m35.gif width=526 height=4></td></tr>\r\n\r\n       <tr><td valign=top class=bg2  style="border-style:solid;border-width:0px 1px 0px 0px;border-color:#d6d7d6;">\r\n			   \r\n			     <!--PRODUCTS_LINE-->  \r\n			   <table cellspacing=0 cellpadding=0 >\r\n			   	<tr>\r\n			   		\r\n					<!--PRODUCT_ITEM-->\r\n                    <td width=0 height=100% style="border-style:solid;border-width:0px 0px 0px 1px;border-color:#d6d7d6;"><img src="images/spacer.gif" width=1 height=1></td>                        \r\n					\r\n                     <td width=173 valign=top>\r\n					 \r\n					 \r\n                          <table cellspacing=0 cellpadding=0 width=150 align=center border=0>\r\n                           <tr>\r\n						   		<td colspan=2 height=5></td>\r\n							</tr>\r\n                           <tr>\r\n						   <td  colspan=2 align=center> \r\n						   <a href="[PRODUCT_LINK]">\r\n						   <img src="[PRODUCT_IMAGE]" border="0"   width="78" height="78"  class=br>\r\n						   </a> \r\n						   </td>\r\n						   <!--\r\n                               <td valign=middle>\r\n							   		<span class=cy1>\r\n											<span>&nbsp;PRICE&nbsp;</span>\r\n									</span>\r\n								</td>\r\n							-->\r\n                           </tr>\r\n                           <tr>\r\n						   		<td colspan=2 height=3></td>\r\n						   </tr>\r\n\r\n                           <tr>\r\n						   		<td colspan=2 align=center width=150 height=25>\r\n								<a class=ml2 href="[PRODUCT_LINK]">[PRODUCT_NAME]</a>\r\n\r\n								</td>\r\n							</tr>\r\n                           <tr>\r\n						   		<td colspan=2 height=10></td>\r\n							</tr>\r\n                           <tr>\r\n						   		<td colspan=2 align=center><img src=images/m36.gif width=143 height=1></td>\r\n							</tr>\r\n                           <tr>\r\n						   		<td colspan=2 height=10></td>\r\n							</tr>\r\n                           <tr>\r\n						   		<td colspan=2 >\r\n<table width=148><tr><td style="text-align:justify">\r\n	[PRODUCT_SHORT_DESCRIPTION]				\r\n</td></tr></table>				\r\n						   	   </td>\r\n							</tr>\r\n                           <tr>\r\n						   		<td colspan=2 height=12></td>\r\n							</tr>\r\n                          </table>    \r\n					   </td>\r\n                   <!--PRODUCT_ITEM-->\r\n    			\r\n                   \r\n                  \r\n                     </tr>\r\n                    </table>\r\n                    <table cellspacing=0 cellpadding=0>\r\n                     <tr><td><img src=images/m37.gif width=526 height=1></td></tr>\r\n                    </table>   \r\n					\r\n					  <!--PRODUCTS_LINE-->  \r\n					  \r\n					  \r\n					  \r\n                 \r\n                   </td>\r\n                </tr>\r\n               <tr>\r\n			   		<td><img src=images/m43.gif width=526 height=7></td>\r\n				</tr>\r\n              </table>');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5145, 801, '(Category Products) Columns in Line', '3');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5146, 807, 'Product Template', '<b>[PRODUCT_NAME]</b>\r\n<br><br>\r\n<table summary="" border="0">\r\n	<tr>\r\n		<td>\r\n		<img src="[PRODUCT_IMAGE]">\r\n		</td>\r\n		<td>\r\n		[PRODUCT_SHORT_DESCRIPTION]\r\n		</td>\r\n	</tr>\r\n</table>\r\n<br><br>\r\n[PRODUCT_LONG_DESCRIPTION]');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5147, 802, 'Products per Page', '6');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5148, 811, 'Search Fields', 'name|');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5149, 808, 'Categories Menu Type', 'TEMPLATE');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(2078, 2029, 'Links Font', 'Verdana');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(2079, 2030, 'SubLinks Font', 'Verdana');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(2080, 2031, 'Links Font size', '11');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(2081, 2032, 'SubLinks Font size', '11');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(2082, 2033, 'Links Font color', '#104184');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(2083, 2034, 'SubLinks Font color', '#104184');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(2138, 2038, 'Links Text Decoration', 'none');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(2139, 2039, 'SubLinks Text Decoration', 'none');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(2140, 2040, 'Links Text Decoration Mouseover', 'none');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(2141, 2041, 'SubLinks Text Decoration Mouseover', 'none');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(2089, 2053, 'Level 1 - Width', '205px');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(2090, 2054, 'Sub Levels - Width', '160px');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(2091, 2055, 'Level 1 - Height', '20px');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(2092, 2056, 'Sub Levels - Height', '22px');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(2134, 2057, 'Links Padding', '0px');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(2135, 2058, 'SubLevels Links Padding', '4px');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(2122, 2310, 'Level 1 - Links Offset', '0');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(2123, 2311, 'Sub Levels - Links Offset', '0');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(2125, 2312, 'Level 1 - Background color', '#dddddd');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(2126, 2313, 'Sub Levels - Background color', '#cccccc');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(2127, 2314, 'Level 1 - Background color - Mouseover', '#eeeeee');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(2128, 2315, 'Sub Levels - Background color - Mouseover', '#eeeeee');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(2129, 2316, 'Level 1 - Border style', 'solid');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(2130, 2317, 'Sub Levels - Border style', 'solid');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(2131, 2318, 'Level 1 - Border color', '#b1b1b1');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(2132, 2319, 'Sub Levels - Border color', '#6b9ab5');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(2137, 2321, 'Menu Direction', 'VERTICAL');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5152, 1501, 'Zone 1', '');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5151, 1500, 'Zone 1', '');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5150, 13, 'Enable WYSIWYG', 'YES');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5161, 406, 'Error message if the maximum file size is exceeded', 'The file size should be < 2Mb');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5162, 407, 'Enable SEO Links', 'NO');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5163, 408, 'Multi Language Website', 'NO');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5164, 409, 'Default Time Zone', 'Europe/London');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5165, 410, 'Enable Website Cache', 'NO');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5166, 411, 'Enable User Sites Cache', 'NO');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5167, 412, 'Front Site Cache Expire Time (minutes)', '15');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5168, 413, 'User Sites Cache Expire Time (minutes)', '30');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5169, 414, 'Generate Thumbnails', 'YES');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5170, 415, 'Use CAPTCHA images', 'YES');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5171, 416, 'User Templates', '507,508,501,502,503,504,505,506,509,510,511,512,513,514,515,516,519,520,521,523,524,401,402,403,411,421,422,431,432,433,441,442,443,451,452,453,361,362,363,311,312,313,321,322,323,331,332,333,341,342,343,351,352,353,161,162,163,171,172,173,191,192,193,201,202,203,211,212,213,151,141,142,131,132,133,143,101,102,103,111,112,113');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5172, 417, 'Default User Template', '401');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5173, 418, 'Validate User Emails on Sign up', 'NO');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5174, 419, 'Free Website', 'NO');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5175, 420, 'Currency Symbol', '$');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5176, 421, 'PayPal Currency Code', 'USD');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5177, 422, 'PayPal Account', 'paypal@paypal.com');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5178, 423, 'Address for the Cheques', 'cheques address goes here');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5179, 424, 'Bank Account Information', '');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5180, 425, 'Date Format', 'd/m h:iA');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5181, 426, 'Hour Format', 'g:iA');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5182, 427, 'Show Top Bar on the User Sites', 'NO');
INSERT INTO websiteadmin_settings (id_key, id, description, `value`) VALUES(5183, 428, 'Authorized IPs for the admin panel', '');

CREATE TABLE websiteadmin_statistics (
  id int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(25) NOT NULL DEFAULT '',
  `host` varchar(30) NOT NULL DEFAULT '',
  referer varchar(150) NOT NULL DEFAULT '',
  `page` varchar(50) NOT NULL DEFAULT '',
  lang char(2) NOT NULL DEFAULT '',
  aff varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (id),
  KEY `host` (`host`)
) ENGINE=MyISAM;

CREATE TABLE websiteadmin_support_questions (
  id int(11) NOT NULL AUTO_INCREMENT,
  `date` int(11) NOT NULL DEFAULT '0',
  `user` varchar(100) NOT NULL DEFAULT '',
  question text NOT NULL,
  answer text NOT NULL,
  answered tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (id)
) ENGINE=MyISAM;

CREATE TABLE websiteadmin_templates (
  id int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  description varchar(255) DEFAULT NULL,
  html text,
  PRIMARY KEY (id)
) ENGINE=MyISAM;

INSERT INTO websiteadmin_templates (id, `name`, description, html) VALUES(5, 'WSCREATOR  DEFAULT TEMPLATE', '', '<html>\r\n<head>\r\n<title><wsa title/></title>\r\n<meta name="description" content="<wsa description/>">\r\n<meta name="keywords" content="<wsa keywords/>">\r\n<link rel="stylesheet" href="images/styles.css">\r\n\r\n</head>\r\n<body>\r\n\r\n<div id="header">\r\n\r\n\r\n	<div class="container">\r\n		<wsa login_form/>\r\n		<div class="clear"></div>\r\n		<div id="main_menu">\r\n			<wsa menu/>\r\n		</div>\r\n		\r\n		<div style="float:right;margin-top:35px">\r\n			<img style="float:right" src="images/websitecreator.png" width="249" height="34">\r\n		</div>\r\n		\r\n		\r\n		\r\n	</div>\r\n</div>\r\n\r\n<div id="main">\r\n<!--main content area-->		\r\n	<wsa content/>\r\n	<wsa form/>\r\n<!--end main content area-->\r\n</div>\r\n\r\n<div id="footer">\r\n	<br>\r\n	<wsa bottom_menu/>\r\n	<br><br>\r\n	<span>Powered by <a href="http://www.wscreator.com" >WSCreator</a></span>\r\n		\r\n</div>\r\n\r\n</body>\r\n</html>');

CREATE TABLE websiteadmin_user_pages (
  id int(11) NOT NULL AUTO_INCREMENT,
  parent_id varchar(20) NOT NULL DEFAULT '0',
  active_en tinyint(4) NOT NULL DEFAULT '1',
  name_en varchar(255) NOT NULL DEFAULT '',
  link_en varchar(255) NOT NULL DEFAULT '',
  description_en text NOT NULL,
  keywords_en text NOT NULL,
  html_en text NOT NULL,
  custom_link_en text NOT NULL,
  `user` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (id),
  KEY parent_id (parent_id),
  KEY `user` (`user`),
  KEY active_en (active_en)
) ENGINE=MyISAM;

CREATE TABLE websiteadmin_user_statistics (
  id int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(25) NOT NULL DEFAULT '',
  `host` varchar(30) NOT NULL DEFAULT '',
  referer varchar(150) NOT NULL DEFAULT '',
  `page` varchar(50) NOT NULL DEFAULT '',
  `user` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (id),
  KEY `user` (`user`)
) ENGINE=MyISAM;

CREATE TABLE websiteadmin_user_templates (
  id int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  description varchar(255) DEFAULT NULL,
  html text,
  `user` varchar(100) NOT NULL DEFAULT '',
  menu text NOT NULL,
  PRIMARY KEY (id),
  KEY `user` (`user`)
) ENGINE=MyISAM;

CREATE TABLE websiteadmin_weblog (
  id int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(100) NOT NULL DEFAULT '',
  description text NOT NULL,
  author text NOT NULL,
  logo text NOT NULL,
  author_image int(11) NOT NULL DEFAULT '0',
  format int(11) NOT NULL DEFAULT '1',
  background_color varchar(10) NOT NULL DEFAULT '#ffffff',
  header_background_color varchar(10) NOT NULL DEFAULT '#F9F9F9',
  links_color varchar(10) NOT NULL DEFAULT '#FFBA27',
  font_family varchar(100) NOT NULL DEFAULT 'arial',
  font_size varchar(10) NOT NULL DEFAULT '12',
  main_area_background_color varchar(20) NOT NULL DEFAULT '#ffffff',
  font_color varchar(10) NOT NULL DEFAULT '#AAAAAA',
  meta_title varchar(255) NOT NULL DEFAULT '',
  meta_description text NOT NULL,
  meta_keywords text NOT NULL,
  header_font_color varchar(30) NOT NULL DEFAULT '#FFBA27',
  header_font_size varchar(10) NOT NULL DEFAULT '16',
  shadows_color varchar(10) NOT NULL DEFAULT '#f0f0f0',
  author_image_width varchar(20) NOT NULL DEFAULT '',
  author_image_height varchar(20) NOT NULL DEFAULT '',
  logo_text text NOT NULL,
  zone1 text NOT NULL,
  zone2 text NOT NULL,
  zone3 text NOT NULL,
  zone4 text NOT NULL,
  PRIMARY KEY (id),
  KEY `user` (`user`),
  KEY author_image (author_image)
) ENGINE=MyISAM;
