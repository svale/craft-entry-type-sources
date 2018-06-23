<?php
/**
 * Craft Entry Type Sources plugin for Craft CMS 3.x
 *
 * Test
 *
 * @link      http://kartoteket.as/
 * @copyright Copyright (c) 2018 Svale
 */

namespace threebyfive\craftentrytypesources;

use threebyfive\craftentrytypesources\services\EntryTypesList as EntryTypesList;
use threebyfive\craftentrytypesources\models\Settings;

use Craft;
use craft\base\Plugin;
use craft\base\Element;
use craft\services\Plugins;
//use craft\events\PluginEvent;
use craft\web\UrlManager;
use craft\elements\Entry;
use craft\events\RegisterElementSourcesEvent;

use yii\base\Event;

/**
 * Training wheels plugin. Based on
 * https://github.com/verbb/expanded-singles/blob/craft-3/src/ExpandedSingles.php
 * https://github.com/james1238/EntryTypeSources/blob/master/entrytypesources/EntryTypeSourcesPlugin.php
 * https://pluginfactory.io/
 *
 * Other references:
 * https://craftcms.stackexchange.com/questions/13998/using-search-criteria-in-modifyentrysources-plugin
 * https://docs.craftcms.com/api/v3/craft-events-registerelementsourcesevent.html
 * https://github.com/verbb/expanded-singles/blob/craft-3/src/services/SinglesList.php
 * https://github.com/james1238/EntryTypeSources/blob/master/entrytypesources/EntryTypeSourcesPlugin.php
 *  https://nystudio107.com/blog/so-you-wanna-make-a-craft-3-plugin
 *  
 * https://craftcms.com/docs/plugins/introduction
 *
 * @author    Svale
 * @package   CraftEntryTypeSources
 * @since     0.0.1
 *
 * @property  EntryTypeSourcesService $entryTypeSources
 * @property  Settings $settings
 * @method    Settings getSettings()
 */
class CraftEntryTypeSources extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * Static property that is an instance of this plugin class so that it can be accessed via
     * CraftEntryTypeSources::$plugin
     *
     * @var CraftEntryTypeSources
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * To execute your plugin’s migrations, you’ll need to increase its schema version.
     *
     * @var string
     */
    public $schemaVersion = '0.0.1';

    // Public Methods
    // =========================================================================

    /**
     * Set our $plugin static property to this class so that it can be accessed via
     * CraftEntryTypeSources::$plugin
     *
     * Called after the plugin class is instantiated; do any one-time initialization
     * here such as hooks and events.
     *
     * If you have a '/vendor/autoload.php' file, it will be loaded for you automatically;
     * you do not need to load it in your init() method.
     *
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        // Register Components (Services)
        $this->setComponents([
            'entryTypesList' => EntryTypesList::class,
        ]);

        // Modified the entry index sources
        Event::on(
            Entry::class,
            Element::EVENT_REGISTER_SOURCES,
            function(RegisterElementSourcesEvent $event) {

                // Have we enabled the plugin?
                if ($this->getSettings()->listEntryTypes) {
                    $this->entryTypesList->createEntryTypesList($event);
                    // foreach ($event->sources as $source) {
                        // var_dump($source); die();
                        // if (array_key_exists('key', $source) && $source['key'] === 'singles') {
                        // }
                    // }
                }
            }
        );

        // Do something after we're installed
        // Event::on(
        //     Plugins::class,
        //     Plugins::EVENT_AFTER_INSTALL_PLUGIN,
        //     function (PluginEvent $event) {
        //         if ($event->plugin === $this) {
        //             // We were just installed
        //         }
        //     }
        // );

/**
 * Logging in Craft involves using one of the following methods:
 *
 * Craft::trace(): record a message to trace how a piece of code runs. This is mainly for development use.
 * Craft::info(): record a message that conveys some useful information.
 * Craft::warning(): record a warning message that indicates something unexpected has happened.
 * Craft::error(): record a fatal error that should be investigated as soon as possible.
 *
 * Unless `devMode` is on, only Craft::warning() & Craft::error() will log to `craft/storage/logs/web.log`
 *
 * It's recommended that you pass in the magic constant `__METHOD__` as the second parameter, which sets
 * the category to the method (prefixed with the fully qualified class name) where the constant appears.
 *
 * To enable the Yii debug toolbar, go to your user account in the AdminCP and check the
 * [] Show the debug toolbar on the front end & [] Show the debug toolbar on the Control Panel
 *
 * http://www.yiiframework.com/doc-2.0/guide-runtime-logging.html
 */
        Craft::info(
            Craft::t(
                'craft-entry-type-sources',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

    /**
     * Creates and returns the model used to store the plugin’s settings.
     *
     * @return \craft\base\Model|null
     */
    protected function createSettingsModel()
    {
        return new Settings();
    }

    /**
     * Returns the rendered settings HTML, which will be inserted into the content
     * block on the settings page.
     *
     * @return string The rendered settings HTML
     */
    protected function settingsHtml(): string
    {

        $allSections = Craft::$app->sections->getAllSections();


        return Craft::$app->view->renderTemplate(
            'craft-entry-type-sources/settings',
            [
                'settings' => $this->getSettings()
            ]
        );
    }
}
