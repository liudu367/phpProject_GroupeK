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


    public function getClass()
    {

        return $this->class;
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

    public function getCourses($conn, $email)
    {
        mysqli_select_db($conn, 'db_21912824_2');
        $query = "select DISTINCTROW php_course.name_cours
        from php_users,php_register,php_groups,php_course
        where php_users.code_user=php_register.code_user
        and php_register.code_gp=php_groups.code_gp
        and php_groups.code_gp=php_course.code_gp
        and php_users.class_user='$this->class'
        and php_users.email_user='$email'";
        $result = mysqli_query($conn, $query);
        if ($result->num_rows > 0) {
            return $result;
        }
    }


    public function getJSONCourses($conn)
    {
        mysqli_select_db($conn, 'db_21912824_2');
        $query = "select DISTINCT php_users.email_user, php_course.name_cours,php_course.type_cours,php_course.code_gp,pu1.email_user
                    from php_users,php_register,php_groups,php_course,php_users pu1
                    where php_users.code_user=php_register.code_user
                    and php_register.code_gp=php_groups.code_gp
                    and php_groups.code_gp=php_course.code_gp
                    and php_users.email_user='$this->email'
                    and php_course.code_prof = pu1.code_user";
        $result = mysqli_query($conn, $query);
        while ($rows = $result->fetch_row()) {
            $select[] = array($rows[1], $rows[4]);
        }

        return json_encode($select);
    }
}


