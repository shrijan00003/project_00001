<?php
/**
 * Displays the searchform of the theme.
 *
 * @package my_newsportal
 * @subpackage my_newsportal
 * @since my_newsportal 1.0
 */
?>
<form action="<?php echo esc_url( home_url( '/' ) ); ?>" class="search-form searchform clearfix" method="get">
   <div class="search-wrap">
      <input type="text" placeholder="<?php esc_attr_e( 'Search', 'my_newsportal' ); ?>" class="s field" name="s">
      <button class="search-icon" type="submit"></button>
   </div>
</form><!-- .searchform -->