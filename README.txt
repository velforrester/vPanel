SETUP INSTRUCTIONS FOR vPanel version 1.4.2
-----------------------------------------------------------------------------------------------------------

Upload vPanel files (this folder) to the disired directory on your web server

Create the following tables in your database for use with vPanel:
- users [userId, password, fullName, email, userLevel, image, background, created, lastLogin]
- account_types [id, name, plugins, admin]

Add the following row to the account_types table:
- id = 0, name =  Administrator, plugins = 0, admin = 0

Add a row to the users table with userLevel Administrator

Configure vPanel by editing config.xml in the vPanel root folder. The important parts are database and root
(if your vPanel root folder is in the web root this value would be 'vPanel' if it's in a sub folder for exmple '"WEB ROOT"/subfolder/vPanel' the value would be 'subfolder/vPanel')

Set media folder permissions:
- chmod 700 media/users media/uploads from vPanel root

Build plugins:
- enter the plugins folder in the vPanel root folder
- register your plugin by editing plugins.xml
- add your plugin folder to the folder containing plugins.xml
- the plugin must be initilized by an index.phtml file in the folder you just created which will be launched in a popup when your plugin is clicked
- add plugin specific styles to plugins/css/styles.css
