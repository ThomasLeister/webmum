<?php

/*
 * MySQL server and database settings
 */

define("MYSQL_HOST", "localhost");
define("MYSQL_USER", "vmail");
define("MYSQL_PASSWORD", "vmail");
define("MYSQL_DATABASE", "vmail");


/*
 * Database table names
 */

// Table names
define("DBT_USERS", "users");
define("DBT_DOMAINS", "domains");
define("DBT_ALIASES", "aliases");

// Users table columns
define("DBC_USERS_ID", "id");
define("DBC_USERS_USERNAME", "username");
define("DBC_USERS_DOMAIN", "domain");
define("DBC_USERS_PASSWORD", "password");
// define("DBC_USERS_MAILBOXLIMIT", "mailbox_limit");		// (Optional)

// Domains table columns
define("DBC_DOMAINS_ID", "id");
define("DBC_DOMAINS_DOMAIN", "domain");

// Aliases table columns
define("DBC_ALIASES_ID", "id");
define("DBC_ALIASES_SOURCE", "source");
define("DBC_ALIASES_DESTINATION", "destination");


/*
 * Frontend paths
 */

define("FRONTEND_BASE_PATH", "http://localhost/webmum/");
define("SUBDIR", "webmum/");


/*
 * Admin e-mail address
 */

// outdated: define("ADMIN_EMAIL", "admin@domain.tld");
// new: $admins = array("admin1@server.tld", "admin2@server.tld");
$admins = array("admin@domain.tld");



/*
 * Password
 */
 /*
 * Select on of the following schemas (only these are supported)
 * SHA-512, SHA-256, BLOWFISH
 */
define("PASS_HASH_SCHEMA", "SHA-512");
 
//minimum password length
define("MIN_PASS_LENGTH", 8);

/*
 * Write log file? Failed login attempts will be written to the logfile.
 * You can mointor the logfile with fail2ban and ban attackers' IP-addresses.
 * Make sure that PHP has permission to create the log directory and webmum.log (write permissions for php user)
 *
 * Default: Do not write logfile
 */

// define("WRITE_LOG", true);
// define("WRITE_LOG_PATH","/var/www/webmum/log/");

?>
