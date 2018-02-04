<?php
/**
 *
 * @category        module
 * @package         adv
 * @author          Konstantin Polyakov
 * @link            http://dosmth.ru/
 * @license         http://www.gnu.org/licenses/gpl.html
 * @platform        WebsiteBaker 2.8.3
 *
 */

if(!defined('WB_PATH')) die(header('Location: index.php'));  

include(WB_PATH.'/modules/adv/lib.class.adv.php');
$clsAdv = new Adv($database, 0, 0);

$clsAdv->install();