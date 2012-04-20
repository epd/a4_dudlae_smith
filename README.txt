
Assignment #4
Web Systems Development
April 19, 2012

Evan Dudla <dudlae@rpi.edu>
Mykola Smith <smithm20@rpi.edu>

===============================================================================

REFERENCES:

  1)  Spyc Yaml file parser <http://code.google.com/p/spyc/>.
      We use this library in order to parse our "routes.yml" file that is
      located in system/routes.yml. The only purpose of this library is to
      parse this file and it was approved prior to development by Professor
      Watson.

===============================================================================

ARCHITECTURE:

Our system will use index.php as a controller to the entire system. Clean URLs
are done through mod_rewrite via .htaccess.  Ideally, this system will be run
as its own Virtual Host.

The controller will read the current REQUEST_URI and compare it to the routes
inside of the parsed routes.yml file. It will look for the most specific match
to the route.  For instance, if "users/profile/1" is provided, but only
"users/profile" exists as a route, it will use this. For requests that do not
match any route, it will inherently display the "/" route by design.

Each route can execute code before and after the templates are rendered via
the "after" and "before" properties. Each "before" code file is relative to
the "preload" directory, and each "after" is relative to the "postload"
directory in the document root.  In this project, we did not need to use the
"after" functionality, but this could be useful for template altering and other
database hooks.

===============================================================================

  1)  The way we implemented authorization was very modular. In "preload/users,"
      you can see files for verify_*.php, which all have very modular checks for
      verifying permissions and even if a user is logged in at all. The way we
      implemented this allows the developer to simply reference a single file to
      add in each functionality as needed.

  2)  Users would be able to modify passwords of other users and also create
      accounts that might even have higher access levels than they do. This
      would be a huge security flaw in the system and would do the system more
      harm than good. Hierarchy is needed in a system to make sure it is
      correctly and appropriately maintained and so that you know control is in
      the right, trusted hands.

  3)  Our authentication uses PDO as a means to communicate with the database.
      This PHP extension allows us to do prepared queries, which prevents SQL
      injection. We also use a password salt to make sure that if the password
      hash was compromised, the salt gives more entropy to the SHA-1 hash
      algorithm we use to secure each password.
