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


    public function getCodeUser()
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

    public function getFullname($conn, $codeuser)
    {
        mysqli_select_db($conn, 'db_21912824_2');
        $query
            = "select concat(pu.fn_user,' ',pu.ln_user) from php_users pu where code_user = $codeuser ";
        $result = mysqli_query($conn, $query);
        while ($rows = $result->fetch_row()) {
            $name = $rows[0];
        }

        return $name;
    }


    public function setUserPara($conn, $username)
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

    public function verifyPassword($conn, $username, $pwd)
    {
        mysqli_select_db($conn, 'db_21912824_2');
        $query
            = "select code_user, class_user, pwd_user, email_user, fn_user, ln_user from php_users  where email_user='$username'";
        $result = mysqli_query($conn, $query);
        if ($result->num_rows > 0) {
            while ($rows = $result->fetch_row()) {
                if ($rows[2] == $pwd) {
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


    public function getCoursJson_stu($conn)
    {
        mysqli_select_db($conn, 'db_21912824_2');
//        get all courses of this student
        $query = "select DISTINCT php_course.name_cours
                    from php_users,php_register,php_groups,php_course,php_users pu1
                    where php_users.code_user=php_register.code_user
                    and php_register.code_gp=php_groups.code_gp
                    and php_groups.code_gp=php_course.code_gp
                    and php_users.email_user='$this->email'
                    and php_course.code_prof = pu1.code_user";
        $result = mysqli_query($conn, $query);
        while ($rows = $result->fetch_row()) {
            $g = $rows[0];
            $data[$g] = array();
        }
        $data["La vie universitaire"] = array();
        $data["Les questions administratives"] = array();
        $index = array_keys($data);
        $query = "select DISTINCT php_course.name_cours,pu1.email_user
                    from php_users,php_register,php_groups,php_course,php_users pu1
                    WHERE php_users.code_user=php_register.code_user
                    and php_register.code_gp=php_groups.code_gp
                    and php_groups.code_gp=php_course.code_gp
                    and php_users.email_user='$this->email'
                    and php_course.code_cours_respon = pu1.code_user
                    UNION
                  select DISTINCT php_course.name_cours,pu1.email_user
                    from php_users,php_register,php_groups,php_course,php_users pu1
                    WHERE php_users.code_user=php_register.code_user
                    and php_register.code_gp=php_groups.code_gp
                    and php_groups.code_gp=php_course.code_gp
                    and php_users.email_user='$this->email'
                    and php_course.code_prof = pu1.code_user";
        $result = mysqli_query($conn, $query);
        while ($rows = $result->fetch_row()) {
            foreach ($index as $v) {
                if ($rows[0] == $v) {
                    $data[$v][] = $rows[1];
                }
            }
        }
        $query = "select DISTINCTROW pu1.email_user
                    from php_users, php_register,php_groups,php_secretariat,php_users pu1
                    where 
                    php_users.email_user='$this->email'
                    and php_users.code_user=php_register.code_user
                    and php_register.code_gp = php_groups.code_gp
                    and php_groups.code_sec=php_secretariat.code_sec
                    and pu1.code_sec = php_secretariat.code_sec";
        $result = mysqli_query($conn, $query);
        while ($rows = $result->fetch_row()) {
            foreach ($index as $v) {
                if ($v == "La vie universitaire" or $v
                    == "Les questions administratives"
                ) {
                    $data[$v][] = $rows[0];
                }
            }

        }

        return json_encode($data);
    }

    public function getAllThreadQues($conn, $thread)
    {
        $query = "select pq.code_que,pq.title_que,concat(p1.fn_user,' ',p1.ln_user),concat(p2.fn_user,' ',p2.ln_user), pq.status,pq.uptime_que 
                 from php_question pq, php_users p1, php_users p2 
                 where pq.name_cours='$thread' and p1.code_user = pq.code_user and p2.code_user = pq.code_user_res";
        mysqli_select_db($conn, 'db_21912824_2');
        $result = mysqli_query($conn, $query);
        if ($result->num_rows > 0) {
            while ($rows = $result->fetch_row()) {
                $data[] = array(
                    'code'           => $rows[0],
                    'title'          => $rows [1],
                    'Question Asker' => $rows[2],
                    'Respondent'     => $rows[3],
                    'status'         => $rows[4],
                    'update_time'    => $rows[5],
                );
            }

            return json_encode($data);
        } else {
            return null;
        }

    }


    public function getStuThreadQues($conn, $thread)
    {
        $query = "select pq.code_que,pq.title_que,concat(p1.fn_user,' ',p1.ln_user),concat(p2.fn_user,' ',p2.ln_user), pq.status,pq.uptime_que 
                 from php_question pq, php_users p1, php_users p2 
                 where pq.name_cours='$thread' and p1.code_user = pq.code_user and p2.code_user = pq.code_user_res
                 and p1.code_user not in (select p3.code_user from php_users p3 where p3.class_user = 1)
                 ";
        mysqli_select_db($conn, 'db_21912824_2');
        $result = mysqli_query($conn, $query);
        if ($result->num_rows > 0) {
            while ($rows = $result->fetch_row()) {
                $data[] = array(
                    'code'           => $rows[0],
                    'title'          => $rows [1],
                    'Question Asker' => $rows[2],
                    'Respondent'     => $rows[3],
                    'status'         => $rows[4],
                    'update_time'    => $rows[5],
                );
            }

            return json_encode($data);
        } else {
            return null;
        }

    }


    public function getMyQuestions($conn)
    {
        $query = "select pq.code_que,pq.title_que,concat(p2.fn_user,' ',p2.ln_user), pq.status,pq.uptime_que 
                 from php_question pq, php_users p2 
                 where pq.code_user=$this->code  and p2.code_user = pq.code_user_res
                 order by pq.uptime_que desc";
        mysqli_select_db($conn, 'db_21912824_2');
        $result = mysqli_query($conn, $query);
        if ($result->num_rows > 0) {
            while ($rows = $result->fetch_row()) {
                $data[] = array(
                    'code'        => $rows[0],
                    'title'       => $rows [1],
                    'Respondent'  => $rows[2],
                    'status'      => $rows[3],
                    'update_time' => $rows[4],
                );
            }

            return json_encode($data);
        } else {
            return null;
        }
    }


    public function getMyParti($conn)
    {
        $query = "select DISTINCTROW pq.code_que,pq.title_que,concat(p1.fn_user,' ',p1.ln_user),concat(p2.fn_user,' ',p2.ln_user), pq.status,pq.uptime_que
                    from php_responses pr, php_question pq, php_users p1,php_users p2
                    where pr.code_user ='$this->code' and pr.code_que = pq.code_que
                    and p1.code_user = pq.code_user and p2.code_user = pq.code_user_res
                    order by pq.uptime_que desc";
        mysqli_select_db($conn, 'db_21912824_2');
        $result = mysqli_query($conn, $query);
        if ($result->num_rows > 0) {
            while ($rows = $result->fetch_row()) {
                $data[] = array(
                    'code'           => $rows[0],
                    'title'          => $rows[1],
                    'Question Asker' => $rows[2],
                    'Respondent'     => $rows[3],
                    'status'         => $rows[4],
                    'update_time'    => $rows[5],
                );
            }


            return json_encode($data);
        } else {
            return null;
        }
    }


    public function getProfJson($conn)
    {
        mysqli_select_db($conn, 'db_21912824_2');
        /*get all the courses of this professor Whether he is the teacher in charge or a teaching teacher*/
        $query
            = "select distinctrow a1.name_cours
               from( select pc1.name_cours from php_users pu1, php_course pc1 where pu1.code_user = pc1.code_prof and pu1.email_user='$this->email'
               union 
               select pc2.name_cours from php_users pu2, php_course pc2 where pu2.code_user = pc2.code_cours_respon and pu2.email_user='$this->email') as a1";
        $result = mysqli_query($conn, $query);
        if ($result->num_rows > 0) {
            while ($rows = $result->fetch_row()) {
                $g = $rows[0];
                $data[$g] = array();
            }
            $data["Autres"] = array();
            $data["La vie universitaire"] = array();
            $data["Les questions administratives"] = array();
            $index = array_keys($data);

            $query = "select distinctrow a1.name_cours,pu3.email_user
                  from( select pc1.code_gp,pc1.name_cours from php_users pu1, php_course pc1 where pu1.code_user = pc1.code_prof and pu1.email_user='$this->email'
                        union 
                        select pc2.code_gp,pc2.name_cours from php_users pu2, php_course pc2 where pu2.code_user = pc2.code_cours_respon and pu2.email_user='$this->email') as a1,
                        php_groups pg1, php_users pu3
                   where a1.code_gp = pg1.code_gp and pg1.code_sec = pu3.code_sec ";
            $result = mysqli_query($conn, $query);
            while ($rows = $result->fetch_row()) {
                foreach ($index as $v) {
                    if ($rows[0] == $v) {
                        $data[$v][] = $rows[1];
                    } elseif ($v == "Autres") {
                        $data[$v][] = $rows[1];
                    }
                }
            }

            return json_encode($data);
        } else {
            return null;
        }

    }


}
//


