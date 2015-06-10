<div class="sb-search-out">
    <div class="sb-search">
        <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
            <input class="sb-search-input" placeholder="<?php echo esc_attr_x('Search &hellip;', 'placeholder'); ?>" type="search" value="<?php echo get_search_query(); ?>" name="s">
            <input class="sb-search-submit" type="submit" value="<?php echo esc_attr_x('Search', 'submit button'); ?>">
            <span class="sb-icon-search fa fa-search"></span>
        </form>
    </div>
</div>