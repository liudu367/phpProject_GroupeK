<?php

namespace question;


class question
{
    protected $code_que;
    protected $title_que;
    protected $content_que;
    protected $code_user_res;
    protected $status;
    protected $name_cours;
    protected $code_user;
    protected $uptime_ques;


    public function getAll()
    {
        $data[] = $this->code_que;
        $data[] = $this->title_que;
        $data[] = $this->content_que;
        $data[] = $this->code_user_res;
        $data[] = $this->status;
        $data[] = $this->name_cours;
        $data[] = $this->code_user;
        $data[] = $this->uptime_ques;

        return $data;
    }


    public function setAll($conn, $code_que)
    {
        mysqli_select_db($conn, 'db_21912824_2');
        $query
            = "select code_que, title_que, content_que, code_user_res, status, name_cours, code_user, uptime_que from php_question pq where pq.code_que=$code_que ";
        $result = mysqli_query($conn, $query);
        while ($rows = $result->fetch_row()) {
            $this->code_que = $rows[0];
            $this->title_que = $rows[1];
            $this->content_que = $rows[2];
            $this->code_user_res = $rows[3];
            $this->status = $rows[4];
            $this->name_cours = $rows[5];
            $this->code_user = $rows[6];
            $this->uptime_ques = $rows[7];
        }
    }


    public function getAllResponses($conn)
    {
        mysqli_select_db($conn, 'db_21912824_2');
        $query
            = "select pr.title_re,pr.content_re,pr.dt_re,concat(pu.fn_user,' ',pu.fn_user) 
               from php_responses pr, php_users pu 
               where pr.code_user = pu.code_user and  pr.code_que=$this->code_que
               order by pr.dt_re asc ";
        $result = mysqli_query($conn, $query);

        while ($rows = $result->fetch_row()) {
            $data[] = array(
                'title'      => $rows[0],
                'content'    => $rows[1],
                'dt'         => $rows[2],
                'respondent' => $rows[3],
            );
        }

        return json_encode($data);


    }


}