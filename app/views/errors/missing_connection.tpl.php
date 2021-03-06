<div style="margin-left:120px">
<h1>No iPeer database found. You may want to run <a href="/install">installation</a> first. Otherwise make sure you define in it <u><tt>app/config/database.php</tt></u> in the following format:</h1>

<pre style="background-color:#FFFFDD;">
&lt;?php
class DATABASE_CONFIG {
var $default = array('driver'   => 'mysql',
                     'connect'  => 'mysql_pconnect',
                     'host'     => 'your_ipeer_host',
                     'login'    => 'your_mysql_login',
                     'password' => 'your_mysql_password',
                     'database' => 'your_ipeer_database_in_mysql',
                     'prefix'   => 'prefix_(if_any)');  }
?&gt;</pre>
For more details, also see this file:
<u><tt>app/config/database.php.default</tt></u>.
</div>
