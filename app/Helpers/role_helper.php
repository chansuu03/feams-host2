<?php

if(!function_exists('check_role')) {  
    function check_role($id, $mod, $role_id) {
        $rolePermissionModel = new Modules\Permissions\Models\RolePermissionModel();
        $data['rolePermission'] = $rolePermissionModel->where('role_id', $role_id)->get()->getResultArray();
        $access = false;
        $data['perm_id'] = [];
        $data['perm_access'] = false;
        foreach($data['rolePermission'] as $rolePermission) {
            if($rolePermission['perm_mod'] == $mod && $rolePermission['perm_id'] == $id) {
                $data['perm_access'] = true;
            }
            array_push($data['perm_id'], $rolePermission['perm_id']);
        }
        if($id === '' && $mod == '') {
            $data['perm_access'] = true;
        }
        return $data;
    }
}