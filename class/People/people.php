<?php
namespace People;

class people
{
    protected $code;
    protected $nom;
    protected $prenom;
    protected $email;
    protected $password;
    protected $class;


    public function getCode()
    {
        return $this->code;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function getPrenom()
    {
        return $this->prenom;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setAll($code,$email,$nom,$prenom){
        $this->code=$code;
        $this->email=$email;
        $this->prenom=$prenom;
        $this->nom=$nom;
    }

    public function verifyPassword($conn,$user,$pwd){
        mysqli_select_db($conn,'db_21912824_2');
        $query="select pwd_user from php_users where email_user='$user'";
        $result = mysqli_query($conn,$query);
        if($result->num_rows>0){
            while($rows=$result->fetch_row()) {
                if ($rows[0] = $pwd) {
                    return true;
                } else {
                    return false;
                }
            }

        }else{
            return false;
        }
    }


}

