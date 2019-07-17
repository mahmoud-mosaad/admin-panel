<?php

class UserModel
{

    public function add(User $user)
    {
        $insert = new QueryBuilder;
        $insert->insert("users",[
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'password'=>$user->getPassword()
        ]);

        $id = $this->retrieve($user->getEmail())['id'];

        foreach ($user->getRoles() as $item){
            $insert->insert("user_roles",[
                'user_id' => $id,
                'role_id' => $item[0],
                'auth' => $item[1]
            ]);
        }

    }

    public function edit(User $user, $id)
    {

        $edit = new QueryBuilder;
        $edit->edit("id",$id,"users",[
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'password'=>$user->getPassword()
        ]);

        foreach ($user->getRoles() as $item){
            $edit->editRoles("user_id",$id,"role_id",$item[0],"user_roles",[
                'auth' => $item[1]
            ]);
        }


    }

    public function delete($id)
    {
        $delete = new QueryBuilder;
        $delete->delete("users",'id',$id);
        $delete->delete("user_roles",'user_id',$id);

    }

    public function retrieveAll($table)
    {
        $select = new QueryBuilder;
        return $select->selectAll($table);
    }

    public function retrieveAllUsers()
    {
        $select = new QueryBuilder;
        return $select->selectUsers();
    }

    public function retrieveAllUsersRoles($users){
        $select = new QueryBuilder;
        return $select->selectUsersRoles($users);
    }

    public function retrieve($email)
    {
        $select = new QueryBuilder;
        return $select->selectid($email);
    }

}