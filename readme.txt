== Installation ==
 
1.)Add files /wp-content/plugins/auth-server
2.)Activate plugin from wp admin
3.)Create a tab Generate Tokens in dashboard


== Feature ==

1.) This plugin(Auth Server) basically copy user info from remote server database to client server database.
2.) This plugin will not work individual you need to install our other plugin (Plugin :Auth Client) to your client server.
3.) 
Using Generate Token we can add multiple website url using "Add Site" .
that will automatic generate a unique token for every site.

for example :you added site :http://localhost/user it generate a unique number 207992f6377433e860064f22deb7a731

This unique number, you have to add to client server(for ex :http://localhost/user) so that userinfo can be shared between both remote server (for ex:http://localhost/latestwp) and client server(http://localhost/user)

This plugin will not work individual you need to activate other plugin at client server
	
