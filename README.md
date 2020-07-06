### WordPress offers three great hooks to help you take care of this:

1) register_activation_hook()
    This hook allows you to create a function that runs when your plugin is activated. It takes the path to your main plugin file as the first argument, and the function that you want to run as the second argument. You can use this to check the version of your plugin, do some upgrades between versions, check for the correct PHP version and so on.
2) register_deactivation_hook()
    The name says it all. This function works like its counterpart above, but it runs whenever your plugin is deactivated. I suggest using the next function when deleting data; use this one just for general housekeeping.
3) register_uninstall_hook()
    This function runs when the website administrator deletes your plugin in WordPress’ back end. This is a great way to remove data that has been lying around, such as database tables, settings and what not. A drawback to this method is that the plugin needs to be able to run for it to work; so, if your plugin cannot uninstall in this way, you can create an uninstall.php file. Check out this function’s documentation for more information.