<?php
defined('TYPO3_MODE') || die('Access denied.');

$GLOBALS['TYPO3_CONF_VARS']['SYS']['locallangXMLOverride']['EXT:my_mask_export/Resources/Private/Language/locallang_db.xlf']['my_maskexport_sitepackage'] =
    'EXT:my_maskexport_sitepackage/Resources/Private/Language/mymaskexport_locallang_db.xlf';

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms']['db_new_content_el']['wizardItemsHook']['my_maskexport_sitepackage'] =
    \IchHabRecht\MyMaskexportSitepackage\Hooks\WizardItemHook::class;
