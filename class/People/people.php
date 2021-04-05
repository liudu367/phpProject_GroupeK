<?php
namespace People;

class people
{
    protected $code;
    protected $class;
    protected $password;
    protected $email;
    protected $prenom;
    protected $nom;


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

    public function setAll($conn, $username)
    {
        mysqli_select_db($conn, 'db_21912824_2');
        $query
            = "select code_user, class_user, pwd_user, email_user, fn_user, ln_user from php_users  where email_user='$username'";
        $result = mysqli_query($conn, $query);
        if ($result->num_rows > 0) {
            while ($rows = $result->fetch_row()) {
                $this->code = $rows[0];
                $this->class = $rows[1];
                $this->password = $rows[2];
                $this->email = $rows[3];
                $this->prenom = $rows[4];
                $this->nom = $rows[5];
            }
        }


    }

    public function verifyPassword($conn, $user, $pwd)
    {
        mysqli_select_db($conn, 'db_21912824_2');
        $query = "select pwd_user from php_users where email_user='$user'";
        $result = mysqli_query($conn, $query);
        if ($result->num_rows > 0) {
            while ($rows = $result->fetch_row()) {
                if ($rows[0] = $pwd) {
                    return true;
                } else {
                    return false;
                }
            }

        } else {
            return false;
        }
    }


}

