<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Navigation {
	public function get_menu ($menus) {
		$menuString = '';

		foreach ($menus as $menu) {
			if (isset($menu['menu'])) {
				$menuString .= '<li class="dropdown"><a href="'.$menu['url'].'" class="dropdown-toggle" data-toggle="dropdown">'.$menu['name'].' <span class="caret"></span></a>';
				$menuString .= '<ul class="dropdown-menu" role="menu">';
				$menuString .= $this->get_menu($menu['menu']);
				$menuString .= '</ul>';
				$menuString .= '</li>';
			} else {
				$menuString .= '<li><a href="'.$menu['url'].'">'.$menu['name'].'</a></li>';
			}
		} 

		return $menuString;
	}

	public function get_profiles ($profiles) {
		$menuString = '';

		$menuString .= '<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Profiles<span class="caret"></span></a>';
		$menuString .= '<ul class="dropdown-menu" role="menu">';
		$menuString .= '<li><a href="/profile/">See all profiles</a></li>';
		$menuString .= '<li class="divider"></li>';
		foreach ($profiles as $key => $profile) {
			$menuString .= '<li><a ng-click="set_profile('.$key.');">'.$profile['accessConfig_name'].($profile['accounts_name'] != NULL?' - ' . $profile['accounts_name']:'').($profile['clients_name'] != NULL?' - ' . $profile['clients_name']:'').'</a></li>';
		}
		$menuString .= '</ul>';
		$menuString .= '</li>';

		return $menuString;
	}

}

/* End of file navigation.php */
/* Location: ./application/libraries/navigation.php */
