<?php
/**
 * Craft Entry Type Sources plugin for Craft CMS 3.x
 *
 * Test
 *
 * @link      http://kartoteket.as/
 * @copyright Copyright (c) 2018 Svale
 */

namespace threebyfive\craftentrytypesources\models;

use threebyfive\craftentrytypesources\CraftEntryTypeSources;

use Craft;
use craft\base\Model;

/**
 * CraftEntryTypeSources Settings Model
 *
 * This is a model used to define the plugin's settings.
 *
 * Models are containers for data. Just about every time information is passed
 * between services, controllers, and templates in Craft, it’s passed via a model.
 *
 * https://craftcms.com/docs/plugins/models
 *
 * @author    Svale
 * @package   CraftEntryTypeSources
 * @since     0.0.1
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * List Entry types 
     *
     * @var boolean
     */
    public $listEntryTypes = true;


    /**
     * Some field model attribute
     *
     * @var string
     */
    public $someAttribute = 'Some Default';

    // Public Methods
    // =========================================================================

    /**
     * Returns the validation rules for attributes.
     *
     * Validation rules are used by [[validate()]] to check if attribute values are valid.
     * Child classes may override this method to declare different validation rules.
     *
     * More info: http://www.yiiframework.com/doc-2.0/guide-input-validation.html
     *
     * @return array
     */
    public function rules()
    {
        return [
            ['someAttribute', 'string'],
            ['someAttribute', 'default', 'value' => 'Some Default'],
        ];
    }
}
