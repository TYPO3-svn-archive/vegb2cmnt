<?php

########################################################################
# Extension Manager/Repository config file for ext: "vegb2cmnt"
#
# Auto generated 14-12-2007 21:03
#
# Manual updates:
# Only the data in the array - anything else is removed by next write.
# "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 've_guestbook to comments',
	'description' => 'Convert ve_guestbook entries to comments entries',
	'category' => 'module',
	'author' => 'Dmitry Dulepov',
	'author_email' => 'dmitry@typo3.org',
	'shy' => '',
	'dependencies' => 'comments,ve_guestbook',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'experimental',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => 'tx_comments_comments',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'author_company' => '',
	'version' => '0.2.0',
	'constraints' => array(
		'depends' => array(
			'comments' => '',
			've_guestbook' => '',
			'php' => '5.0.0-0.0.0',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:7:{s:9:"ChangeLog";s:4:"fbe7";s:12:"ext_icon.gif";s:4:"273f";s:14:"ext_tables.php";s:4:"4ea8";s:14:"ext_tables.sql";s:4:"6b9b";s:16:"locallang_db.xml";s:4:"bec9";s:40:"modfunc1/class.tx_vegb2cmnt_modfunc1.php";s:4:"85b5";s:22:"modfunc1/locallang.xml";s:4:"59c4";}',
	'suggests' => array(
	),
);

?>