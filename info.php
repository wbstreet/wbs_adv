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

/*
2017-07-30 - первая версия
*/

/* -------------------------------------------------------- */
// Must include code to stop this file being accessed directly
if(defined('WB_PATH') == false) { die('Illegale file access /'.basename(__DIR__).'/'.basename(__FILE__).''); }
/* -------------------------------------------------------- */

$module_directory   = 'adv';
$module_name        = 'Advertising v1.0';
$module_type        = 'addon';
$module_function    = 'tool';
$module_version     = '1.0.0';
$module_platform    = '2.10.0';
$module_author      = 'Konstantin Polyakov';
$module_license     = 'GNU General Public License';
$module_description = 'Рекламные кампании для Вашего сайта';

$links = ['media_efects']; // зависимости