


<?php foreach($users as $user): ?>

    <tr>

        <td><?php echo $user->id; ?></td>
        <td><input type="text" id="<?php echo 'n'.$user->id;?>" name="editname" value="<?php echo $user->name;?>"/></td>
        <td>  <input type="email" id="<?php echo 'e'.$user->id;?>" name="editemail" value="<?php echo $user->email; ?>" /></td>
        <td>
            select <input type="checkbox" id="<?php echo 's'.$user->id;?>" name="select" value="1" <?php echo (($roles[$user->id]['select'] == 1) ? 'checked' : '') ?> >
            create <input type="checkbox" id="<?php echo 'c'.$user->id;?>" name="create" value="2" <?php echo (($roles[$user->id]['create'] == 1) ? 'checked' : '') ?> >
            update <input type="checkbox" id="<?php echo 'u'.$user->id;?>" name="update" value="3" <?php echo (($roles[$user->id]['update'] == 1) ? 'checked' : '') ?> >
            delete <input type="checkbox" id="<?php echo 'd'.$user->id;?>" name="delete" value="4" <?php echo (($roles[$user->id]['delete'] == 1) ? 'checked' : '') ?> >
        </td>
        <?php if(!empty($userRoles) &&$userRoles[2]->auth == 1) : ?>
            <td>
                <button class='btn btn-primary' name="edit">
                    <a class='simple_button' href="edit?edit=<?php echo $user->id; ?>">
                        Edit
                    </a>
                </button>
            </td>
        <?php endif; ?>
        <?php if(!empty($userRoles) &&$userRoles[3]->auth == 1) : ?>
            <td>
                <button class='btn btn-danger'>
                    <a class='simple_button' href="delete?delete=<?php echo $user->id; ?>">
                        Delete
                    </a>
                </button>
            </td>
        <?php endif; ?>
        <td>
            <p id="<?php echo 'er'.$user->id;?>"></p>
        </td>


    </tr><br><br>

<?php endforeach; ?>




