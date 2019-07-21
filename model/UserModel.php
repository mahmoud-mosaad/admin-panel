<?php

class UserModel
{

    public function changePassword($email, $password){
        $edit = new QueryBuilder;
        $done = $edit->edit("email",$email,"users",[
            'password'=>$password
        ]);
        if ($done === true){
            return true;
        }
        else{
            return false;
        }
    }


    public function deleteToken($id)
    {
        $delete = new QueryBuilder;
        $delete->delete("tokens",'email',$id);

    }

    public function addToken($token, $email, $expire){
        $insert = new QueryBuilder;
        $insert->insert("tokens",[
            'token' => $token,
            'email' => $email,
            'expire'=> $expire
        ]);
    }

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
            'email' => $user->getEmail()
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

    public function retrieveAllWhere($table, $column, $value)
    {
        $select = new QueryBuilder;
        return $select->selectAllWhere($table, $column, $value);
    }

    public function retrieveAllUsers()
    {
        $select = new QueryBuilder;
        return $select->selectUsers();
    }

    public function retrieveSearchedUsers($table,$category,$value)
    {
        $select = new QueryBuilder;
        return $select->search($table,$category,$value);
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

    public function retrieveemail($id)
    {
        $select = new QueryBuilder;
        return $select->selectemail($id);
    }

    public function retrieveuser($email)
    {
        $select = new QueryBuilder;
        return $select->selectuser($email);
    }

    public function retrieveUserRoles($id)
    {
        $select = new QueryBuilder;
        return $select->selectUserRoles($id);
    }

    public function retrieveRecent($table)
    {
        $select = new QueryBuilder;
        return $select->Recent($table);
    }

    public function retrieveOlder($table)
    {
        $select = new QueryBuilder;
        return $select->Older($table);
    }
    public function retrieveOrderName($table,$order)
    {
        $select = new QueryBuilder;
        return $select->OrderByName($table,$order);
    }
    public function filter($table,$name,$email)
    {
        $select = new QueryBuilder;
        return $select->filter($table,$name,$email);
    }
}