# WordPress Plugin Standalone Pages

An easy way to deploy standalone pages by just uploading new pages template files.

## Warning

This is only a proof of concept and is not ready for production.
DO NOT USE IN PRODUCTION ! Yet.

## Features

* Automaticly create WordPress pages for each "standalone template" linked to in the curent theme.
* Does not override any changes to the "standalone page" made in the admin. Like Page title, or Hierarchy.

## F.A.Q.

### How to create a Standalon Page ?
> Just create a page template filefollowing the namming pattern: `page-standalone-<TEMPLATE_NAME>.php`.
> This template works exactly like a standard WordPress page template.

### Howto make a link o a standalone page ?

> Simply use the `StandalonePages::get_standalone_page_uri(<TEMPLATE_NAME>)` static method to get the page full URL of the requested template.


### What is a *standalone page* ?

> It is a page that has a unique behavior and only exists once over the website. Like (signup page, login page, my account page, etc.)


## Changelog

### 0.2 (6 February 2013)

* Based on the very usefull feedback of @boiteaweb, @startupz and @samyrabih
* The plugin now only creates page when they are linked to woth the plugin static method. This drasticly improve the plugin performance.

### 0.1 (4 February 2013)

* Proof of concept release

## Author Information

The WordPress Plugin Standalone Pages was originally started and is maintained by [Benjamin AZAN](http://benjaminazan.com). 


## Roadmap

* Add an admin page to manualy generate the standalone pages.
* Use the first admin if the user_id set does not exists.

## Installation


1. Copy the `standalone-pages` directory into your `wp-content/plugins` directory
2. Navigate to the "Plugins" dashboard page
3. Locate the menu item that reads "Standalon pages"
4. Click on "Activate"

This will activate the WordPress Plugin Standalone Pages and create the missing standalone page.

## License

The WordPress Plugin Standalone Pages is licensed under the GPL v2 or later.

> This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

> This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

> You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
