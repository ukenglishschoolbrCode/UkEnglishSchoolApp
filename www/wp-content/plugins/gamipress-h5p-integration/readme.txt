=== GamiPress - H5P integration ===
Contributors: gamipress, tsunoa, rubengc, eneribs
Tags: gamipress, gamification, gamify, point, achievement, badge, award, reward, credit, engagement, ajax, h5p, editor, video, quiz, slider, education
Requires at least: 4.4
Tested up to: 6.1
Stable tag: 1.0.8
License: GNU AGPLv3
License URI:  http://www.gnu.org/licenses/agpl-3.0.html

Connect GamiPress with H5P

== Description ==

Gamify your [H5P](https://wordpress.org/plugins/h5p/ "H5P") interactive content completions thanks to the powerful gamification plugin, [GamiPress](https://wordpress.org/plugins/gamipress/ "GamiPress")!

This plugin automatically connects GamiPress with H5P adding new activity events.

= New Events =

* Complete any interactive content: When a user completes any interactive content.
* Complete a specific interactive content: When a user completes a specific interactive content.
* Complete any interactive content of a specific type: When a user completes any interactive content of a specific type.

= Score-based Events =

* Complete any interactive content at maximum score: When a user completes any interactive content at maximum score.
* Complete a specific interactive content at maximum score: When a user completes a specific interactive content at maximum score.
* Complete any interactive content of a specific type at maximum score: When a user completes any interactive content of a specific type with at maximum score.
* Complete any interactive content with a minimum score: When a user completes any interactive content with a minimum score.
* Complete a specific interactive content with a minimum score: When a user completes a specific interactive content with a minimum score.
* Complete any interactive content of a specific type with a minimum score: When a user completes any interactive content of a specific type with a minimum score.
* Complete any interactive content with a maximum score: When a user completes any interactive content with a maximum score.
* Complete a specific interactive content with a maximum score: When a user completes a specific interactive content with a maximum score.
* Complete any interactive content of a specific type with a maximum score: When a user completes any interactive content of a specific type with a maximum score.
* Complete any interactive content on a range of scores: When a user completes any interactive content on a range of scores.
* Complete a specific interactive content on a range of scores: When a user completes a specific interactive content on a range of scores.
* Complete any interactive content of a specific type on a range of scores: When a user completes any interactive content of a specific type on a range of scores.

= Percentage Score-based Events =

* Complete any interactive content with a minimum percentage score: When a user completes any interactive content with a minimum percentage score.
* Complete a specific interactive content with a minimum percentage score: When a user completes a specific interactive content with a minimum percentage score.
* Complete any interactive content of a specific type with a minimum percentage score: When a user completes any interactive content of a specific type with a minimum percentage score.
* Complete any interactive content with a maximum percentage score: When a user completes any interactive content with a maximum percentage score.
* Complete a specific interactive content with a maximum percentage score: When a user completes a specific interactive content with a maximum percentage score.
* Complete any interactive content of a specific type with a maximum percentage score: When a user completes any interactive content of a specific type with a maximum percentage score.
* Complete any interactive content on a range of percentages scores: When a user completes any interactive content on a range of percentages scores.
* Complete a specific interactive content on a range of percentages scores: When a user completes a specific interactive content on a range of percentages scores.
* Complete any interactive content of a specific type on a range of percentages scores: When a user completes any interactive content of a specific type on a range of percentages scores.

== Installation ==

= From WordPress backend =

1. Navigate to Plugins -> Add new.
2. Click the button "Upload Plugin" next to "Add plugins" title.
3. Upload the downloaded zip file and activate it.

= Direct upload =

1. Upload the downloaded zip file into your `wp-content/plugins/` folder.
2. Unzip the uploaded zip file.
3. Navigate to Plugins menu on your WordPress admin area.
4. Activate this plugin.

== Frequently Asked Questions ==

== Screenshots ==

== Changelog ==

= 1.0.8 =

* **Bug Fixes**
* Fixed percentage fields visibility.

= 1.0.7 =

* **New Features**
* Added 9 new events based on percentage score (minimum, maximum and between percentages scores).

= 1.0.6 =

* **Improvements**
* Performance improvements by limiting the number of requirements to check to only those who match with the event parameters.

= 1.0.5 =

* **Improvements**
* Prevent to add a permalink on requirements with a H5P events based on specific H5P contents.

= 1.0.4 =

* **New Features**
* Added new fields on logs generated by H5P events.
* **Bug Fixes**
* Fixed content type events when matched content type is repeated on H5P library table.

= 1.0.3 =

* **Bug Fixes**
* Fixed content type selected element when page gets refreshed.

= 1.0.2 =

* **New Features**
* Added new activity events to award users that completes interactive contents with a minimum score.
* Added new activity events to award users that completes interactive contents with a maximum score.
* Added new activity events to award users that completes interactive contents with a score between a range of scores.
* **Bug Fixes**
* Fixed content type selector for "Complete a specific interactive content at maximum score" event.

= 1.0.1 =

* **New Features**
* Added new activity events to award users that completes interactive contents at maximum score.

= 1.0.0 =

* Initial release.
