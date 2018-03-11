=== Nepali Date Converter ===
Contributors: codersantosh
Donate link: http://codersantosh.com
Tags: nepali date converter, today nepali date, english to nepali date converter, nepali to english date converter, nepali date, date converter, nepali, nepal
Requires at least: 2.8
Tested up to: 4.3.1
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Easily convert English Date to Nepali Date and Vice Versa through widgets, shortcodes and php functions. Also supports for today date.

== Description ==

Nepali Date Converter is plugin with widgets and shortcodes which convert Nepali Date to English Date and English Date to Nepali Date.
You can also show either today Nepali date or today English date or both.

You will find following widgets with advanced options:

* NDC: Nepali Date Converter
* NDC: Today Date

You can use following shortcodes either to display Nepali Date Converter or Today Date anywhere in the posts or pages:

* Use `[nepali-date-converter]` to show Nepali Date Converter
* Use `[ndc-today-date]` to show Today Date

Again the shortcode `[nepali-date-converter]` comes with following options:

* 'before' => Use anything to show before Nepali Date Converter eg: `<div class="ndc-wrapper">`,
* 'after' => Use anything to show after Nepali Date Converter eg: `</div>`,
* 'before_title' => Use anything to show before Title eg: `<div class="ndc-title">`,
* 'after_title' => Use anything to show after title eg: `</div>`,
* 'title' => Write something for title `Nepali Date Converter`,
* 'disable_convert_nep_to_eng' => Write `1` for disable convert Nepali Date to English Date,
* 'disable_convert_eng_to_nep' =>  Write `1` for disable convert English Date to Nepali Date,
* 'nep_to_eng_button_text' => Write text for button for Nepali to English eg: `Nepali to English`,
* 'eng_to_nep_button_text' => Write text for button for Nepali to English eg: `English to Nepali`,
* 'result_format' => You can use any date format for result display in frontend. See date format here [Formatting Date](https://codex.wordpress.org/Formatting_Date_and_Time). eg: 'D, F j, Y'.
PLease note that "S The English suffix for the day of the month" is not supported for version 1.0,
* 'nepali_date_lang' => By default nepali date language is `nep_char` that means date display like this `शुक्रबार, अशोज ८, २०७२`,
You can also use 'eng_char' to display date like this `Sukrabar, Ashwin 8, 2072`
* Example shortcodes: `[nepali-date-converter]`, `[nepali-date-converter title="Nepali date"]`, `[nepali-date-converter title="Nepali date" result_format ="l, F j, Y"]`

Please visit [codersantosh.com/nepali-date-converter](http://codersantosh.com/nepali-date-converter/) for more information about another shortcode `[ndc-today-date]`
and for all available functions.

== Installation ==

1. Login to admin panel,Go to Plugins => Add New.
2. Search for "Nepali Date Converter" and install it.
3. Once you install it, activate it
4. Go to Appearance => Widgets, NDC: Nepali Date Converter and NDC: Today Date is waiting for you :) And also available shortcodes and functions.

Or

1. Put the plug-in folder `nepali-date-converter` into [wordpress_dir]/wp-content/plugins/
2. Go into the WordPress admin interface and activate the plugin
3. Go to Appearance => Widgets, NDC: Nepali Date Converter and NDC: Today Date is waiting for you :) And also available shortcodes and functions.

Have fun!!!

== Frequently Asked Questions ==

= What does this plugin do? =

* Convert Nepali Date to English Date and English Date to Nepali Date.
* You can also show either today Nepali date or today English date or both.
* Custom functions are available

= What are date formats that I can use with this plugin ? =

PLease note that "S The English suffix for the day of the month" is not supported for version 1.0. Other than that you can use any date format [Formatting Date](https://codex.wordpress.org/Formatting_Date_and_Time).

= How can I display Nepali Date Converter or Today Date in any post/page content?  =

You can use following shortcodes either to display Nepali Date Converter or Today Date anywhere in the posts or pages:

* Use `[nepali-date-converter]` to show Nepali Date Converter
* Use `[ndc-today-date]` to show Today Date

= Is there any functions available in this   =

Yes, you can use following functions

* eng_to_nep_date => it accept array input
* convert_eng_to_nep => it accepts string input
* nep_to_eng_date => it accept array input
* convert_nep_to_eng => it accept string input

For showing whole nepali date converter or today nepali date you can use do_shortcode function

* `echo do_shortcode('[nepali-date-converter]')`
* `echo do_shortcode('[ndc-today-date]')`

= Still have some questions ? =

Plese use support forum or you can comment here [codersantosh.com/nepali-date-converter](http://codersantosh.com/nepali-date-converter/) or
you can directly mail me [codersantosh@gmail.com](mailto:codersantosh@gmail.com)

== Screenshots ==

1. Nepali Date Converter Widget

2. Today Date Widget

3. Widgets area

4. Nepali Date Converter Widget Frontend

5. Today Date Widget Frontend

6. Frontend Display form shortcode and widget

== Changelog ==

= 1.0 =
Initial version