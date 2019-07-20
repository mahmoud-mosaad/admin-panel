<!DOCTYPE html>
<html>
    <body>
        <h1>Add a new category !</h1>
        <form action="../../index.php" method="POST">
            <input type="text" name="name" placeholder="Name" />
            <textarea name="description"></textarea>
            <input type="submit" name="submit" />
        </form>
        <br/>
        <br/>
        <h1>Your categories ^_^</h1>
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th> Name </th>
                    <th> Description </th>
                </tr>
            </thead>
            <tbody>

                <?php
                    foreach($categorys as $category){
                    echo(
                    "
                    <tr>
                    <form action='./index.php?edit={$category->id}&controller=CategoryController&method=edit' method='POST'>
                            <td>  <input type='text' name='name' value={$category->name} /></td>
                            <td><textarea name='description'>{$category->description}</textarea> </td>
                            <td>  <input type='submit' name='edit' value='Edit' /> </td>
                    </form>
                    <td><button><a href='./index.php?delete={$category->id}&controller=CategoryController&method=delete'>delete</a></button></td>
                    </tr>
                    "
                    );
                    }
                ?>

    </body>
</html>