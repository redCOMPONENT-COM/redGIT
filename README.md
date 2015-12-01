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
