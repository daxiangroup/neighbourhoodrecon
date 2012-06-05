<?php namespace Repositories;

class UserRepository {
	public static function save(\Entities\User $user, $user_id=null)
	{

        if (is_null($user_id))
        {
            return UserRepository::insert($user);
        }

        return $this->update($user);
	}

    private static function insert(\Entities\User $user)
    {
        $success = \Laravel\Database::table('user')->insert($user->get_table_array());
        if ( ! $success)
        {
            \Laravel\Log::write('error',
                \Laravel\Config::get('errorcodes.user_failed_save').': '.PHP_EOL .
                print_r($user,true)
            );
        }

        return $success;
    }

    private static function update(\Entities\User $user)
    {
        die('updating');
    }

    public static function retrieve($id)
    {
        // Validate a set id
        if (is_null($id) || ! isset($id))
        {
            \Laravel\Log::write('error',
                \Laravel\Config::get('errorcodes.user_id_must_be_set').': '.PHP_EOL .
                'Passed value: '.$id.PHP_EOL
            );
            return FALSE;
        }

        // Validate a numeric id
        if ( ! is_numeric($id))
        {
            \Laravel\Log::write('error',
                \Laravel\Config::get('errorcodes.user_id_must_be_numeric').': '.PHP_EOL .
                'Passed value: '.$id.PHP_EOL
            );
            return FALSE;
        }

        $user = \Laravel\Database::table('user')
            ->find($id);

        if ($user)
        {
            return $user;
        }

        \Laravel\Log::write('error',
            \Laravel\Config::get('errorcodes.user_not_found').': '.PHP_EOL .
            'Passed value: '.$id.PHP_EOL
        );
        return FALSE;
    }
}












