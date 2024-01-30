# Eurofurence Website

Core verison: 4.1
Last update: 2024-01-17

## Requirements

either
* docker / docker-compose, or
* Apache Web Server with PHP 7.4 + modrewrite

## Setup

* Navigate a cli to the root directory and run `docker-compose up -d`, or
* deploy all files from www to /var/html to be served through Apache Web Server.

## Automatic Deployment

A workflow described in `.github/workflows/pull-on-server.yml` allows for automatic updates to the EF Server. To enable that, the following steps are necessary:

* Find all necessary secrets and tokens:
> Note to self: to be found in $storage/private/auth/github.com-eurofurence/deployment-setup.md

* Initialize directory on EF server with `git clone https://${{ secrets.ACCESS_TOKEN }}@github.com/dogpixels/ef__ && mv ef__ EF__`
> This writes the access token into the .git subdirectory for later use in automated `git pull`.

* Let the server point to the freshly created directory, **but the *www* subdirectory!**

* Set up the following [Action secrets and Variables](https://github.com/dogpixels/efXX/settings/secrets/actions):
    * secret *KEY*
    * secret *USER*
    * var *HOST* = `www.eurofurence.org`
    * var *PATH* = `~/sites/www.eurofurence.org/EF__`

* Finally, enable auto-triggering the workflow by editing `.github/workflow/pull-on-server.yml`.

## Usage

* To use the static site generation feature, enable "staticOut" option in core.config.json.
* To automate an export of all pages, call any page with ?export attached to the url.