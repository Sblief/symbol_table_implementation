<?php
class Processor
{
    public function process($data)
    {
        $tokens = preg_split('/[\s]+/', $data );

        $data1 = array(
            'relop' => array(),
            'method' => array(),
            'number' => array(),
            'id' => array(),
            'header' => array(),
            'condition' => array()
        );
        foreach ($tokens as $key => $token)
        {
            $token = str_replace(array(';', ','), '' , $token);
            if ($this->check_header($token)){
                if (!in_array($token,$data1['header'])){
                    array_push($data1['header'], $token);
                }

            }
            elseif ($this->check_method($token)){
                if (!in_array($token,$data1['method'])){
                    array_push($data1['method'], $token);
                }
            }
            elseif($this->check_number($token))
            {
                if (!in_array($token,$data1['number'])){
                    array_push($data1['number'], $token);
                }
            }
            elseif($this->check_letter($token))
            {
                if($this->check_condition($token))
                {
                    if (!in_array($token,$data1['condition'])){
                        array_push($data1['condition'], $token);
                    }
                }
                else{
                    if (!in_array($token,$data1['id'])){
                        array_push($data1['id'], $token);
                    }
                }
            }
            elseif($this->check_relop($token))
            {
                if (!in_array($token,$data1['relop'])){
                    array_push($data1['relop'], $token);
                }
            }
        }
echo "<pre>";
        $types  = array_keys($data1);
        echo "</pre>";

        $count = 1;
        echo "<table class='table table-bordered'>";
        foreach ($types as $key => $type){
            if (!empty($data1[$type])){
                echo "<tr><td>".$type."</td>"."<td>".$key."</td></tr>";
                $count++;
            }

        }
        echo "</table>";

        echo "<table class='table table-bordered'>";
        foreach ($data1 as $key => $d){
            foreach ($data1[$key] as $k => $value)
            if (!empty($value)){
                echo "<tr><td>".$value."</td>"."<td>".array_search($key, $types)."</td></tr>";

            }

        }
        echo "</table>";



    }

    public function check_header($data)
    {
        if (stripos($data, "#include") !== false) {
           return true;
        }
    }

    public function check_method($data)
    {
        if (stripos($data, "main") !== false) {
            return true;
        }
    }
    public function check_number($data)
    {
        if (is_numeric($data)) {
            return true;
        }
    }
    public function check_letter($data)
    {
        if (!preg_match('/[^A-Za-z0-9]/', $data))
        {
            return true;
        }
    }
    public function check_condition($data)
    {
        if(preg_match('(if|else|then)', $data) === 1) {
            return true;
        }
    }
    public function check_relop($data)
    {
        if(preg_match('(<|<=|>=|=|>)', $data) === 1) {
            return true;
        }
    }
}