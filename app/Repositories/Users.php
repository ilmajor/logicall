<?php

namespace App\Repositories;

use App\Models\User;

class Users
{
    public static function getUserByRole($roles)
    {
        return user::whereHas('roles', function ($query) use($roles) {
                 $query->whereIn('roles.name' ,$roles);
            })
            ->orderBy('users.name','asc')
            ->get();
    }
    public static function getUserOktellNumber($id)
    {
        return User::leftJoin('oktell.dbo.A_RuleRecords', 'A_RuleRecords.ReactID', '=', 'users.id_user')
            ->leftJoin('oktell.dbo.A_Rules', 'A_Rules.ID', '=', 'A_RuleRecords.RuleID')
            ->leftJoin('oktell.dbo.A_NumberPlanAction', 'A_NumberPlanAction.ExtraID', '=', 'A_Rules.ID')
            ->leftJoin('oktell.dbo.A_NumberPlan', 'A_NumberPlan.ID', '=', 'A_NumberPlanAction.NumID')
            ->where('users.id', '=', $id)
            ->select('users.*', 'Prefix')
            ->first();
    }
}

