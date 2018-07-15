<?php
defined('TYPO3_MODE') || die('Access denied.');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'my_maskexport_sitepackage',
    'Configuration/TypoScript/',
    'my_maskexport_sitepackage'
);
