# redGIT package for Joomla!  

System to track Joomla! websites with Git.  

## Component

Main component.  

### Settings.

* **Global**
    * **Git repository**: Folder where the repository is. Example: `/home/reditem/domains/le34.reditem.staging.redcomponent.com/public_html`
    * **Git User Name**: Name that will be sent as author of the commits.  
    * **Git User Email**: Email that will be sent as author of the commits.  
    * **Git Branch**: Branch where commits will be sent to.
    * **Default commit message**: Message that will be used for commits from the server.
* **SSH**
    * **Private SSH key**: Path to the private key file that will be used for SSH authentication. Example: `/home/reditem/.ssh/reditem_rsa`	

## Bitbucket plugin

Configuration for the integration with Bitbucket.  

### Settings.

* **Enabled**: Is the bitbucket integration enabled?
* **Repository URL**: URL of the bitbucket repository.

## Database plugin

Plugin that creates a dump of the database and commits it. 

THIS PLUGIN ONLY HAS TO BE ENABLED IN THE SERVER SIDE.  

### Settings  

* **Dump database**: Enable the database dump?  
* **Commit message**: Commit message that will be used for database dumps.  

### Restoring a site
 * clone locally, under your server root
 * rename configuration.onl.php to configuration.php, and edit to adapt to your local station

in case you have to restore a site from scratch (specify the files to import in phpmyadmin, etc. ) notice that now we have 2 dumps for the same database. Something like:

 * `{db_name}_structure.sql` > includes only database structure
 * `{db_name}_data.sql` > includes the data for db tables

first time you setup a site you need to import data manually (or manually setup configuration file because you don't have access to redGIT GUI):
 * import first structure and then data
 * if you are restoring database from redGIT GUI it does that automatically
also from command line ( `php libraries/redgit/cli/restore.php` )
