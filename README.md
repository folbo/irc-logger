# irc-logger
irc-logger is a web app that displays saved daily logs from irssi.

App will be optimized for handling [Slack's](https://slack.com) syntax.
## Configuration
Make sure you have following entries in ~/.irssi/conf file:
```
settings = {
  core = {
    log_create_mode = "755";
  };
  "fe-text" = { actlist_sort = "refnum"; };
  "fe-common/core" = {
    autolog_path = "~/irclogs/$tag/$0/%Y-%m-%d.log";
    AUTOLOG = "yes";
    autolog_level = "ALL -CRAP -CLIENTCRAP -CTCPS -JOINS -PARTS -QUITS -DCC";
    term_charset = "utf-8";
  };
  ```


`autolog_path` contains following variables:

1. `$tag` is server name
2. `$0` is channel name
3. `%Y-%m-%d.log` is output file name (logs will be rolled everyday) (f.e. `2015-10-17.log`)

More on irssi's logging in [irssi documentation](http://www.irssi.org/documentation).

Now create symbolic link in your website directory: `ln -s ~/irclogs/<servername> logs` and you are good to run these php scripts :)

## About handling private channels
Private channels are just not listed thus everybody can get logs. So - private channels are dangerous.

## Todo
1. Parsing slack's syntax.
