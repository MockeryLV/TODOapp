
<nav>
    <div class="navblock">
        <a href="/todos">ToDo</a>
    </div>
    <?php if($_SESSION):?>
    <div class="navblock logout">

        <form action="/logout" method="get">
            <input class="logoutButton" type="submit" value="logout">
        </form>

    </div>
    <?php else:?>
        <div class="navblock logout">

            <form action="/register" method="get">
                <input class="logoutButton" type="submit" value="register">
            </form>

        </div>
    <?php endif;?>

</nav>