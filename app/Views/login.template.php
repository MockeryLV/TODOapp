<?php

require_once 'partials/header.php';

?>
        


<div class="container">
    <div class="login">
        <form action="/checkout" method="post">
            <label>Username</label>
            <input name='username' type="text" placeholder="username...">
            <label>Password</label>
            <input name='password' type="password" placeholder="password...">
            <input type="submit" value="Login">
        </form>
    </div>
</div>



</body>
</html>