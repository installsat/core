<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_Validate
 * @subpackage Sitemap
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */

/**
 * @namespace
 */
namespace Zend\Validator\Sitemap;

/**
 * Validates whether a given value is valid as a sitemap <priority> value
 *
 * @link       http://www.sitemaps.org/protocol.php Sitemaps XML format
 *
 * @uses       \Zend\Validator\AbstractValidator
 * @category   Zend
 * @package    Zend_Validate
 * @subpackage Sitemap
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Priority extends \Zend\Validator\AbstractValidator
{
    /**
     * Validation key for not valid
     *
     */
    const NOT_VALID = 'sitemapPriorityNotValid';
    const INVALID   = 'sitemapPriorityInvalid';

    /**
     * Validation failure message template definitions
     *
     * @var array
     */
    protected $_messageTemplates = array(
        self::NOT_VALID => "'%value%' is not a valid sitemap priority",
        self::INVALID   => "Invalid type given. Numeric string, integer or float expected",
    );

    /**
     * Validates if a string is valid as a sitemap priority
     *
     * @link http://www.sitemaps.org/protocol.php#prioritydef <priority>
     *
     * @param  string  $value  value to validate
     * @return boolean
     */
    public function isValid($value)
    {
        if (!is_numeric($value)) {
            $this->error(self::INVALID);
            return false;
        }

        $this->setValue($value);
        $value = (float) $value;
        if ($value < 0 || $value > 1) {
            $this->error(self::NOT_VALID);
            return false;
        }

        return true;
    }
}