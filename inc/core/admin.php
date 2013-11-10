<?php

if ( class_exists( 'Sunrise3' ) ) {
	class Su_Admin extends Sunrise3 {
		function __construct() {
			parent::__construct();
		}
	}

	new Su_Admin;
}
