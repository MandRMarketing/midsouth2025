<div class="search-toggle-wrapper">
    <button type="button" class="search-toggle" aria-label="Open search" aria-expanded="false">
        <svg class="icon-search" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <svg class="icon-close" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
    </button>
    <form class="custom-theme-search" role="search" method="get" action="<?php echo home_url('/'); ?>">
        <ul class="search-form-fields">
            <li class="search-string">
                <label data-visually-hidden="true">Search for:</label>
                <input type="text" name="s" value="<?php the_search_query(); ?>" placeholder="Search...">
            </li>
            <li class="submit-button">
                <label data-visually-hidden="true">Submit Search Form</label>
                <input type="submit" value="Search">
            </li>
        </ul>
    </form>
</div>