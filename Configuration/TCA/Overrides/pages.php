<?php
defined('TYPO3_MODE') || die('Access denied.');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerPageTSConfigFile(
    'my_maskexport_sitepackage',
    'Configuration/PageTSconfig/BackendPreview.tsconfig',
    'my_maskexport_sitepackage: Backend preview templates'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerPageTSConfigFile(
    'my_maskexport_sitepackage',
    'Configuration/PageTSconfig/NewContentElementWizard.tsconfig',
    'my_maskexport_sitepackage: New content element wizard'
);
