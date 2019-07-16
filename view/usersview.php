<!DOCTYPE html>
<html>
    <body>
    <h1>Add a new user </h1>
    <form action="./index.php?controller=UsersController&method=add" method="POST">
        <input type="text" name="name" placeholder="Name" />
        <input type="email" name="email" placeholder="Email" />
        <input type="password" name="password" placeholder="password" />
        <input type="submit" name="submit" />
    </form>
    <br/>
    <br/>

    <h1>The added users </h1>
    <form  method="post" action="search.php?go">
        <input  type="text" name="name">
        <input  type="submit" name="submit" value="Search">
	</form>
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th> Name </th>
                <th> Email </th>
                <th> password </th>
            </tr>
        </thead>
        <tbody>

            <?php
                foreach($users as $user){
                echo(
                "
                <tr>
                    <form action='./index.php?edit={$user->id}&controller=UsersController&method=edit' method='POST'>
                        <td><input type='text' name='name' value={$user->name} /></td>
                        <td>  <input type='email' name='email' value={$user->email} /></td>
                        <td>  <input type='text' name='password' value={$user->password} /></td>
                        <td>  <input type='submit' name='edit' value='Edit' /> </td>
                    </form>
                    <td><button><a href='./index.php?delete={$user->id}&controller=UsersController&method=delete'>delete</a></button></td>
                </tr>
                "
                );
                }
            ?>

    </body>
</html>