<?php
if (!defined ('TYPO3_MODE')) die('Access denied.');

if (TYPO3_MODE == 'BE')	{
	t3lib_extMgm::insertModuleFunction(
		'web_func',
		'tx_vegb2cmnt_modfunc1',
		t3lib_extMgm::extPath($_EXTKEY).'modfunc1/class.tx_vegb2cmnt_modfunc1.php',
		'LLL:EXT:vegb2cmnt/locallang_db.xml:moduleFunction.tx_vegb2cmnt_modfunc1'
	);
}

// Extend tx_comments_comments
$tempColumns = Array (
	'tx_vegb2cmnt_origuid' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:vegb2cmnt/locallang_db.php:tx_vegb2cmnt_origuid',
		//'displayCond' => 'FIELD:tx_vegb2cmnt_origuid:<>:',
		'config' => array(
			//'readOnly'=> true,
			'type' => 'group',
			'internal_type' => 'db',
			'allowed' => 'tx_veguestbook_entries',
			'size' => 1,
			'minitems' => 0,
			'maxitems' => 1,
			'wizards' => Array(
				'_PADDING' => 1,
				'_VERTICAL' => 1,
				'edit' => Array(
					'type' => 'popup',
					'title' => 'LLL:EXT:vegb2cmnt/locallang_db.xml:tx_vegb2cmnt_origuid.wizard',
					'script' => 'wizard_edit.php',
					'popup_onlyOpenIfSelected' => 1,
					'icon' => 'edit2.gif',
					'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
				),
			),
		),
	),
);
t3lib_div::loadTCA('tx_comments_comments');
t3lib_extMgm::addTCAcolumns('tx_comments_comments', $tempColumns, 1);
t3lib_extMgm::addToAllTCAtypes('tx_comments_comments', 'tx_vegb2cmnt_origuid');
unset($tempColumns);
?>