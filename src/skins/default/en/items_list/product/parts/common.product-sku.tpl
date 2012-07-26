{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Item SKU
 *
 * @author    Creative Development LLC <info@cdev.ru>
 * @copyright Copyright (c) 2011-2012 Creative Development LLC <info@cdev.ru>. All rights reserved
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://www.litecommerce.com/
 *
 * @ListChild (list="itemsList.product.table.customer.columns", weight="10")
 *}
<span class="product-sku">{if:product.sku}{product.sku}{else:}&nbsp;{end:}</span>
