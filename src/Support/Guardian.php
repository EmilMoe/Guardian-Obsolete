<?php

namespace EmilMoe\Guardian\Support;

use Illuminate\Support\Facades\Auth;

/**
 * Class Guardian
 * @package EmilMoe\Guardian\Guardian\Support
 */
class Guardian
{
    /**
     * @return mixed
     */
    public static function getUserTable()
    {
        return with(self::_getUser())->getTable();
    }

    /**
     * @return mixed
     */
    public static function getUserKey()
    {
        return with(self::_getUser())->getKeyName();
    }

    /**
     * @return bool
     */
    public static function hasClients()
    {
        return config('guardian.client') != null;
    }

    /**
     * @return mixed
     */
    public static function getClientTable()
    {
        return self::_getClient()->getTable();
    }

    /**
     * @return mixed
     */
    public static function getClientKey()
    {
        return self::_getClient()->getKeyName();
    }

    /**
     * @return string
     */
    public static function getClientColumn()
    {
        return self::getClientTable() .'_'. self::getClientKey();
    }

    /**
     * @return mixed
     */
    public static function getClientId()
    {
        return Auth::user()->{config('guardian.client.relation')};

        foreach (config('guardian.client') as $step)
            $user = $user->{$step};

        return $user;
    }

    /**
     * @return string
     */
    public static function getRolesPermissionsTable()
    {
        return config('guardian.table.role') .'_'. config('guardian.table.permission');
    }

    /**
     * @return string
     */
    public static function getUsersRolesTable()
    {
        return self::getUserTable() .'_'. config('guardian.table.role');
    }

    /**
     * @return mixed
     */
    public static function getUserClass()
    {
        return config('guardian.user.model');
    }

    /**
     * @return mixed
     */
    public static function getPermissionTable()
    {
        return config('guardian.table.permission');
    }

    /**
     * @return mixed
     */
    public static function getClientClass()
    {
        return config('guardian.client.model');
    }

    /**
     * @return mixed
     */
    private static function _getUser()
    {
        $user = self::getUserClass();
        return new $user;
    }

    /**
     * @return mixed
     */
    private static function _getClient()
    {
        $client = self::getClientClass();
        return new $client;
    }
}