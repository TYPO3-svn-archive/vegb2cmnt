<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2007 Dmitry Dulepov <dmitry@typo3.org>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/


require_once(PATH_t3lib.'class.t3lib_extobjbase.php');



/**
 * Module extension (addition to function menu) 'Convert ve_guestbook records to comments records' for the 'vegb2cmnt' extension.
 *
 * @author	Dmitry Dulepov <dmitry@typo3.org>
 * @package	TYPO3
 * @subpackage	tx_vegb2cmnt
 */
class tx_vegb2cmnt_modfunc1 extends t3lib_extobjbase {

	var $id;

	/**
	 * Returns the module menu
	 *
	 * @return	Array with menuitems
	 */
//	function modMenu()	{
//		return array (
//			'tx_vegb2cmnt_modfunc1_check' => '',
//		);
//	}

	/**
	 * Main method of the module
	 *
	 * @return	HTML
	 */
	function main()	{
		$this->id = intval(t3lib_div::_GP('id'));

		$content = $this->pObj->doc->spacer(5);
		if (t3lib_div::_POST('submitted')) {
			$text = $this->convertEntries();
		}
		else {
			$text = $this->showForm();
		}
		$text = $this->pObj->doc->spacer(5) . $text;
		$content .= $this->pObj->doc->section($GLOBALS['LANG']->getLL('title'), $text, 0, 1);
		return $content;
	}

	private function showForm() {
		// Check if there are any ve_guestbook entries on this page
		$info = t3lib_BEfunc::getRecordRaw('tx_veguestbook_entries', 'pid=' . $this->id . t3lib_BEfunc::deleteClause('tx_veguestbook_entries'), 'COUNT(*) AS t');
		if ($info['t'] == 0) {
			$content = $GLOBALS['LANG']->getLL('no.records');
		}
		else {
			$content .= sprintf($GLOBALS['LANG']->getLL('prompt'), $info['t']);
			$content .= '<br /> <br />';
			$content .= '<input type="submit" name="submitted" value="' . $GLOBALS['LANG']->getLL('convert') . '" />';
		}
		return $content;
	}

	private function convertEntries() {
		$rs = $GLOBALS['TYPO3_DB']->exec_SELECTquery('*', 'tx_veguestbook_entries',
						'pid=' . $this->id . t3lib_BEfunc::deleteClause('tx_veguestbook_entries'));
		$recs = array();
		$count = 0;
		while (false !== ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($rs))) {
			if (count($recs) == 10) {
				$this->insertRecords($recs);
				$recs = array();
			}
			$entry = array(
				'pid' => $this->id,
				'crdate' => $row['crdate'],
				'tstamp' => $row['tstamp'],
				'hidden' => $row['hidden'],
				'approved' => !$row['hidden'],
				'firstname' => $row['firstname'],
				'lastname' => $row['surname'],
				'email' => $row['email'],
				'homepage' => $row['homepage'],
				'location' => $row['place'],
				'content' => $row['entry'],
				'remote_addr' => $row['remote_addr'],
				'tx_vegb2cmnt_origuid' => $row['uid'],
			);
			if ($row['uid_tt_news']) {
				$entry['external_prefix'] = 'tx_ttnews';
				$entry['external_ref'] = 'tt_news_' . $row['uid_tt_news'];
			}
			else {
				$entry['external_prefix'] = 'pages';
			}
			$recs[] = $entry;
			$count++;
		}
		$GLOBALS['TYPO3_DB']->sql_free_result($rs);
		$this->insertRecords($recs);
		return sprintf($GLOBALS['LANG']->getLL('imported'), $count);
	}

	private function insertRecords(&$recs) {
		foreach ($recs as $rec) {
			$GLOBALS['TYPO3_DB']->exec_INSERTquery('tx_comments_comments', $rec);
		}
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/vegb2cmnt/modfunc1/class.tx_vegb2cmnt_modfunc1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/vegb2cmnt/modfunc1/class.tx_vegb2cmnt_modfunc1.php']);
}

?>