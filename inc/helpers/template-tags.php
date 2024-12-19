<?php
/**
 * Custom template tags for the theme.
 *
 * @package WooXtraAddons
 */
if( ! function_exists( 'is_FwpActive' ) ) {
  function is_FwpActive( $opt ) {
    if( ! defined( 'WOO_XTRAADDONS_OPTIONS' ) ) {return false;}
    return ( isset( WOO_XTRAADDONS_OPTIONS[ $opt ] ) && WOO_XTRAADDONS_OPTIONS[ $opt ] == 'on' );
  }
}
if( ! function_exists( 'get_FwpOption' ) ) {
  function get_FwpOption( $opt, $def = false ) {
    if( ! defined( 'WOO_XTRAADDONS_OPTIONS' ) ) {return false;}
    return isset( WOO_XTRAADDONS_OPTIONS[ $opt ] ) ? WOO_XTRAADDONS_OPTIONS[ $opt ] : $def;
  }
}