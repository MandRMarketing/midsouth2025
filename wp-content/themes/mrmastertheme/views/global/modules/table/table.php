<?php
//we may not always want to use <section>, and instead opt for <aside> or <div>
$tag_type = get_sub_field('tag_type');

//in case we need an ID or additional class names:
$unique_identifiers = get_sub_field('unique_identifiers');
$module_id = $unique_identifiers['id'];
$module_class_names = $unique_identifiers['class_names'];

//build out the closing tag HTML
$closing_tag = '</' . $tag_type . '>';

//build out the opening tag HTML:
if ($module_id && $module_class_names) {
    $opening_tag = '<' . $tag_type . ' id="' . $module_id . '" class="table ' . $module_class_names . '">';
} else if ($module_id && !$module_class_names) {
    $opening_tag = '<' . $tag_type . ' id="' . $module_id . '" class="table">';
} else if (!$module_id && $module_class_names) {
    $opening_tag = '<' . $tag_type . ' class="table ' . $module_class_names . '">';
} else {
    $opening_tag = '<' . $tag_type . ' class="table">';
}

//grab the top & bottom padding settings values, for both desktop & mobile
$padding_settings = get_sub_field('padding');
$top_padding_desktop = $padding_settings['top_padding_desktop'];
$bottom_padding_desktop = $padding_settings['bottom_padding_desktop'];
$top_padding_mobile = $padding_settings['top_padding_mobile'];
$bottom_padding_mobile = $padding_settings['bottom_padding_mobile'];

//build out the padding settings <span> HTML:
$padding_settings_tag = '<span class="padding" data-top-padding-desktop="' . $top_padding_desktop . '" data-bottom-padding-desktop="' . $bottom_padding_desktop . '" data-top-padding-mobile="' . $top_padding_mobile . '" data-bottom-padding-mobile="' . $bottom_padding_mobile . '"><span class="validator-text" data-nosnippet>padding settings</span></span>';

//grab the container width from settings
$container_width = get_sub_field('container_width');

//declare variables for content
$table_header = get_sub_field('table_header');
$columns = get_sub_field('columns');

//we're only generating HTML if the module has columns to display
if ($columns) :
    echo $opening_tag;

    // Determine the number of rows by checking the first column
    $first_column = $columns[0];
    $rows = $first_column['rows'];
    $row_count = count($rows);
?>
    <div class="table-container container">
        <table class="data-table">
            <?php if ($table_header) : ?>
                <caption class="table-header"><?= $table_header ?></caption>
            <?php endif; ?>
            <thead>
                <tr>
                    <?php
                    foreach ($columns as $column) :
                        $column_header = $column['column_header'];
                    ?>
                        <th><?= $column_header ?></th>
                    <?php
                    endforeach;
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop through rows
                for ($i = 0; $i < $row_count; $i++) :
                ?>
                    <tr>
                        <?php
                        // Loop through columns for each row
                        foreach ($columns as $column) :
                            $column_rows = $column['rows'];
                            $cell_value = isset($column_rows[$i]['cell']) ? $column_rows[$i]['cell'] : '';
                        ?>
                            <td><?= $cell_value ?></td>
                        <?php
                        endforeach;
                        ?>
                    </tr>
                <?php
                endfor;
                ?>
            </tbody>
        </table>
        <span class="container-settings" data-container-width="<?= $container_width ?>">
            <span class="validator-text" data-nosnippet>settings</span>
        </span>
    </div>
    <span class="module-settings" data-nosnippet>
        <?= $padding_settings_tag ?>
        <span class="validator-text">module settings</span>
    </span>
<?php
    echo $closing_tag;
endif;
?>