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

include(WB_PATH.'/modules/adv/lib.class.adv.php');
$clsAdv = new Adv($database);

include_once(WB_PATH."/modules/windows/include.php");
if(function_exists('include_mod_windows')) include_mod_windows();
include_once(WB_PATH."/modules/media_effects/include.php");
if(function_exists('include_mod_media_effects')) include_mod_media_effects(['functions.js']);

?>

<style>
    h1, h2, h3 {
        background: #eee;
    }
</style>

<script>
    "use strict"
    
    let mod_adv = new mod_adv_Main();
</script>

<h1>Управление рекламной кампанией</h1>

<br>

<input type='button' value='Добавить рекламное место' onclick="W.open_by_api('create_category_window')">
<br>

<h2>Рекламные места</h2>

<?php
$categories = $clsAdv->get_category();
if ($categories === null) {echo "Рекламные места отсутствуют.";}
else if (gettype($categories) === 'string' ) print_error($categories);

while ($categories !== null && $category = $categories ->fetchRow(MYSQLI_ASSOC)) {
    echo "<div> <span onclick=\"mod_adv.toggle_banner_list({$category['category_id']})\">Баннеры</span> {$category['name']} </div>
          <div id='banner_list{$category['category_id']}'> </div>
    ";
}

?>