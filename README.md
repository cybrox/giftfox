# giftfox
A bot that uses a lottery system to win free games on steam.

Using it is quite the dick move to be honest, so make sure to also give away games to give the people something back. Using the bot is technically allowed, it shouldn't be overused though.
Since the bot is backed by a cron script, it's up to you how often it should run.


### How to use
GiftFox should run on pretty much every system running PHP5+ & MySQL.
Its actual development version is running on a Synology DS

**Installation**
- Copy all the files to a location on your server
- Create a MySQL database for the bot and import the `database.sql` structure
- Adjust the `/app/config.php` file with your database configuration
- Adjust the `/index.php` file with the subdirectory of the script on your server
- Adjust the include paths in `/app/cron/execute.php`
 - Some systems require absolute paths when running the script from a cron!
- Create a cronjob to run `/app/cron/execute.php` once in a while.
 - The script itself has a minimum interval of 7h per user hardcoded
 - You can change this in the `execute.php` script if so desired.
- Manually create a new user in the database, give it a username, password and token.
 - Since this is not ment as a "serious" account system, nothing is encrypted 
 - Also, there's no comfortable function to add a user yet
- Log in with the user via the GifFox UI
- GiftFox should ask you for a session token
 - Copy your `PHPSESSID` session cookie from steamgifts.com and enter it
- Everything should run fine now.
