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

$path_podnogami = WB_PATH.'/include/podnogami/include.php';
if (file_exists($path_podnogami)) include($path_podnogami);
else echo "<script>console.log('Модуль рекламы требует модуль Подногами')</script>";
//if (!defined('FUNCTIONS_FILE_LOADED')) require_once(WB_PATH.'/framework/functions.php');

class Adv extends Addon {

    function __construct($database, $page_id, $section_id) {
        parent::__construct('adv', $page_id, $section_id);
        $this->db = $database;
        $this->tbl_banner = "`".TABLE_PREFIX."mod_adv_banner`";
        $this->tbl_category = "`".TABLE_PREFIX."mod_adv_category`";
        $this->tbl_category_banner= "`".TABLE_PREFIX."mod_adv_category_banner`";
        
    }
    
    function install() {
        $this->db->query("DROP TABLE IF EXISTS {$this->tbl_banner}");
	$sql = "CREATE TABLE {$this->tbl_banner} (
	      `banner_id` int(11) NOT NULL AUTO_INCREMENT,
	      `image` varchar(255) NOT NULL,
	      `title` varchar(255) NOT NULL,
	      `url` varchar(255) NOT NULL,
	      `is_active` int(11) NOT NULL DEFAULT '0',
	      `show_times_max` int(11) NOT NULL DEFAULT '10',
	      `show_times_current` int(11) NOT NULL DEFAULT '0',
	      PRIMARY KEY (`banner_id`)
	    )";
	$this->db->query($sql);

	$this->db->query("DROP TABLE IF EXISTS {$this->tbl_category}");
	$sql = "CREATE TABLE {$this->tbl_category} (
	      `category_id` int(11) NOT NULL AUTO_INCREMENT,
	      `category_name` int(11) NOT NULL,
	      `show_banner_index` int(11) NOT NULL DEFAULT '0',
	      PRIMARY KEY (`category_id`)
	    )";
	$this->db->query($sql);

	$this->db->query("DROP TABLE IF EXISTS {$this->tbl_category_banner}");
	$sql = "CREATE TABLE {$this->tbl_category_banner} (
	      `category_banner_id` int(11) NOT NULL AUTO_INCREMENT,
	      `category_id` int(11) NOT NULL,
	      `banner_id` int(11) NOT NULL DEFAULT '1',
	      PRIMARY KEY (`category_banner_id`)
	    )";
	$this->db->query($sql);
    }

    function get_category($sets=null) {
        if ($sets === null) $sets = [];        
        return select_rows($this->tbl_category, '*', null);
    }

    function create_category($fields) {
        return insert_rows($this->tbl_category, array_keys($fields), array_values($fields));
    }
    
    function get_banner($sets=null) {
        if ($sets === null) $sets = [];
        
        //if (isset($sets['category_id'])) $category_id = $sets['category_id'] else $category_id = null;        
        
        $tbls = [$this->tbl_banner];
        if (isset($sets['category_id'])) $tbls = array_merge([$this->tbl_category, $this->tbl_category_banner], $tbls);
        
        $wheres = [];
        if (isset($sets['category_id'])) {
            $where[] = $this->tbl_category_banner.'`banner_id`='.$this->tbl_banner.'`banner_id`';
            $where[] = $this->tbl_category_banner.'`category_id`='.$this->tbl_category.'`category_id`';
            $where[] = $this->tbl_caetgory.'`category_id`='.process_value($category_id);
        }
        
        //$_sql = build_select($this->category_id, '`banner_id`', "'category_id'=".process_value($category_id));
        
        return select_rows($tbls, '*', implode(' AND ', $wheres));
    }
    
    function create_banner($category_id, $fields) {
        $r = insert_rows($this->tbl_banner, array_keys($fields), array_values($fields));
        if (gettype($r)) return $r;

        return insert_rows($this->tbl_category_banner, ['category_id', 'banner_id'], [$category_id, $this->db->getLastRowId()]);
    }
    
    function update_banner($banner_id, $fields) {
        return update_rows($this->tbl_banner, $fields, '`banner_id`='.process_value($banner_id));
    }
}

?>