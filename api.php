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

$action = $_POST['action'];

require('../../config.php');
require_once(WB_PATH.'/framework/functions.php');

require_once(WB_PATH."/framework/class.admin.php");
$admin = new Admin("Start", "start", false, false);

include(WB_PATH.'/modules/adv/lib.class.adv.php');
$clsAdv = new Adv($database);

function check_authed() {
	global $admin;
	if (!$admin->is_authenticated()) {
		print_error("Доступ в админ-панель разрешён только зарегистрированным пользователям. Пожалуйста, войдите или зарегистрируйтесь.");
	} 
}

if (substr($action, 0, strlen('window')) == 'window') {
    $loader = new Twig_Loader_Filesystem($clsAdv->pathTemplates);
    $twig = new Twig_Environment($loader);
}

if ($action=='window_banner_list') {

    check_authed();
    
    $category_id = $fd->f('category_id', [['integer', 'Не указан идентификатор рекламного места']], 'fatal');

    $banners = [];
    $_banners = $clsAdv->get_banner(['category_id'=>$category_id]);
    if (gettype($_banners) === 'string') print_error($_banners);
    else {
        while($banner = $_banners->fetchRow(MYSQLI_ASSOC)) $banners[] = $banner;
    }

    print_success(
        $twig->render('banner_list.twig', [
            'banners'=>$banners,
            'WB_URL'=>WB_URL,
            'category_id'=>$category_id,
        ]),
        []
   );

} else if ($action=='window_create_category') {

    check_authed();

    print_success(
        $twig->render('create_category.twig', []),
        []
   );

} else if ($action=='create_category') {

    check_authed();

    $category_name = $fd->f('category_name', [['1', 'Не указано название рекламного места']], 'fatal');
    
    $r = $clsAdv->create_category(['category_name'=>$category_name]);
    if (gettype($r) === 'string') print_error($r);
    
    print_success('Рекламное место создано!');

} else if ($action=='create_banner') {

    check_authed();

    $category_id = $fd->f('category_id', [['integer', 'Не указан идентификатор рекламного места']], 'fatal');

    $clsAdv->create_banner($category_id, [
        'image'=>'',
        'title'=>'Новый баннер',
        'url'=>'',
    ]);

} else if ($action=='update_banner') {

    check_authed();

 } else if ($action=='window_clone_banner') {

    check_authed();
    
} else if ($action=='clone_banner') {

    check_authed();

} else if ($action=='') {

    check_authed();

} else if ($action=='') {

    check_authed();

} else {
    check_authed();
    print_error('неврный API');
}

?>