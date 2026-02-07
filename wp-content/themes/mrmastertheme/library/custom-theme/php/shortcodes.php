<?php

//Starting with the one you'll used most often:

//Button:
add_shortcode('button', 'button_shortcode');
function button_shortcode($atts, $content = null)
{

	extract(shortcode_atts(
		array(
			'link' => 'https://www.google.com',
			'text' => 'Button Text',
			'mobile_text' => '',
			'newtab' => 'false',
			//'align' => 'false',
			'download' => 'false'
		),
		$atts
	));

	$output = '';

	if ($newtab !== false && $newtab !== 'false') {
		$insert = ' target="_blank" ';
		$rel = 'rel="noopener noreferrer" ';
	} else {
		$insert = '';
		$rel = '';
	}

	if ($mobile_text !== '') {
		$mobile = '<span class="mobile-text">' . $mobile_text . '</span>';
	} else {
		$mobile = '';
	}

	/*
	if ($align !== 'false') {
		if ($align === 'center' || $align === 'centered') {
			$p_align = '<p class="centered-button">';
		} elseif ($align === 'left') {
			$p_align = '<p class="left-button">';
		} elseif ($align === 'right') {
			$p_align = '<p class="right-button">';
		}
	} else {
		$p_align = '';
	}
    */

	if ($download === 'false') {
		$download = '';
	} else {
		$download = 'download';
	}

	//$output .= $p_align;
	$output .=  '<a ' . $download . ' href="' . $link . '" title="' . $text . '" class="button"' . $insert . $rel . '>';
	$output .= $mobile;
	$output .= '<span class="text-wrap">' . $text . '</span>';
	$output .= '</a>';

	/*
	if ($align !== 'false') {
		$output .= '</p>';
	}
    */

	return $output;
}

//Shortcodes that pull in info from Options tab:

//Contact Phone
add_shortcode('contact-phone', 'phone_link_sc');
function phone_link_sc($atts, $content = null)
{
	$phone = get_field('contact_info_phone', 'options');

	if ($phone) :
		$output = '<a href="tel:' . $phone . '">' . $phone . '</a>';
	else:
		$output = '';
	endif;

	return $output;
}

//Contact Email 
add_shortcode('contact-email', 'contact_email_sc');
function contact_email_sc($atts, $content = null)
{
	$email = antispambot(get_field('contact_info_email', 'options'));

	if ($email) :
		$output = '<a href="mailto:' . $email . '">' . $email . '</a>';
	else:
		$output = '';
	endif;

	return $output;
}

//Contact Address
add_shortcode('contact-address', 'contact_address_sc');
function contact_address_sc($atts, $content = null)
{
	$location_text = get_field('contact_info_address_text', 'options');
	$location_link = get_field('contact_info_address_link', 'options');

	if ($location_text && $location_link) :
		$output = '<a href="' . $location_link . '" target="_blank">' . $location_text . '</a>';
	else:
		$output = '';
	endif;

	return $output;
}

//Email (for email addresses other than what's in Options tab)
add_shortcode('email', 'email_shortcode');
function email_shortcode($atts, $content = null)
{

	extract(shortcode_atts(
		array(
			'email' => 'example@example.com',
			'text' => 'Example',
			'class' => ''
		),
		$atts
	));

	$email = antispambot($email);
	$text = antispambot($text);

	$output =  '<a href="mailto:' . $email . '" class="' . $class . '">';
	$output .= $text;
	$output .= '</a>';

	return $output;
}



//Social Media Icons: (NEEDS WORK, namely to include use icon fonts)

//Facebook Icon
add_shortcode('facebook-icon', 'facebook_icon_sc');
function facebook_icon_sc($atts, $content = null)
{

	$facebook_link = get_field('social_facebook', 'options');
	$output = '<a href="' . $facebook_link . '">Facebook</a>';

	return $output;
}

//X Icon (Formerly Twitter)
//LinkedIn Icon
//YouTube Icon 
//Instagram Icon

//Apple App Store Icon
add_shortcode('apple-appstore', 'apple_appstore_icon_sc');
function apple_appstore_icon_sc($atts, $content = null)
{
	$apple_appstore_link = get_field('apple_appstore_link', 'options');

	if ($apple_appstore_link) {
		$svg_path = get_template_directory_uri() . '/library/custom-theme/images/icons/apple-appstore.svg';
		$output = '<a href="' . esc_url($apple_appstore_link) . '" target="_blank" rel="noopener noreferrer" class="app-store-link">';
		$output .= '<img src="' . esc_url($svg_path) . '" alt="Download on the App Store" />';
		$output .= '</a>';
	} else {
		$output = '';
	}

	return $output;
}

/**
 * Create newsletter archive structure
 */
add_shortcode('newsletter_archive', 'newsletter_archive_sc');
function newsletter_archive_sc()
{

	if (have_rows('archive_year')) :
		ob_start();
?>
		<div class="newsletter-container">
			<?php while (have_rows('archive_year')) : the_row();
				$year = get_sub_field('newsletter_year');

				if (have_rows('newsletters')) :
					while (have_rows('newsletters')) : the_row();
						$image  = get_sub_field('cover_image');
						$pdf    = get_sub_field('pdf_file');
						$qtitle = get_sub_field('quarter_title');
						$img    = aq_resize($image['url'], 500, 700, true, true, true);
			?>
						<a href="<?= $pdf; ?>" target="_blank" class="newsletter-single">
							<span class="newsletter-image">
								<img src="<?= $img; ?>" alt="<?= esc_attr($qtitle . ' ' . $year . ' Newsletter'); ?> Cover Image" />
							</span>
							<h3 class="newsletter-title"><?= esc_html($qtitle . ' - ' . $year); ?></h3>
							<span class="button">Read Articles</span>
						</a>
			<?php endwhile;
				endif;
			endwhile; ?>
		</div>
	<?php
	endif;

	// End buffering, save, return
	$output = ob_get_clean();
	return $output;
}

