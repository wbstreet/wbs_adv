"use strict";

class mod_adv_Main {

    constructor() {
        this.url_mod = WB_URL + '/modules/adv/'
        this.url_api = this.url_mod + 'api.php';
        this.toggle_banner_list = this.toggle_banner_list.bind(this);
        this.create_category = this.create_category.bind(this);
    }
	
    toggle_banner_list(category_id) {
        let holder = document.getElementById('banner_list'+category_id);
	
	if (holder.children.length > 0) {holder.innerHTML = ''; return;}
	
        sendform('window_banner_list', holder, {
	    url_api: this.url_api,
	    data: {category_id: category_id},
	    arg_func_success: holder,
	    func_success: function(res, holder) {
                holder.innerHTML = res['data'];
	    }
        });
    }
    
    create_category(btn) {
        sendform('create_category', btn, {
	    url_api: this.url_api,
	    func_success: function(res, arg) {
	        location.href = location.href;
	    }
	})
    }

}