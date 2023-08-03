<?php

namespace App\Http\Controllers\Api\v1\Traits;

use Carbon\Carbon;
use Exception;
use Salaros\Vtiger\VTWSCLib\WSException;

trait HasVtigerApiQueryUtility
{
    /**
     * @throws WSException
     * @throws Exception
     */
    private function findMany(array $params = [])
    {
        if (isset($params['owner'])) {
            throw new Exception('feauture owner is not implemented yet');
        }
        if (isset($params['birthday'])) {
            //1 - day, 2 - year, 0 - month
            $date = explode('/', $params['birthday']);
            $params['birthday'] = Carbon::create($date[2], $date[0], $date[1])->format('Y-m-d');
        }

        return vtiger()->entities->findMany('Contacts', $params);
    }

    /**
     * @throws WSException
     */
    private function findUser(array $params = [])
    {
        $user = collect(vtiger()->entities->findMany('Users', $params))->map(fn ($user) => [
            'user_name' => $user['is_admin'],
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
            'status' => $user['status'],
            'is_admin' => $user['is_admin'],
            'title' => $user['title'],
            'phone_work' => $user['phone_work'],
            'department' => $user['department'],
            'phone_mobile' => $user['phone_mobile'],
            'userlabel' => $user['userlabel'],
            'address_street' => $user['address_street'],
            'address_city' => $user['address_city'],
            'address_state' => $user['address_state'],
            'address_postalcode' => $user['address_postalcode'],
            'address_country' => $user['address_country'],
            'description' => $user['description'],
            'email1' => $user['email1'],
        ])->first();

        return $user ?? 'Sin usuario asignado';
    }
}
