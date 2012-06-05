<?php namespace Entities;

class User {
    public $id;
    public $firstName;
    public $lastName;
    public $email;
    public $password;

    public function __construct()
    {
        $args = func_get_args();
        echo '<pre>'.print_r($args,true).'</pre>';

        if (is_array($args[0]))
        {
            $data = $args[0];
            $this->firstName = $data['firstName'];
            $this->lastName = $data['lastName'];
            $this->email = $data['email'];
            $this->password = $data['password'];
        }

        if (is_numeric($args[0]))
        {
            $data = \Repositories\UserRepository::retrieve($args[0]);
            $this->firstName = $data->first_name;
            $this->lastName = $data->last_name;
            $this->email = $data->email;
            $this->password = $data->password;
        }


        $options = isset($args[1]) ? $args[1] : FALSE;
        if ($options['hash_password'] === TRUE)
        {
            $this->hash_password();
        }
    }

    public function hash_password()
    {
        $this->password = \Laravel\Hash::make($this->password);
    }

    public function get($key)
    {
        if (isset($this->$key))
        {
            return $this->$key;
        }

        return FALSE;
    }

    public function get_table_array()
    {
        $data = array(
            'email' => $this->email,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'password' => $this->password,
        );

    return $data;
    }
}