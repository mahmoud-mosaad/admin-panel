<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

    <form action="<?php echo BASEURL.'About/create';  ?>" method="post">
        <input type="text" name="description">
        <input type="submit" />
    </form>

    <br/>
    <br/>

    <?php

        foreach($abouts as $about){
        echo(
        "
        <tr>
            <form action='/admin-panel/About/edit/{$about->id}' method='POST'>
                <td><input type='text' name='description' value='{$about->description}' /></td>
                <td>  <input type='submit' name='edit' value='Edit' /> </td>
            </form>

            <td><button><a href='http://localhost:81/admin-panel/About/delete/{$about->id}'>delete</a></button></td>
        </tr>
        "
        );
        }

    ?>
<!-- <?php echo BASEURL.'User/register'; ?> -->
</body>
</html>