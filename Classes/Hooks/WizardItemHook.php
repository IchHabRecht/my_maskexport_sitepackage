<?php

namespace IchHabRecht\MyMaskexportSitepackage\Hooks;

use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Backend\Wizard\NewContentElementWizardHookInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class WizardItemHook implements NewContentElementWizardHookInterface
{
    public function manipulateWizardItems(&$wizardItems, &$parentObject)
    {
        $pageInfo = $parentObject->getPageInfo();
        $config = BackendUtility::getPagesTSconfig($pageInfo['uid'])['mod.']['wizards.']['newContentElement.']['wizardItems.'] ?? [];
        if (empty($config)) {
            return;
        }

        $orderedWizardItems = [];
        foreach ($config as $groupKey => $group) {
            $groupKey = rtrim($groupKey, '.');
            $showItems = array_unique(GeneralUtility::trimExplode(',', $group['show'], true));

            // Get all elements from $wizardItems for the current group
            $currentGroupWizardItems = array_filter($wizardItems, function ($key) use ($groupKey) {
                return $key === $groupKey || strpos($key, $groupKey . '_') === 0;
            }, ARRAY_FILTER_USE_KEY);

            // If group is empty or asterisk only, no special order is needed
            if (empty($currentGroupWizardItems)
                || count($showItems) === 1 && $showItems[0] === '*'
            ) {
                $orderedWizardItems += $currentGroupWizardItems;
                continue;
            }

            // Get an ordered list of items before any asterisk
            $preShowItems = array_flip(array_map(function ($item) use ($groupKey) {
                return $groupKey . '_' . $item;
            },
                array_slice($showItems, 0, array_search('*', $showItems) + 1)
            ));
            // Get an ordered list of items after any asterisk
            $postShowItems = array_flip(array_map(function ($item) use ($groupKey) {
                return $groupKey . '_' . $item;
            },
                array_slice($showItems, array_search('*', $showItems) + 1)
            ));

            // First add the group itself
            $orderedWizardItems += array_splice(
                $currentGroupWizardItems,
                array_search($groupKey, array_keys($currentGroupWizardItems)),
                1
            );

            // Add items from $preShowItems ordered by key
            $orderedWizardItems += array_replace(
                array_intersect_key($preShowItems, $currentGroupWizardItems),
                array_intersect_key($currentGroupWizardItems, $preShowItems)
            );
            // Add items covered by any asterisk
            $orderedWizardItems += array_diff_key($currentGroupWizardItems, $preShowItems, $postShowItems);
            // Add postShowItems from $postShowItems ordered by key
            $orderedWizardItems += array_replace(
                array_intersect_key($postShowItems, $currentGroupWizardItems),
                array_intersect_key($currentGroupWizardItems, $postShowItems)
            );
        }

        $wizardItems = $orderedWizardItems;
    }
}
