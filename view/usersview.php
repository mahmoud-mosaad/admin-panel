<?php require "helper/header.php"; ?>

        <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-table"></i>
            Users</div>
            <div class="card mb-3">
              <div class="card-body">
              <form action="./index.php?controller=UserController&method=add" method="POST">
                <input type="text" name="name" placeholder="Name" />
                <input type="email" name="email" placeholder="Email" />
                <input type="password" name="password" placeholder="Password" />

                <input type="password" name="password" placeholder="Confirm password">

                select <input type="checkbox" id="select" name="select" value="1">
                create <input type="checkbox" id="create" name="create" value="2">
                update <input type="checkbox" id="update" name="update" value="3">
                delete <input type="checkbox" id="delete" name="delete" value="4">
                <input type="submit" name="Create User" value="Add" />
              </form>
              </div>
            </div>

            <div class="card mb-3">
              <div class="card-body">
              <form  action="./index.php?controller=UserController&method=filter" method="post" class="right_table">
                    <input  type="text" name="name" placeholder="Name" value="<?=$name?>">
                    <input  type="text" name="email" placeholder="Email" value="<?=$email?>">

                    <input  type="submit" name="submit" value="Filter">

                    <input  type="submit" name="Recent" value="Recent">
                    <input  type="submit" name="Older" value="Older">
                    <input  type="submit" name="A-Z" value="A-Z">
                    <input  type="submit" name="Z-A" value="Z-A">
                </form>
              </div>
            </div>
            <!--   -->
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered"  width="100%" cellspacing="0">
                <thead>

                  <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Permitions</th>
                    <th></th>
                    <th></th>
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
                            <td>
                            select <input type=\"checkbox\" id=\"select\" name=\"select\" value=\"1\" ". (($roles[$user->id]['select'] == 1)?'checked':'') . ">
                            create <input type=\"checkbox\" id=\"create\" name=\"create\" value=\"2\" ". (($roles[$user->id]['create'] == 1)?'checked':'') . ">
                            update <input type=\"checkbox\" id=\"update\" name=\"update\" value=\"3\" ". (($roles[$user->id]['update'] == 1)?'checked':'') . ">
                            delete <input type=\"checkbox\" id=\"delete\" name=\"delete\" value=\"4\" ". (($roles[$user->id]['delete'] == 1)?'checked':'') . ">
                            </td>
                            <td>  <input type='submit' class='btn btn-primary' name='edit' value='Edit' /> </td>
                        </form>
                        <td><button class='btn btn-danger '><a class='simple_button' href='./index.php?delete={$user->id}&controller=UserController&method=delete'>Delete</a></button></td>
                    </tr>
                    ";
                    }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

<?php require "helper/footer.php"; ?>