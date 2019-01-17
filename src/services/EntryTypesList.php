<?php
/**
 * Craft Entry Type Sources plugin for Craft CMS 3.x
 *
 * Test
 *
 * @link      http://kartoteket.as/
 * @copyright Copyright (c) 2018 Svale
 */

namespace threebyfive\craftentrytypesources\services;

use threebyfive\craftentrytypesources\CraftEntryTypeSources;

use Craft;
use craft\base\Component;
use craft\elements\Entry;
use craft\models\Section;
use craft\events\RegisterElementSourcesEvent;

/**
 * EntryTypesList Service
 *
 * All of your plugin’s business logic should go in services, including saving data,
 * retrieving data, etc. They provide APIs that your controllers, template variables,
 * and other plugins can interact with.
 *
 * https://craftcms.com/docs/plugins/services
 *
 * @author    Svale
 * @package   CraftEntryTypeSources
 * @since     0.0.1
 */
class EntryTypesList extends Component
{
    // Public Methods
    // =========================================================================

    /**
     * This function can literally be anything you want, and you can have as many service
     * functions as you want
     *
     * From any other plugin file, call it like this:
     *
     *     CraftEntryTypeSources::$plugin->entryTypeSources->exampleService()
     *
     * @return mixed
     */
    public function createEntryTypesList(RegisterElementSourcesEvent $event)
    {

        // print_r($event);die();
        $result = [];
        $result[] = ['heading' => Craft::t('app', 'TYPER')];

        // Find available sections
        $sections = Craft::$app->getSections()->getAllSections();
        foreach ($sections as $section) {
            if (Craft::$app->getUser()->checkPermission('editEntries:'.$section->id)) {
                $entryTypes = $section->getEntryTypes();
                $totalEntryTypes = count($entryTypes);
                // $sectionName = $totalEntryTypes > 1 ? $section->name . ': ' : '';

                if($totalEntryTypes > 1) {
                    foreach ($entryTypes as $entryType) {

                        $result[] = [
                            'key'      => 'section:' . $section->id.'-'.$entryType->id,
                            'label'    => $entryType->name,
                            // 'sites'    => [1],  // Optional, see: https://docs.craftcms.com/api/v3/craft-base-elementinterface.html#public-methods
                            'data'     => [
                                'type' => $section->type,
                                'handle' => $section->handle,
                                'entry-type' => $entryType->handle
                            ],
                            'criteria' => [
                                'sectionId' => $section->id,
                                'editable' => 1, // @todo: inherit this from section/$event->source ??!?
                                'type' => $entryType->handle
                            ],
                        ];
    
                        // print_r($result); die();
                        // $commands[] = [
                        //     'name' => $sectionName . $entryType->name,
                        //     'url'  => $entryType->getCpEditUrl()
                        // ];
                    }
                }

                // $sectionName = $totalEntryTypes > 1 ? $section->name . ': ' : '';
                // $result[] = ['heading' => Craft::t('app', $sectionName)];
                // foreach ($entryTypes as $entryType) {

                //     $result[] = [
                //         'key'      => 'section:' . $section->id,
                //         'label'    => $$section->name . $entryType->name,
                //         // 'data'     => ['url' => $url],
                //         'criteria' => ['type' => $entryType->id],
                //     ];

                //     // var_dump($result); die();
                //     // $commands[] = [
                //     //     'name' => $sectionName . $entryType->name,
                //     //     'url'  => $entryType->getCpEditUrl()
                //     // ];
                // }
            }
        }

        // @todo: set expand or replace as settings option
        // Expand as nested
        $event->sources[3]['nested'] = $result;

        // Replace original sections list with new types list. @todo: If replce, 
        // array_splice($event->sources, 3, 1, $result);

        // BEDBUG
        // unset($event->sources[5]);
        // print_r($event->sources); die();
        // $event->sources = [];
        // die();

        // Check our Plugin's settings for `someAttribute`
        // if (CraftEntryTypeSources::$plugin->getSettings()->someAttribute) {
        // }

        // return $result;
    }
}
