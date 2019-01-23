<?php

function wppitm_get_current_log() {
	if ( $current = WPPitm_Log::get_current() ) {
		return $current;
	}
}