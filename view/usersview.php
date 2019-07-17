<!DOCTYPE html>
<html>
    <body>
    <h1>Add a new user </h1>
    <form action="./index.php?controller=UserController&method=add" method="POST">
        <input type="text" name="name" placeholder="Name" />
        <input type="email" name="email" placeholder="Email" />
        <input type="password" name="password" placeholder="password" />

        <input type="password" name="password" placeholder="confirm password">

        select <input type="checkbox" id="select" name="select" value="1">
        create <input type="checkbox" id="create" name="create" value="2">
        update <input type="checkbox" id="update" name="update" value="3">
        delete <input type="checkbox" id="delete" name="delete" value="4">

        <input type="submit" name="Create User" />
    </form>
    <br/>
    <br/>

    <h1>The added users </h1>

    <form  action="./index.php?controller=UserController&method=search"  method="post">
        <input  type="text" name="value">
        <select name="search">
            <option value="name">By name</option>
            <option value="email">By email</option>
        </select>
        <input  type="submit" name="submit" value="Search">
    </form>

    <br/>

    <form  action="./index.php?controller=UserController&method=filter"  method="post">
        <input  type="text" name="name" placeholder="Name">
        <input  type="text" name="email" placeholder="Email">
        <input  type="submit" name="submit" value="Filter">
    </form>

    <br/>
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <button><a href='./index.php?controller=UserController&method=recentAdded'>Recent</a></button>
                <button><a href='./index.php?controller=UserController&method=OlderAdded'>Older</a></button>
                <button><a href='./index.php?controller=UserController&method=OrderNameA'>A-Z</a></button>
                <button><a href='./index.php?controller=UserController&method=OrderNameZ'>Z-A</a></button>
                <br/>
                <br/>
                <th> Id </th>
                <th> Name </th>
                <th> Email </th>
                <th> password </th>
            </tr>
        </thead>
        <tbody>

            <?php
                foreach($users as $user){
                echo
                "
                <tr>
                    <form action='./index.php?edit={$user->id}&controller=UserController&method=edit' method='POST'>
                        <td>{$user->id}</td>
                        <td><input type='text' name='name' value='{$user->name}' /></td>
                        <td>  <input type='email' name='email' value='{$user->email}' /></td>
                        <td>  <input type='text' name='password' value='{$user->password}' /></td>
                        <td>
                        select <input type=\"checkbox\" id=\"select\" name=\"select\" value=\"1\" ". (($roles[$user->id]['select'] == 1)?'checked':'') . ">
                        create <input type=\"checkbox\" id=\"create\" name=\"create\" value=\"2\" ". (($roles[$user->id]['create'] == 1)?'checked':'') . ">
                        update <input type=\"checkbox\" id=\"update\" name=\"update\" value=\"3\" ". (($roles[$user->id]['update'] == 1)?'checked':'') . ">
                        delete <input type=\"checkbox\" id=\"delete\" name=\"delete\" value=\"4\" ". (($roles[$user->id]['delete'] == 1)?'checked':'') . ">
                        </td>

                        <td>  <input type='submit' name='edit' value='Edit' /> </td>
                    </form>
                    <td><button><a href='./index.php?delete={$user->id}&controller=UserController&method=delete'>delete</a></button></td>
                </tr>
                ";
                }
            ?>

    </body>
</html>