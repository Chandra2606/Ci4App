<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Hermawan\DataTables\DataTable;
use Myth\Auth\Models\UserModel;


class User extends BaseController
{
    public function index()
    {
        $title = [
            'title' => 'User'
        ];
        return view('users/datausers', $title);
    }

    public function view()
    {
        $db = db_connect();
        $user = $db
        ->table('users')
        ->select('fullname, username, email, auth_groups.id as group_id, users.active as aktif, users.id as iduser')
        ->join('auth_groups_users','user_id = users.id')
        ->join('auth_groups', 'group_id = auth_groups.id');
        return DataTable::of($user)
            ->edit('aktif', function ($row) {
                return ($row->aktif == 1) ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-danger">Tidak Aktif</span>';
            })
            ->edit('group_id', function ($row) {
                 if($row->group_id == 1){
                    return '<span class="badge bg-success">Admin</span>';
                } else if ($row->group_id == 2) {
                    return '<span class="badge bg-primary">Pimpinan</span>';
                } else{
                    return '<span class="badge bg-info">User</span>';
                }
                
            })
            ->add('action', function ($row) {
                $button1 = '<button type="button" class="btn btn-primary btn-sm btn-detail" data-iduser="' . $row->iduser . '" style="margin-left: 5px;"><i class="fas fa-eye"></i></button>';
                $button2 = '<button type="button" class="btn btn-secondary btn-sm btn-edit" data-iduser="' . $row->iduser . '" style="margin-left: 5px;"><i class="fas fa-pencil-alt"></i></button>';
                $button3 = '<button type="button" class="btn btn-danger btn-sm btn-delete" data-iduser="' . $row->iduser . '" style="margin-left: 5px;"><i class="fas fa-trash"></i></button>';
                $buttonsGroup = '<div style="display: flex;">' . $button1 . $button2 . $button3 . '</div>';
                return $buttonsGroup;
            }, 'last')
            ->addNumbering()
            ->hide('iduser')
            ->toJson();
    }
    public function detail($user_id = null)
    {
        $db = db_connect();
        $user = $db
            ->table('users')
            ->select('fullname, username, users.email, auth_groups.id as group_id, users.active as aktif, foto, name,')
            ->join('auth_groups_users', 'auth_groups_users.user_id = users.id')
            ->join('auth_groups', 'group_id = auth_groups.id')
            ->join('auth_logins', 'users.id = auth_logins.user_id')
            ->where('users.id', $user_id);
        $query = $user->get();    

      
        $data['users'] = $query->getRow();
        if (!$data['users']) {
            return redirect()->back();
        }

        return view('users/detailusers', $data);
    }

}
