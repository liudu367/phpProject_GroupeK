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

    public function getNom()
    {
        return $this->nom;
    }

    public function getPrenom()
    {
        return $this->prenom;
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

    public function getMyCharge($conn)
    {
        $query = "select pq.code_que,pq.title_que,concat(p2.fn_user,' ',p2.ln_user), pq.status,pq.uptime_que 
                 from php_question pq, php_users p2 
                 where pq.code_user_res=$this->code  and p2.code_user = pq.code_user
                 order by pq.uptime_que desc";
        mysqli_select_db($conn, 'db_21912824_2');
        $result = mysqli_query($conn, $query);
        if ($result->num_rows > 0) {
            while ($rows = $result->fetch_row()) {
                $data[] = array(
                    'code'           => $rows[0],
                    'title'          => $rows [1],
                    'Question Asker' => $rows[2],
                    'status'         => $rows[3],
                    'update_time'    => $rows[4],
                );
            }

            return json_encode($data);
        } else {
            return null;
        }
    }

    public function getAdminBlock($conn)
    {
        mysqli_select_db($conn, 'db_21912824_2');
        $query
            = "select distinct php_course.name_cours from php_users, php_groups, php_course where php_users.code_user = $this->code and php_users.code_sec = php_groups.code_sec and php_groups.code_gp = php_course.code_gp";
        $result = mysqli_query($conn, $query);
        if ($result->num_rows > 0) {
            while ($rows = $result->fetch_row()) {
                $data[] = $rows[0];
            }

        }
        $data[] = "Autres";
        $data[] = "La vie universitaire";
        $data[] = "Les questions administratives";

        return json_encode($data);
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
                   where a1.code_gp = pg1.code_gp and pg1.code_sec = pu3.code_sec";
            $result = mysqli_query($conn, $query);
            while ($rows = $result->fetch_row()) {
                foreach ($index as $v) {
                    if ($rows[0] == $v) {
                        $data[$v][] = $rows[1];
                    }
                }
            }
            foreach ($data as $k) {
                foreach ($k as $v2) {
                    $transfer[] = $v2;
                }
            }
            $t1 = array_unique($transfer);
            foreach ($t1 as $v3) {
                $data["Autres"][] = $v3;
                $data["La vie universitaire"][] = $v3;
                $data["Les questions administratives"][] = $v3;
            }

            return json_encode($data);
        } else {
            return null;
        }

    }

    public function getTransferJson($conn, $codeQuesArr)
    {
        mysqli_select_db($conn, 'db_21912824_2');
        foreach ($codeQuesArr as $value) {
            $query = "select DISTINCT pu1.email_user
                        from php_question,php_course,php_users pu1, php_users pu2
                        where php_question.code_que = $value and php_question.name_cours = php_course.name_cours and php_course.code_prof = pu1.code_user and php_course.code_cours_respon = pu2.code_user
                        union 
                        select distinct pu2.email_user
                        from php_question,php_course,php_users pu1, php_users pu2
                        where php_question.code_que = $value and php_question.name_cours = php_course.name_cours and php_course.code_prof = pu1.code_user and php_course.code_cours_respon = pu2.code_user";
            $result = mysqli_query($conn, $query);
            if ($result->num_rows > 0) {
                while ($rows = $result->fetch_row()) {
                    $data[$value][] = $rows[0];
                }

            }
            $query = "select DISTINCT pu2.email_user
                      from  php_question,php_register,php_groups,php_users pu2
                      where php_question.code_que = $value and php_question.code_user = php_register.code_user and php_register.code_gp = php_groups.code_gp and php_groups.code_sec = pu2.code_sec ";
            $result = mysqli_query($conn, $query);
            if ($result->num_rows > 0) {
                while ($rows = $result->fetch_row()) {
                    $data[$value][] = $rows[0];
                }
            }
        }

        return json_encode($data);
    }

    public function getTransferAdminJson($conn)
    {
        mysqli_select_db($conn, 'db_21912824_2');

        $query
            = "select distinct a1.email_user
               from
               (select distinct pu2.email_user
               from php_users pu1,php_groups,php_course,php_users pu2  
               where pu1.code_user = $this->code and pu1.code_sec = php_groups.code_sec and php_course.code_gp = php_groups.code_gp and php_course.code_cours_respon = pu2.code_user
               union  
               select distinct pu2.email_user
               from php_users pu1,php_groups,php_course,php_users pu2  
               where pu1.code_user = $this->code and pu1.code_sec = php_groups.code_sec and php_course.code_gp = php_groups.code_gp and php_course.code_prof = pu2.code_user) as a1 ";
        $result = mysqli_query($conn, $query);
        if ($result->num_rows > 0) {
            while ($rows = $result->fetch_row()) {
                $data[] = $rows[0];
            }

        }

        $query = "select pu2.email_user
                  from php_users pu1, php_users pu2
                  where pu1.code_sec = pu2.code_sec
                  and pu1.code_user = $this->code
                  and pu2.code_user != $this->code";
        $result = mysqli_query($conn, $query);
        if ($result->num_rows > 0) {
            while ($rows = $result->fetch_row()) {
                $data[] = $rows[0];
            }
        }

        return json_encode($data);
    }

    public function getMyCourseTableHTML($conn)
    {
        $code = $this->getCodeUser();
        $query = " 
            select DISTINCTROW pc.name_cours,pc.type_cours,pc.dt_cours,pc.code_cours
            from php_course pc, php_users pu1,php_groups pg, php_users pu2 
            where pc.code_prof = '$code'
            and pc.code_gp = pg.code_gp
            and pg.code_sec = pu2.code_sec
            and pu1.code_user = pc.code_prof
            order by pc.dt_cours";
        $result = mysqli_query($conn, $query);
        if ($result->num_rows > 0) {
            while ($rows = $result->fetch_row()) {
                $data[] = array(
                    "name_course" => $rows[0],
                    "type_course" => $rows[1],
                    "dt_course"   => $rows[2],
                    "code_course" => $rows[3],
                );
            }

            return json_encode($data);
        } else {
            return null;
        }


    }

    public function getCodeUser()
    {
        return $this->code;
    }

    public function getMyDemandProf($conn)
    {
        $code = $this->getCodeUser();
        $query
            = "select code_dem,dt_cours_org, dt_cours_new, updt_dem, status_dem, code_cours, email_admin from php_demand where php_demand.code_user = '$code' order by updt_dem desc limit 5 ";
        mysqli_select_db($conn, 'db_21912824_2');
        $result = mysqli_query($conn, $query);
        if ($result->num_rows > 0) {
            while ($rows = $result->fetch_row()) {
                $data[] = array(
                    "code_dem"     => $rows[0],
                    "dt_cours_org" => $rows[1],
                    "dt_cours_new" => $rows[2],
                    "updt_dem"     => $rows[3],
                    "status_dem"   => $rows[4],
                    "code_cours"   => $rows[5],
                    "email_admin"  => $rows[6],
                );
            }

            return json_encode($data);
        }

        return null;
    }

    public function getMyDemandAdmin($conn)
    {
        $email = $this->getEmail();
        $query
            = "select code_dem, dt_cours_org, dt_cours_new,  updt_dem, status_dem, code_cours,CONCAT(php_users.fn_user,'',php_users.ln_user) , email_admin from php_demand,php_users where php_demand.email_admin = '$email' and php_demand.code_user = php_users.code_user";
        $result = mysqli_query($conn, $query);
        mysqli_select_db($conn, 'db_21912824_2');
        if ($result->num_rows > 0) {
            while ($rows = $result->fetch_row()) {
                $data[] = array(
                    "code_dem"     => $rows[0],
                    "dt_cours_org" => $rows[1],
                    "dt_cours_new" => $rows[2],
                    "updt_dem"     => $rows[3],
                    "status_dem"   => $rows[4],
                    "code_cours"   => $rows[5],
                    "prof_demand"  => $rows[6],
                    "email_admin"  => $rows[7],
                );
            }

            return json_encode($data);
        }

        return null;


    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getMyCourseTable($conn)
    {
        mysqli_select_db($conn, 'db_21912824_2');
        $code = $this->getCodeUser();

        $query = "select DISTINCTROW pc.name_cours
                from php_course pc, php_users pu1,php_groups pg, php_users pu2 
                where pc.code_prof = '$code'
                and pc.code_gp = pg.code_gp
                and pg.code_sec = pu2.code_sec
                and pu1.code_user = pc.code_prof
                order by pc.dt_cours";
        $result = mysqli_query($conn, $query);
        if ($result->num_rows > 0) {
            while ($rows = $result->fetch_row()) {
                $data[$rows[0]] = array();
            }
            $query = "select DISTINCTROW pc.name_cours,pc.type_cours
                from php_course pc, php_users pu1,php_groups pg, php_users pu2 
                where pc.code_prof = '$code'
                and pc.code_gp = pg.code_gp
                and pg.code_sec = pu2.code_sec
                and pu1.code_user = pc.code_prof
                order by pc.dt_cours";
            $result = mysqli_query($conn, $query);

            if ($result->num_rows > 0) {
                $index = array_keys($data);
                while ($rows = $result->fetch_row()) {
                    foreach ($index as $value) {
                        if ($rows[0] == $value) {
                            $data[$value][$rows[1]] = array();
                        }
                    }
                }

            }
            $query = " 
            select DISTINCTROW pc.name_cours,pc.type_cours,pc.dt_cours,pc.code_cours
            from php_course pc, php_users pu1,php_groups pg, php_users pu2 
            where pc.code_prof = '$code'
            and pc.code_gp = pg.code_gp
            and pg.code_sec = pu2.code_sec
            and pu1.code_user = pc.code_prof
            order by pc.dt_cours";
            $result = mysqli_query($conn, $query);

            $index = array_keys($data);


            while ($rows = $result->fetch_row()) {
                foreach ($index as $value) {
                    $index1 = array_keys($data[$value]);
                    foreach ($index1 as $value2) {
                        if ($rows[0] == $value and $rows[1] == $value2) {
                            $data[$value][$value2][$rows[2]] = $rows[3];
                        }
                    }
                }
            }


            return json_encode($data);
        } else {
            return null;
        }
    }

    public function getMyCourseAdmin($conn)
    {
        mysqli_select_db($conn, 'db_21912824_2');
        $code = $this->getCodeUser();

        $query = "select DISTINCT  pc.name_cours
                   from php_course pc, php_users pu1,php_groups pg, php_users pu2 
                   where pc.code_prof = '$code'
                     and pc.code_gp = pg.code_gp
                     and pg.code_sec = pu2.code_sec
                     and pu1.code_user = pc.code_prof
                     order by pc.dt_cours";
        $result = mysqli_query($conn, $query);
        if ($result->num_rows > 0) {
            while ($rows = $result->fetch_row()) {
                $g = $rows[0];
                $data[$g] = array();
            }

            $query = "select DISTINCT  pc.name_cours, pu2.email_user
                   from php_course pc, php_users pu1,php_groups pg, php_users pu2 
                   where pc.code_prof = '$code'
                     and pc.code_gp = pg.code_gp
                     and pg.code_sec = pu2.code_sec
                     and pu1.code_user = pc.code_prof
                     order by pc.dt_cours";
            $result = mysqli_query($conn, $query);
            $index = array_keys($data);

            while ($rows = $result->fetch_row()) {
                foreach ($index as $value) {
                    if ($rows[0] == $value) {
                        $data[$value][] = $rows[1];
                    }
                }
            }

            return json_encode($data);
        } else {
            return null;
        }


    }

    public function getMyCourse($conn)
    {
        mysqli_select_db($conn, 'db_21912824_2');
        $code = $this->getCodeUser();

        $query = "select DISTINCT  pc.name_cours
                   from php_course pc, php_users pu1,php_groups pg, php_users pu2 
                   where pc.code_prof = '$code'
                     and pc.code_gp = pg.code_gp
                     and pg.code_sec = pu2.code_sec
                     and pu1.code_user = pc.code_prof
                     order by pc.dt_cours";
        $result = mysqli_query($conn, $query);
        if ($result->num_rows > 0) {
            while ($rows = $result->fetch_row()) {
                $g = $rows[0];
                $data[$g] = array();
            }

            return json_encode($data);
        } else {
            return null;
        }


    }


}
//