// Auto loan interest calculator
add_shortcode('auto_calculator_interest', 'auto_calculators_sc');
function auto_calculators_sc()
{
	ob_start();
	?>
	<div class="calc-column auto-calc-interest">
		<script type="text/javascript" src="https://www.practicalmoneyskills.com/assets/js/calcs/embed.js" data-calc="auto_loan_interest" data-locale="us_en"></script>
	</div>
	<span class="clear"></span>
<?php
	$output = ob_get_clean();
	return $output;
}

//Google Play Icon
add_shortcode('google-play', 'google_play_icon_sc');
function google_play_icon_sc($atts, $content = null)
{
	$google_play_link = get_field('google_play_link', 'options');

	if ($google_play_link) {
		$svg_path = get_template_directory_uri() . '/library/custom-theme/images/icons/google-play.svg';
		$output = '<a href="' . esc_url($google_play_link) . '" target="_blank" rel="noopener noreferrer" class="google-play-link">';
		$output .= '<img src="' . esc_url($svg_path) . '" alt="Get it on Google Play" />';
		$output .= '</a>';
	} else {
		$output = '';
	}

	return $output;
}



//Copyright Area Shortcodes:

//Current Year
add_shortcode('current-year', 'current_year_shortcode');
function current_year_shortcode($atts, $content = null)
{
	return date("Y");
}

//Site Name
add_shortcode('site-name', 'site_name_shortcode');
function site_name_shortcode($atts, $content = null)
{
	return get_bloginfo('name');
}

//Privacy Policy Shortcodes:

//Client Name
add_shortcode('client-name', 'client_name_sc');
function client_name_sc($atts, $content = null)
{
	$output = get_field('privacy_policy_client_name', 'options');

	return $output;
}

//Client Website
add_shortcode('client-website', 'client_website_sc');
function client_website_sc($atts, $content = null)
{
	$website = get_field('privacy_policy_client_website', 'options');
	ob_start();
?>
	<a href="<?= $website ?>" target="_blank"><?= $website ?></a>
<?php
	$output = ob_get_clean();
	return $output;
}

//Client Contact Email
add_shortcode('client-contact-email', 'client_contact_email_sc');
function client_contact_email_sc($atts, $content = null)
{
	$email = get_field('privacy_policy_client_email', 'options');
	ob_start();
?>
	<a href="mailto:<?= $email ?>"><?= $email ?></a>
<?php
	$output = ob_get_clean();
	return $output;
}


//SHORTCODES THAT MAY GO AWAY:

//Column Count Shortcodes. Useful, but I would like to remove:

//Column Count shortcode
//add_shortcode('column_count', 'column_count_shortcode');
function column_count_shortcode($atts, $content = null)
{

	if (isset($atts[0])) {
		$number = trim($atts[0]);
	} else {
		return do_shortcode($content);
	}

	$style = "-moz-column-count: $number; -webkit-column-count: $number; column-count: $number;";

	$output = '<div class="column-box" style="' . $style . '">';
	$output .= do_shortcode($content);
	$output .= '</div>';

	return $output;
}
//Responsive Column Width shortcode 
//add_shortcode('responsive_column_width', 'r_column_width_shortcode');
function r_column_width_shortcode($atts, $content = null)
{

	if (isset($atts[0])) {
		$number = trim($atts[0]);
	} else {
		return do_shortcode($content);
	}

	$style = "-moz-column-width: {$number}px; -webkit-column-width: {$number}px; column-width: {$number}px;";

	$output = '<div style="' . $style . '">';
	$output .= do_shortcode($content);
	$output .= '</div>';

	return $output;
}

//Responsive Column Count shortcode 
//add_shortcode('responsive_column_count', 'r_column_count_shortcode');
function r_column_count_shortcode($atts, $content = null)
{

	if (isset($atts[0])) {
		$number = trim($atts[0]);
	} else {
		return do_shortcode($content);
	}

	$style = "-moz-column-count: $number; -webkit-column-count: $number; column-count: $number;";

	$output = '<div class="responsive-column-count" style="' . $style . '">';
	$output .= do_shortcode($content);
	$output .= '</div>';

	return $output;
}

//Toggle (NEEDS WORK, MAY REMOVE)
//add_shortcode('toggle', 'toggle_shortcode');
function toggle_shortcode($atts, $content = null)
{

	extract(shortcode_atts(
		array(
			'title' => 'This is your title'
		),
		$atts
	));

	$output = '<div class="toggle">';
	$output .= '<a href="#" class="trigger" aria-expanded="false"><span></span>' . $title . '</a>';
	$output .= '<div class="box" aria-hidden="true">';
	$output .= do_shortcode($content);
	$output .= '</div><!-- .box (end) -->';
	$output .= '</div><!-- .toggle (end) -->';

	return $output;
}
