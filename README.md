# PrismJS filter #

## About PrismJS ##

Prism is a lightweight, robust, elegant syntax highlighting library. It's a spin-off project from Dabblet.

You can learn more on [http://prismjs.com/](http://prismjs.com).

Why another syntax highlighter ? : [http://lea.verou.me/2012/07/introducing-prism-an-awesome-new-syntax-highlighter/#more-1841](http://lea.verou.me/2012/07/introducing-prism-an-awesome-new-syntax-highlighter/#more-1841)

## About this filter ##

This filter allows you to highlight code snippets inside your Moodle courses, in any activities or ressources using the prismJS library.

* 2017 Sébastien Mehr, University of French Polynesia, Elearning service
* License http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later

## Installation ##

If you are uploading prismJS filter, first expand the zip file and upload the prismjs folder into:
[PATH TO MOODLE]/filters.

Then visit your Moodle server's Site Administration > Notifications page. Moodle will guide you through the installation.
On the final page of the installation you will be able to choose a default language code to use.

After installing you will need to enable the prismJS filter. You can enable it when you visit:
Site Administration > plugins > filters > manage filters.

I suggest you to choose the **Off, but available** option in order to not overcharged all your courses with the filter. Then, activate the filter in desired courses with the dedicated filters menu.

## Basic usage ##

Just go to your course, add for example, a label and edit it through Atto editor. In Atto editor, switch to HTML mode and copy/paste your code between two code tags like this :

**[[code]]** *your code here* **[[/code]]**

Save your label and your code will be highlighted with the default language code colors set in the administration settings. If you want to modify the language, simply go back to the dedicated filters menu of the course and change your default language code.

You can set your language in the dedicated filters menu of the activity or the ressource too.

## Highlight different languages ##

In some cases, you want to add multiple languages in the same context, for example in the same page. You can do this by switching code tags by language tags like this :

**[[code]]** *your code here* **[[/code]]** become **[[python]]** *your python code here* **[[/python]]**.

Then simply add another code with a different language in your page by using the same syntax for example **[[php]]** *your php code here* **[[/php]]**.

The language priority settings is always **language tags** > **local language settings** > **course language settings** > **administration language settings**.

## Supported languages ##

PrismJS officially supports 122 languages. In order to keep a lightweight filter, this filter supports only 19 popular languages :

* PHP : php
* Bash : bash
* C : c
* C++ : cpp
* C# : csharp
* CSS : css
* Go : go
* Java : java
* Javascript : js
* JSON : json
* Markup : markup
* MATLAB : matlab
* Python : python
* R : r
* Ruby : ruby
* Scss : scss
* SQL : sql
* Swift : swift
* VB.Net : vbnet

## Highlight markup languages ##

Because Atto editor interprets Markup languages in HTML Mode, just copy/paste your Markup code between [[code]] or [[markup]] tags directly into Atto without switching to HTML Mode. The filter will handle jumping lines by replacing generated Atto <br> tags with a line feed character.

## Add languages ##

You're a huge fan of LOLCODE ? Don't worry you can simply add your favorite language to this filter :

* Fork the project
* Edit the languages.php file and add your language(s) in the array according to codes of this page : [http://prismjs.com/#languages-list](http://prismjs.com/#languages-list).
* Go to [prismJS download page](http://prismjs.com/download.html) and check your additionnal languages (don't forget to check the [line numbers plugin](http://prismjs.com/plugins/line-numbers/))
* Download the prism.js and styles.css files and override them to the project folder
* Edit the styles.css file and add this css rule to avoid bad alignments with line numbers :

```css
/* Avoiding bad alignment with line numbers. */
 code, pre {
   font-size: 13px !important;
 }
```
Don't forget to clear Moodle's cache after adding your language(s).

## Licenses & Authors ##

### PrismJS Copyright and licence ###

MIT LICENSE

Copyright (c) 2012 Lea Verou

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
