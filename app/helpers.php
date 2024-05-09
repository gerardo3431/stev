<?php
  
function active_class($path, $active = 'active') {
  // return call_user_func_array('Request::is', (array)$path) ? $active : '';
  return request()->routeIs($path) ? $active : '';
}

function is_active_route($path) {
  return request()->routeIs($path) ? true : false;
  // return call_user_func_array('Request::is', (array)$path) ? 'true' : 'false';
}

function show_class($path) {
  return request()->routeIs($path) ? 'show' : '';
  // return call_user_func_array('Request::is', (array)$path) ? 'show' : '';
}