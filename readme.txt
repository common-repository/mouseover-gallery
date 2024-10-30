=== Mouseover Gallery ===

Contributors: Dietrich Koch, Daniel Sachs
Donate link: http://www.internetdienste-berlin.de/2010/01/mouseover-galerie-fur-wordpress/
Tags: gallery, default gallery, mouseover, galleria, colorpicker
Requires at least: 2.7
Tested up to: 3.1.1
Stable tag: 1.2.3
Mouseover gallery divids the content into a left_part and right_part (classes) where the thumbs are put into the right_part and the enlargments comes via mouseover the thumbs in the left_part.

== Description ==
Mousover gallery splits the content into two columns where the right part contains the thumbs and the left part contains the enlarged image created by moving the mouse over  the thumbs.

If you split the content-division manually by two div-tags with class names right_part and left_part resp you can place your textual content inside the columns and befor oder after the ones. For instance:

Some text or anything else
&lt;div class="left_part"&gt;Some text or anything else&lt;/div&gt;

&lt;div class="right_part"&gt;Some text or anything else[gallerymo]Some text or anything else&lt;/div&gt;

You can change the design by using the gallery options in the preference menu of the dashboard or by CSS in your style.css. There you have to use the !import-feature for overwriting element-styles.


**What are the settings?**


*   Set your main image height and width
*   Set thumbnails height and width and position
*   Turn on and off the navigation and it's position
*   Browser "Back and Forward" ability 
*   Sets a direct link to every image in the gallery
*   Custom colors via color picker to match your theme - you do not to remember all those HEX numbers
*   Thickbox support
*   Styled tooltips
*   Other less important stuff

To see Mouseover Gallery in action visit : [Internetdienste Berlin  site](http://www.internetdienste-berlin.de/?p=978)


== Installation ==

1. Upload `Mouseover Gallery` directory to the `/wp-content/plugins/` directory.
3. Activate the plugin via the Plugins menu.
4. Configure your new gallery via the Settings &gt; MOGallery menu.

5. For better results please update you Wordpress default images sizes for Thumbnails and Medium sizes to match your chosen Image Gallery Reloaded settings (also view FAQ)
6. Divide your content into two divs with classes left_part and right_part and put the shorthand [gallerymo ... parameter as in standard gallery] into the div right_part.

== Frequently Asked Questions  ==
**What images does the gallery use?**

The plugin does not use the default image you upload, instead it uses the Medium and Thumbnail versions of it. It is done in order to produce better image quality and to increase performance.  The size of these versions are set at Settings &gt; Media. And why is it important? Because if you are running a photo blog or simply plan to use a very big gallery you may need to update the size of you Medium and Thumbnail versions of the image. The default sizes are 300X300 px and 150X150 px respectively. If you plan to set the main image to 960X700 px and/or use larger thumbnails it might be a good idea to set these sizes at the Settings &gt; Media as well.

**How do I add  galleries to posts?**

Remember, Mouseover Gallery uses the default Wordpress Gallery feature.

* Write a new Post or edit an existent.
* Add images to it via the default Upload/Insert &gt;Add an Image.
* On the Add an Image popup click the Gallery tab, Click Insert Gallery and watch your new gallery set.

== Screenshots ==
1. Plugin options)
2. Mouseover Gallery in frontend 

== Changelog ==
1.0.0
No changes with respect to the version before, only for better version tagging
1.1.0
Handling of text and other content around the gallery better solved
1.2.0 
Now the size of thumbs via options are handled correctly
1.2.1
With embedded jQuery v1.4.2 because the newer versions don't initialize the first big image after loading