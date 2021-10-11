<?php

require_once 'partials/header.php';


?>


<body>



    <div class="container">

        <?php foreach ($todos as $todo):?>
            <div class="box">
                <?= $todo->getTitle() ?>
                <br>
                <?= 'Until: ' . $todo->getDue() ?>
                <br>
                <?php
                    if($todo->getStatus() === 'created'){

                        ?>
                        <form action="/setstatus" method="post">
                            <input hidden name="status" value="<?=$todo->getStatus()?>">
                            <input hidden name="id" value="<?=$todo->getId()?>">
                            <input class="submitButton" type="submit" class="status" value="Done?">
                        </form>
                        <?php
                    }else{ ?>
                        <form action="/setstatus" method="post">
                                <input hidden name="status" value="<?=$todo->getStatus()?>">
                                <input hidden name="id" value="<?=$todo->getId()?>">
                                <input class="submitButton" type="submit" class="status" value="Undone?">
                                </form>
                        <form action="/delete" method="post">
                            <input hidden name="id" value="<?=$todo->getId()?>">
                            <input class="submitButton" type="submit" value="X">
                        </form>
                <?php
                    }
                ?>

            </div>
        <?php endforeach;?>
        <div class="box">
            <form action="/create" method="get">
                <input  class="submitButton" type="submit" value="Add">
            </form>
        </div>
    </div>
</body>
</html>
