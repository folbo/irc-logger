# irc-logger
irc-logger is a web app that displays saved daily logs from irssi.

App will be optimized for handling [Slack's](https://slack.com) syntax.
## Configuration
1. Configure irssi's logs settings:
   * `/SET autolog_level ALL -CRAP -CLIENTCRAP -CTCPS -JOINS -PARTS -QUITS -DCC -MSGS`
   * `/SET term_charset utf-8`
   * `/SET log_create_mode 755`
   * `/SET autolog_path ~/irclogs/$tag/$0/%Y-%m-%d.log`
   * `/SET autolog ON`
   * `/save`

   Note: `autolog_path` contains following variables:

   `$tag` is server name
   `$0` is channel name
   `%Y-%m-%d.log` is output file name (logs will be rolled everyday) (f.e. `2015-10-17.log`)

2. After all these steps make sure you have following entries in ~/.irssi/conf file:

   ```
   settings = {
     core = {
       log_create_mode = "755";
     };
     "fe-common/core" = {
       autolog_path = "~/irclogs/$tag/$0/%Y-%m-%d.log";
       AUTOLOG = "yes";
       autolog_level = "ALL -CRAP -CLIENTCRAP -CTCPS -JOINS -PARTS -QUITS -DCC -MSGS";
       term_charset = "utf-8";
   };
   ```

   More on irssi's logging in [irssi documentation](http://www.irssi.org/documentation).

3. Now create symbolic link in your website directory: `ln -s ~/irclogs/<servername> logs` and you are good to run these php scripts :)

## About handling private channels
If you don't want to log some channels just `/part` them so irssi won't collect logs.

## Todo
1. Parsing slack's syntax.
