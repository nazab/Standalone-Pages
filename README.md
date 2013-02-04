# WordPress Plugin Standalone Pages

An easy way to deploy standalone pages by just uploading new pages template files.

## Warning

This is only a proof of concept and is not ready for production.
DO NOT USE IN PRODUCTION ! Yet.

## Features

* Automaticly create WordPress pages for each "standalone template" present in the curent theme.
* Does not override any changes to the "standalone page" made in the admin. Like Page title, or Hierarchy.

## Usage

When you need to create a standalone page in WordPress instead of creating the "page-<MY_PAGE_NAME>.php" file, use the "page-standalone-<MY_PAGE_NAME>.php" file and when you deploy the new version of the theme on the new server, the plugin will magicaly create pages for each file matching the pattern "page-standalone-XXX.php".

Perfect for pages like "My Account", "Login", "Signup" which must be implemented as a page template but actually are standalone pages.

## F.A.Q.

### What is a *standalone page* ?
> It is a page that has a unique behavior and only exists once over the website.
> Exemple: 
> * Signup
> * Login
> * My account
> * etc.


## Installation


1. Copy the `standalon-pages` directory into your `wp-content/plugins` directory
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

## Changelog

### 0.1 (4 February 2013)

* Proof of concept release

## Author Information

The WordPress Plugin Standalone Pages was originally started and is maintained by [Benjamin AZAN](http://benjaminazan.com). 
